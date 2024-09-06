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
	public function preInstall()
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

		# create nginx.conf
		$conf  = 	'worker_processes 1;'																.N;
		$conf .= 																						 N;
		$conf .= 	'events'																			.N;
		$conf .= 	'{'																					.N;
		$conf .= 		T.'worker_connections  1024;'													.N;
		$conf .= 	'}'																					.N;
		$conf .= 																						 N;
		$conf .= 	'http'																				.N;
		$conf .= 	'{'																					.N;
		$conf .= 		T.'server_names_hash_max_size 2048;'											.N;
		$conf .= 		T.'server_names_hash_bucket_size 256;'											.N;
 		$conf .= 		T.'include mime.types;'															.N;
		$conf .= 		T.'default_type application/octet-stream;'										.N;
		$conf .= 		T.'index index.php index.html index.htm;'										.N;
		$conf .= 		T.'include "vhosts/*.vhost";'.N;
		$conf .= 	'}';
		file_put_contents($this->path.'\\conf\\nginx.conf', $conf);

		# create folder for vhosts
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
		if (Util::serviceExists($this->service_name))
			Util::serviceStop($this->service_name);
		else
			Util::killByPath($this->process_name);
	}

	public function serviceInstall()
	{
		$this->stop();
		Util::exec(TOOLS_PATH.'\\nssm.exe install '.$this->service_name.' '.$this->process_name);
	}

	public function serviceUninstall()
	{
		$this->stop();
		if (Util::serviceExists($this->service_name))
			Util::exec(TOOLS_PATH.'\\nssm.exe remove '.$this->service_name.' confirm');
	}
});