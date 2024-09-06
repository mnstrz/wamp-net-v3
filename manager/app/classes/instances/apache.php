<?php

namespace App\Classes\Instances;

use App\Classes\Database;
use App\Classes\Installer;
use App\Classes\Instance;
use App\Classes\Layout;
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
			 	Layout::tab(1, "Basic", true);
			 	Layout::tab(2, "Advanced");
			Layout::tabs_end();
			Layout::tab_panes_begin();
				Layout::tab_pane_begin(1, true);
					Installer::form_text(["id"=>"label", "label"=>"Label", "placeholder"=>"My Instance", "value"=>$this->package['title'].' '.$this->package['version'].' ('.$this->package['arch'].')', "autofocus"=>true]);
				Layout::tab_pane_end();
				Layout::tab_pane_begin(2);
					Installer::form_interface();
					Installer::form_text(["id"=>"http_port", "label"=>"HTTP Port", "placeholder"=>"The HTTP port to listen on", "value"=>"80"]);
					Installer::form_text(["id"=>"https_port", "label"=>"HTTPS Port", "placeholder"=>"The HTTPS port to listen on", "value"=>"443"]);
				Layout::tab_pane_end();
			Layout::tab_panes_end();
		Installer::form_end();
		exit;
	}

	public function verify()
	{
		$v = new Validator();

		$interface  = $_POST['interface'];
		$http_port  = $_POST['http_port'];
		$https_port = $_POST['https_port'];

		if (Util::endpointInUse('tcp', $interface, $http_port))
			$v->control('http_port', $_POST['http_port'])->custom('Port already assigned or in use.');

		if (Util::endpointInUse('tcp', $interface, $https_port))
			$v->control('https_port', $_POST['https_port'])->custom('Port already assigned or in use.');

		$v->validate();

		parent::postVerify();
	}

	public function install()
	{
		parent::install();

		# endpoint stuff
		$interface  = $_SESSION['pdata']['interface'];
		$http_port  = $_SESSION['pdata']['http_port'];
		$https_port = $_SESSION['pdata']['https_port'];
		parent::registerEndpoint("tcp", $interface, $http_port, 'http');
		parent::registerEndpoint("tcp", $interface, $https_port, 'https');

		# read existing httpd.conf included in package
		$data = file_get_contents($this->path.'\\conf\\httpd.conf');

		# prepend with WAMPROOT var
		$data = 'Define WAMPROOT "'.slash(WAMP_PATH).'"'.N.N.$data;
		$data = str_replace('#ServerName www.example.com:80', 'ServerName localhost', $data);
		$data = str_replace('ServerRoot "c:/Apache24"', 'ServerRoot "' . slash($this->path) . '"', $data);
		$data = str_replace('DocumentRoot "c:/Apache24/htdocs"', 'DocumentRoot "htdocs"', $data);
		$data = str_replace('<Directory "c:/Apache24/htdocs">', '<Directory "htdocs">', $data);
	   	$data = str_replace('DirectoryIndex index.html', 'DirectoryIndex index.php index.html', $data);
	   	$data = str_replace('c:/Apache24/cgi-bin', slash(WAMP_PATH) . '/cgi-bin', $data);
		$data = str_replace('Listen 80', 'Listen '.$interface.':'.$http_port.N.'Listen '.$interface.':'.$https_port, $data);
		$data = str_replace('#LoadModule ssl_module modules/mod_ssl.so', 'LoadModule ssl_module modules/mod_ssl.so', $data);
		$data = str_replace('#LoadModule socache_shmcb_module modules/mod_socache_shmcb.so', 'LoadModule socache_shmcb_module modules/mod_socache_shmcb.so', $data);
		$data .= 'SSLSessionCache "shmcb:'.$this->path.'\\logs\\ssl_scache(512000)"'.N;
		$data .= 'SSLSessionCacheTimeout  300'.N;
		$data = str_replace('#LoadModule rewrite_module modules/mod_rewrite.so', 'LoadModule rewrite_module modules/mod_rewrite.so', $data);
		$data .= N.'LoadModule fcgid_module modules/mod_fcgid.so'.N;
		$data .= 'IncludeOptional "conf/vhosts/*.vhost"';
		file_put_contents($this->path.'\\conf\\httpd.conf', $data);

		$index_page = "<h1>Wamp.NET</h1>You are seeing this page because you don't have any sites configured.";
		file_put_contents($this->path.'\\htdocs\\index.html', $index_page);

		# create folder for vhosts for this instance
		Util::mkdir($this->path.'\\conf\\vhosts');

		parent::postInstall();
	}

	public function uninstall()
	{
		parent::uninstall();

		# set all sites httpd_instance_id to null
		Database::execute('UPDATE site SET httpd_instance_id=null WHERE httpd_instance_id=?', $this->instance_id);

		parent::postUninstall();
	}

	public function start()
	{
		if (Util::serviceExists($this->service_name))
			Util::serviceStart($this->service_name);
		else
			Util::background($this->process_name);

		parent::postStart();
	}

	public function stop()
	{
		Util::killByPath($this->process_name);
	}

	public function serviceInstall()
	{
		$this->stop();
		Util::exec($this->path.'\\bin\\httpd.exe -k install -n '.$this->service_name);
	}

	public function serviceUninstall()
	{
		$this->stop();
		if (Util::serviceExists($this->service_name))
			Util::exec($this->path.'\\bin\\httpd.exe -k uninstall -n '.$this->service_name);
	}
});