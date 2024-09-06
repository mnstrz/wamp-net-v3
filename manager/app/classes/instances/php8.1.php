<?php

namespace App\Classes\Instances;

use App\Classes\Database;
use App\Classes\Installer;
use App\Classes\Instance;
use App\Classes\Layout;
use App\Classes\Notify;
use App\Classes\Request;
use App\Classes\Response;
use App\Classes\Util;
use App\Classes\Validator;

return (new class() extends Instance
{
	public function preinstall()
	{
		Installer::form_begin($this->package);
			Layout::tabs_begin();
			 	Layout::tab(1, 'General', true);
			 	Layout::tab(2, 'FCGI Daemon');
			 	Layout::tab(3, 'Resources');
			 	Layout::tab(4, 'Modules');
			Layout::tabs_end();
			Layout::tab_panes_begin();
				Layout::tab_pane_begin(1, true);
					Installer::form_text(["id"=>"label", "label"=>"Label", "placeholder"=>"My Instance", "value"=>$this->package['title'].' '.$this->package['version'].' ('.$this->package['arch'].')', "autofocus"=>true]);
					Installer::form_select('timezone', 'Time Zone', Database::all('SELECT null as id, timezone as value FROM php_timezone ORDER BY timezone'), 'UTC');
				Layout::tab_pane_end();
				Layout::tab_pane_begin(2);
					Installer::form_interface();
					Installer::form_text(["id"=>"tcp_port", "label"=>"TCP Port", "placeholder"=>"The TCP port to listen on for the CGI Server", "value"=>dotty($this->package['version'])]);
				Layout::tab_pane_end();
				Layout::tab_pane_begin(3);
					Installer::form_text(["id"=>"max_execution_time", "label"=>"Maximum Execution Time (Seconds)", "placeholder"=>"Maximum execution time of each script, in seconds", "value"=>30]);
					Installer::form_text(["id"=>"max_input_time", "label"=>"Maximum Input Time (Seconds)", "placeholder"=>"Maximum amount of time each script may spend parsing request data", "value"=>60]);
					Installer::form_text(["id"=>"max_input_vars", "label"=>"Maximum Input Variables", "placeholder"=>"How many GET/POST/COOKIE input variables may be accepted", "value"=>1000]);
					Installer::form_text(["id"=>"memory_limit", "label"=>"Memory Limit (Megabytes)", "placeholder"=>"Maximum memory allocated per process", "value"=>128]);
				Layout::tab_pane_end();
				Layout::tab_pane_begin(4);
					Installer::form_label("Standard");
					Installer::form_checkbox(["id"=>"php_bz2",          "label"=>"bz2",          	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_curl",         "label"=>"curl",         	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_ffi",          "label"=>"ffi",          	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_ftp",          "label"=>"ftp",          	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_fileinfo",     "label"=>"fileinfo",     	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_gd",           "label"=>"gd",          	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_gettext",      "label"=>"gettext",      	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_gmp",          "label"=>"gmp",          	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_intl",         "label"=>"intl",         	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_imap",         "label"=>"imap",         	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_ldap",         "label"=>"ldap",         	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_mbstring",     "label"=>"mbstring",     	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_exif",         "label"=>"exif",         	"checked"=>false,  "depends"=>["php_mbstring"]]);
					Installer::form_checkbox(["id"=>"php_mysqli",       "label"=>"mysqli",       	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_oci8_19",      "label"=>"oci8_19",     	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_odbc",         "label"=>"odbc",         	"checked"=>false]);
					//Installer::form_checkbox(["id"=>"php_opcache",      "label"=>"opcache",      	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_openssl",      "label"=>"openssl",      	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_pdo_firebird",	"label"=>"pdo_firebird",	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_pdo_mysql",    "label"=>"pdo_mysql",    	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_pdo_oci",      "label"=>"pdo_oci",      	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_pdo_odbc",     "label"=>"pdo_odbc",     	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_pdo_pgsql",    "label"=>"pdo_pgsql",    	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_pdo_sqlite",   "label"=>"pdo_sqlite",   	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_pgsql",        "label"=>"pgsql",        	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_shmop",        "label"=>"shmop",        	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_snmp",         "label"=>"snmp",         	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_soap",         "label"=>"soap",         	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_sockets",      "label"=>"sockets",      	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_sodium",       "label"=>"sodium",       	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_sqlite3",      "label"=>"sqlite3",      	"checked"=>true]);
					Installer::form_checkbox(["id"=>"php_tidy",         "label"=>"tidy",         	"checked"=>false]);
					Installer::form_checkbox(["id"=>"php_xsl",          "label"=>"xsl",          	"checked"=>false]);

					Installer::form_break();
					Installer::form_label("Addon");
					Installer::form_checkbox(["id"=>"php_memcache",     "label"=>"memcache",     "checked"=>false]);
					Installer::form_checkbox(["id"=>"php_mongodb",      "label"=>"mongodb",      "checked"=>false, "disabled"=>true]);
					Installer::form_checkbox(["id"=>"php_redis",        "label"=>"redis",        "checked"=>false, "disabled"=>true]);
					Installer::form_checkbox(["id"=>"php_xdebug",       "label"=>"xdebug",       "checked"=>false]);
				Layout::tab_pane_end();
			Layout::tab_panes_end();
		Installer::form_end();
		exit;
	}

	public function verify()
	{
		$v = new Validator();

		$interface = $_POST['interface'];
		$tcp_port  = $_POST['tcp_port'];

		$v->control('tcp_port')->required()->number();

		if (Util::endpointInUse('tcp', $interface, $tcp_port))
			$v->control('tcp_port')->custom('Port already assigned or in use.');

		$v->control('memory_limit')->required()->number();
		$v->control('max_input_vars')->required()->number();
		$v->control('max_execution_time')->required()->number();
		$v->control('max_input_time')->required()->number();

		$v->validate();

		parent::postVerify();
	}

	public function install()
	{
		parent::install();

		# endpoint stuff
		$interface = $_SESSION['pdata']['interface'];
		$tcp_port  = $_SESSION['pdata']['tcp_port'];
		parent::registerEndpoint("tcp", $interface, $tcp_port, "php");

		# create php.ini
		$data = file_get_contents($this->path.'\\'.'php.ini-development');
		$data = str_replace(';date.timezone =',              'date.timezone = '. $_SESSION['pdata']['timezone'],      		$data);

		$ext_addon .= ';extension=memcache'.N;
		$ext_addon .= ';extension=mongodb'.N;
		$ext_addon .= ';extension=redis'.N;
		$ext_addon .= ';extension=xdebug'.N;

		$data = str_replace(';zend_extension=opcache',        ';zend_extension=opcache'.N.$ext_addon,							$data);

		foreach($_SESSION['pdata'] as $key => $val)
		{
			if (substr($key, 0, 4) == 'php_')
				$data = str_replace(';extension='.substr($key, 4), 'extension='.substr($key, 4), $data);
		}

		# if exif module selected, enable mbstring.
		if (isset($_SESSION['pdata']['php_exif']))
			$data = str_replace(';extension=mbstring', 'extension=mbstring', $data);

		# as per above, change xdebug to a ZEND extension, cause why must life be simple?
		# I mean Jesus, Who cares if it's a zend module ffs. A module is a module is a module, or at least it
		# should be, if I'm honest, to be fair, to be honest.

		$data = str_replace('extension=xdebug', 'zend_extension=xdebug',                          			$data);

		$data = str_replace(';extension_dir = "ext"',  'extension_dir = "ext"',                                 			$data);

		$data = str_replace('memory_limit = 128M',      'memory_limit = ' . $_SESSION['pdata']["memory_limit"] . "M",		$data);
		$data = str_replace('max_input_vars = 1000',    'max_input_vars = ' . $_SESSION['pdata']["max_input_vars"], 		$data);
		$data = str_replace('max_execution_time = 30',  'max_execution_time = ' . $_SESSION['pdata']["max_execution_time"],	$data);
		$data = str_replace('max_input_time = 60',      'max_input_time = ' . $_SESSION['pdata']["max_input_time"], 		$data);

		$data = str_replace('upload_max_filesize = 2M', 'upload_max_filesize = 50M',                             			$data);
		$data = str_replace('post_max_size = 8M',       'post_max_size = 50M',                                   			$data);

		$data = str_replace('SMTP = localhost',       	'; SMTP = localhost',	                                   			$data);
		$data = str_replace('smtp_port = 25',       	'; smtp_port = 25',		                                   			$data);

		$sendmail_path = WAMP_PATH.'\\manager\\bin\\dev-svr\\wamp.net.php.exe '.WAMP_PATH.'\\manager\\bin\\tools\\sendmail.php';

		$data = str_replace(';sendmail_path =',       	'sendmail_path = '.$sendmail_path,                         			$data);

		file_put_contents($this->path.'\\'.'php.ini', $data);

		# create config file to run as daemon for nginx if need be
		file_put_contents($this->path.'\\'.'php-cgi-daemon.conf', '-b '.$interface.':'.$tcp_port);

		# copy php-cgi.exe to php-daemon.exe so as to not mess us process monitoring
		copy($this->path.'\\'.'php-cgi.exe', $this->path.'\\'.'php-cgi-daemon.exe');

		parent::postInstall();
	}

	public function uninstall()
	{
		# Are there sites using this php version?
		$count = Database::scalar('SELECT COUNT(*) FROM site WHERE php_instance_id=?', $this->instance_id);

		if ($count > 0)
		{
			Notify::error("This package is in use by some of your sites and can't be deleted.");
			$_SESSION["installer_abort"] = true;
		}

		parent::uninstall();

		# Set all sites httpd_package_id to null
		Database::execute('UPDATE site SET php_instance_id=null WHERE php_instance_id=?', $this->instance_id);

		# If the version being removed is the default php version,
		# remove symlink and set to unassigned
		if (get('php_default_instance_id') == $this->instance_id)
		{
			Util::removeJunction(BIN_PATH.'\\'.'.php');
			set('php_default_instance_id', null);
		}
		parent::postUninstall();
	}

	public function start()
	{
		if (Util::serviceExists($this->service_name))
			Util::serviceStart($this->service_name);
		else
			Util::background($this->process_name.' '.file_get_contents($this->path.'\\php-cgi-daemon.conf'));

		parent::postStart();
	}

	public function stop()
	{
		if (Util::serviceExists($this->service_name))
			Util::serviceStop($this->service_name);
		else
			Util::killByPath($this->process_name);
	}

	public function serviceInstall()
	{
		$this->stop();
		Util::exec(TOOLS_PATH.'\\nssm.exe install '.$this->service_name.' '.$this->process_name.' '.file_get_contents($this->path.'\\php-cgi-daemon.conf'));
	}

	public function serviceUninstall()
	{
		$this->stop();
		if (Util::serviceExists($this->service_name))
			Util::exec(TOOLS_PATH.'\\nssm.exe remove '.$this->service_name.' confirm');
	}
});