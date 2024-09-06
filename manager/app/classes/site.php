<?php

namespace App\Classes;

use App\Classes\Database;

class Site
{
	public static function getUrl($site_id, $https = true)
	{
		$type = ($https) ? 'https' : 'http';

		$site = Database::single('SELECT name, port, type FROM site s
			INNER JOIN endpoint e on e.instance_id=s.httpd_instance_id WHERE type=? AND s.id=?', $type, $site_id);

		if ($https)
			$port = ($site['port'] == '443') ? '' : ':'.$site['port'];
		else
			$port = ($site['port'] == '80') ? '' : ':'.$site['port'];

		return "$type://{$site['name']}$port";
	}

	public static function getAll()
	{
		return Database::all('SELECT * FROM site ORDER BY name');
	}

	public static function getById($id)
	{
		return Database::single('SELECT * FROM site WHERE id=?', $id);
	}

	/**
	 * Convert user input csv string to array skipping empty
	 * values.
	 */
	private static function _stringToCleanAliasArray($str)
	{
		$clean = [];

		foreach (explode(',', $str) as $alias)
			if (trim($alias) != '')
				array_push($clean, trim($alias));

		return array_unique($clean);
	}

	public static function create($name, $aliases, $document_root, $httpd_instance_id, $php_instance_id)
	{
		debug("********************************************************************************");
		debug("* Site::create()");
		debug("********************************************************************************");
		debug("* \$name: $name");
		debug("* \$aliases: $aliases");
		debug("* \$document_root: $document_root");
		debug("* \$httpd_instance_id: $httpd_instance_id");
		debug("* \$php_instance_id: $php_instance_id");

		$name || die();

		$aliases = static::_stringToCleanAliasArray($aliases);

		$ca = new CA(APP_PATH."\\private");

		$ca->generate($name, $aliases, $ssl_key, $ssl_crt);

		$document_root = rtrim($document_root, DS);

		if ($document_root == '')
		{
			if (!is_dir(SITE_PATH."\\$name"))
				mkdir(SITE_PATH."\\$name");

			$document_root = SITE_PATH."\\$name";
		}

		# create new entry in site table
		$site_id = Database::insert('INSERT INTO site (name, ssl_key, ssl_crt, document_root, httpd_instance_id, php_instance_id)
			VALUES (?,?,?,?,?,?)', $name, $ssl_key, $ssl_crt, $document_root, $httpd_instance_id, $php_instance_id);

		##########################################################################################
		# add each alias to the alias table
		##########################################################################################
		foreach ($aliases as $alias)
			Database::insert('INSERT INTO alias (site_id, alias) VALUES (?,?)', $site_id, $alias);
		##########################################################################################

		# if assigned to a web server, create configs and restart it
		if ($httpd_instance_id != null)
		{
			static::_make($site_id);
			Package::control($httpd_instance_id, 'restart');
		}

		debug("********************************************************************************");

		return $site_id;
	}

	public static function update($site_id, $name, $aliases, $document_root, $httpd_instance_id, $php_instance_id)
	{
		# get existing settings
		$existing = static::getById($site_id);

		$document_root = rtrim($document_root, DS);

		if ($document_root == '')
		{
			if (!is_dir(SITE_PATH."\\$name"))
				mkdir(SITE_PATH."\\$name");

			$document_root = SITE_PATH."\\$name";
		}

		##########################################################################################
		# remove existing domain and aliases from hosts
		##########################################################################################
		$hosts = new Hosts();

		$hosts->remove($existing['name']);
    	#
    	# remove aliases from hosts
    	$existing_aliases = Database::all('SELECT alias FROM alias WHERE site_id=?', $site_id);
    	#
		foreach ($existing_aliases as $alias)
			$hosts->remove($alias['alias'].".".$existing['name']);

		$hosts->save();
		##########################################################################################

		$aliases = static::_stringToCleanAliasArray($aliases);

		$ca = new CA(APP_PATH."\\private");

		$ca->generate($name, $aliases, $ssl_key, $ssl_crt);

		$document_root = rtrim($document_root, DS);

		# update site with new values
		Database::execute('UPDATE site SET name=?, ssl_key=?, ssl_crt=?, document_root=?, httpd_instance_id=?, php_instance_id=? WHERE id=?', $name, $ssl_key, $ssl_crt, $document_root, $httpd_instance_id, $php_instance_id, $site_id);

		##########################################################################################
		# delete existing aliases
		##########################################################################################
		Database::execute('DELETE FROM alias WHERE site_id=?', $site_id);
		#
		##########################################################################################
		# add each alias to the alias table
		##########################################################################################
		foreach ($aliases as $alias)
			Database::insert('INSERT INTO alias (site_id, alias) VALUES (?,?)', $site_id, $alias);
		##########################################################################################

		# if the webserver is being changed and originating server was not null
		if ($existing['httpd_instance_id'] != $httpd_instance_id && $existing['httpd_instance_id'] != null)
		{
			# delete configs
			$instance = Database::single('SELECT * FROM instance WHERE id=?', $existing['httpd_instance_id']);
			Util::del(BIN_PATH.'\\'.$instance['name'].'\\conf\\vhosts\\'.$existing['name'].'.*');

			# restart
			Package::control($existing['httpd_instance_id'], 'restart');
		}

		# is the site being assigned to a server?
		if ($httpd_instance_id != null)
		{
			# create new configs for target server
			static::_make($site_id);

			# restart target server
			Package::control($httpd_instance_id, 'restart');
		}
	}

	public static function delete($site_id)
	{
		# Get which web server this is assigned to
		$site = static::getById($site_id);

		###################################################################################
		# remove domain from hosts
		###################################################################################
		$hosts = new Hosts();

		$hosts->remove($site['name']);

    	# remove aliases from hosts
    	$aliases = Database::all("SELECT alias FROM alias WHERE site_id=?", $site_id);

		foreach ($aliases as $alias)
			$hosts->remove($alias['alias'].".".$site['name']);

		$hosts->save();
    	###################################################################################

		$instance = Database::single('SELECT * FROM instance WHERE id=?', $site['httpd_instance_id']);

		Util::del(BIN_PATH.'\\'.$instance['name'].'\\conf\\vhosts\\'.$site['name'].'.*');

		# was this site assigned to a server? If so, restart it.
		if ($site['httpd_instance_id'] != null)
			Package::control($site['httpd_instance_id'], 'restart');

		Database::execute('DELETE FROM site WHERE id=?', $site_id);
		Database::execute('DELETE FROM alias WHERE site_id=?', $site_id);

		Notify::success('Site successfully deleted.');
		Response::redirect('/sites');
	}

	public static function exists($name)
	{
		return (Database::scalar('SELECT COUNT(*) FROM site WHERE name=?', $name) == 1);
	}

	private static function _make($site_id)
	{
		# get site record
		$site = static::getById($site_id);

		# cause typing [] all the time isn't fun
		$name        = $site['name'];
		$alias       = $site['alias'];
		$instance_id = $site['httpd_instance_id'];

		$instance = Database::single('SELECT * FROM instance WHERE id=?', $instance_id);

		# what kind of webserver we dealing with here?
		$httpd_type = Database::scalar('SELECT v.title FROM package p
										INNER JOIN vendor v ON v.id=p.vendor_id
										WHERE p.id=?', $instance['package_id']);

		$conf_path = BIN_PATH.'\\'.$instance['name'].'\\conf\\vhosts';

		# Get interface of web server
		$interface  = Database::single('SELECT interface FROM endpoint WHERE instance_id=?', $instance_id)['interface'];
		$http_port  = Database::scalar('SELECT port FROM endpoint WHERE instance_id=? AND type=?', $instance_id, "http");
		$https_port = Database::scalar('SELECT port FROM endpoint WHERE instance_id=? AND type=?', $instance_id, "https");

    	#######################################################################
    	# update hosts file                                                   #
    	#######################################################################
    	$host_interface = ($interface == '0.0.0.0') ? '127.0.0.1' : $interface;

    	$hosts = new Hosts();

    	# add main domain
    	$hosts->add($host_interface, $name);

    	$aliases = Database::all("SELECT alias FROM alias WHERE site_id=?", $site_id);

		foreach ($aliases as $alias)
			$hosts->add($host_interface, $alias['alias'].".".$name);

		$hosts->save();
    	#######################################################################

		# paths for new ssl files
		$ssl_key_file = slash($conf_path.'/').$name.'.key';
		$ssl_crt_file = slash($conf_path.'/').$name.'.crt';

		if ($httpd_type == 'apache')
		{
			################################################################################
			#                                                                              #
			#  Apache                                                                      #
			#                                                                              #
			################################################################################

			# PHP
			$php_handler = '';
			$php_wrapper = '';

			# Does this site specify a PHP version? If so, get path to php-cgi.exe
			if ($site['php_instance_id'] != null)
			{
				$php_instance_name = Database::scalar('SELECT name FROM instance WHERE id=?', $site['php_instance_id']);

				$php_handler = T.T.'AddHandler fcgid-script .php'.N;

				$php_wrapper .= T.'FcgidMaxRequestLen 50000000'.N;
				$php_wrapper .= T.'FcgidIOTimeout 7200'.N;
				$php_wrapper .= T.'FcgidConnectTimeout 7200'.N;
				$php_wrapper .= T.'FcgidBusyTimeout 7200'.N;
				$php_wrapper .= T.'FcgidIdleTimeout 7200'.N;
				$php_wrapper .= T.'FcgidProcessLifeTime 7200'.N;

				$php_wrapper .= T.'FcgidWrapper "'.slash(BIN_PATH.'\\'.$php_instance_name.'\\php-cgi.exe"').' .php'.N;
			}

			# Non SSL Portion
			$vhost  = 	'<VirtualHost '.$interface.':'.$http_port.'>'							.N;
			$vhost .= 		T.'DocumentRoot "'.$site['document_root'].'"'						.N;
			$vhost .= 		T.'ServerName '.$site['name']										.N;

			foreach ($aliases as $alias)
			$vhost .= 		T.'ServerAlias '.$alias['alias'].".".$name							.N;

			$vhost .= 		$php_wrapper;
			$vhost .= 		T.'<Directory "'.$site['document_root'].'">'						.N;
			$vhost .= 			$php_handler;
			$vhost .= 			T.T.'Options all'												.N;
			$vhost .= 			T.T.'AllowOverride all'											.N;
			$vhost .= 			T.T.'Require all granted'										.N;
			$vhost .= 		T.'</Directory>'													.N;
			$vhost .= 	'</VirtualHost>';

			$vhost .= N.N;

			#SSL Portion
			$vhost .= 	'<VirtualHost '.$interface.':'.$https_port.'>'							.N;
			$vhost .= 		T.'DocumentRoot "'.$site['document_root'].'"'						.N;
			$vhost .= 		T.'ServerName '.$site['name']										.N;

			foreach ($aliases as $alias)
			$vhost .= 		T.'ServerAlias '.$alias['alias'].".".$name							.N;

			$vhost .= 		$php_wrapper;
			$vhost .= 		T.'<Directory "'.$site['document_root'].'">'						.N;
			$vhost .= 			$php_handler;
			$vhost .= 			T.T.'Options all'												.N;
			$vhost .= 			T.T.'AllowOverride all'											.N;
			$vhost .= 			T.T.'Require all granted'										.N;
			$vhost .= 		T.'</Directory>'													.N;
			$vhost .= 		T.'SSLEngine On'													.N;
			$vhost .= 		T.'SSLCertificateFile "'.$ssl_crt_file.'"'							.N;
			$vhost .= 		T.'SSLCertificateKeyFile "'.$ssl_key_file.'"'						.N;
			$vhost .= 	'</VirtualHost>';
		}
		else
		{
			################################################################################
			#                                                                              #
			#  Nginx                                                                       #
			#                                                                              #
			################################################################################

			# PHP
			$php_handler = '';
			$php_wrapper = '';

			################################################################################
			# build string of domain + aliases
			################################################################################
			$server_names = $site['name'];

			foreach ($aliases as $alias)
				$server_names .= " " . $alias['alias'].".".$name;
			################################################################################

			# Does this site specify a PHP version? If so, get path to php-cgi.exe
			if ($site['php_instance_id'] != null)
			{
				# Get endpoint for PHP instance
				$endpoint = Database::single('SELECT * FROM endpoint WHERE instance_id=?', $site['php_instance_id']);

				$php_wrapper  =		T.'location /'																	.N;
				$php_wrapper .= 	T.'{'																			.N;
    			$php_wrapper .= 		T.T.'try_files $uri $uri/ /index.php?$args;'								.N;
				$php_wrapper .= 	T.'}'																			.N;
				$php_wrapper .= 	T.'location ~ \.php$'															.N;
				$php_wrapper .= 	T.'{'																			.N;
				$php_wrapper .= 		T.T.'fastcgi_pass '.$endpoint['interface'].':'.$endpoint['port'].';'		.N;
				$php_wrapper .= 		T.T.'fastcgi_index index.php;'												.N;
				$php_wrapper .= 		T.T.'fastcgi_param SCRIPT_FILENAME  $document_root$fastcgi_script_name;'	.N;
				$php_wrapper .= 		T.T.'include fastcgi_params;'												.N;
				$php_wrapper .= 	T.'}'																			.N;
			}

			# Non SSL Portion
			$vhost  = 	'server'												.N;
			$vhost .= 	'{'														.N;
			$vhost .=		T.'listen '.$interface.':'.$http_port.';'			.N;
			$vhost .= 		T.'server_name '.$server_names.';'					.N;
			$vhost .= 		T.'root "'.slash($site['document_root'].'/').'";'	.N;
			$vhost .= 		$php_wrapper;
			$vhost .=	'}';

			$vhost .= N.N;

			# SSL Portion
			$vhost .= 	'server'												.N;
			$vhost .= 	'{'														.N;
			$vhost .=		T.'listen '.$interface.':'.$https_port.' ssl;'		.N;
			$vhost .= 		T.'server_name '.$server_names.';'					.N;
			$vhost .= 		T.'root "'.slash($site['document_root'].'/').'";'	.N;
			$vhost .= 		T.'ssl_certificate "'.$ssl_crt_file.'";'			.N;
			$vhost .= 		T.'ssl_certificate_key "'.$ssl_key_file.'";'		.N;
			$vhost .= 		T.'ssl_session_cache shared:SSL:1m;'				.N;
			$vhost .= 		T.'ssl_session_timeout 5m;'							.N;
			$vhost .= 		T.'ssl_ciphers HIGH:!aNULL:!MD5;'					.N;
			$vhost .= 		T.'ssl_prefer_server_ciphers on;'					.N;
			$vhost .= 		$php_wrapper;
			$vhost .=	'}';
		}

		# Write cert and key
		file_put_contents($ssl_key_file, $site['ssl_key']);
		file_put_contents($ssl_crt_file, $site['ssl_crt']);

		# Write vhost file
		file_put_contents($conf_path."\\$name.vhost", $vhost);
	}
}