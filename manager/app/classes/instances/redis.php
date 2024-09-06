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
					Installer::form_text(["id"=>"tcp_port", "label"=>"TCP Port", "placeholder"=>"The TCP port to listen on", "value"=>6379]);
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

		$v->control('tcp_port')->number();

		if (Util::endpointInUse('tcp', $interface, $tcp_port, 'redis'))
			$v->control('tcp_port')->custom('Port already assigned or in use.');

		$v->validate();

		parent::postVerify();
	}

	public function install()
	{
		parent::install();

		# endpoint stuff
		$interface = $_SESSION['pdata']['interface'];
		$tcp_port  = $_SESSION['pdata']['tcp_port'];
		parent::registerEndpoint("tcp", $interface, $tcp_port);

		$data = file_get_contents($this->path.'\\redis.windows.conf');
		$data = str_replace('port 6379',        'port '.$tcp_port,     $data);
		$data = str_replace('# bind 127.0.0.1', 'bind '.$interface,    $data);
		$data = str_replace('logfile ""',		'logfile "'.slash($this->path).'/redis.log"', $data);
		file_put_contents($this->path.'\\redis.windows.conf', $data);

		parent::postInstall();
	}

	public function uninstall()
	{
		parent::uninstall();
		parent::postUninstall();
	}

	public function start()
	{
		if (Util::serviceExists($this->service_name))
			Util::serviceStart($this->service_name);
		else
			Util::background($this->process_name.' redis.windows.conf');

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
		Util::exec(TOOLS_PATH.'\\nssm.exe install '.$this->service_name.' '.$this->process_name.' '.$this->path.'\\redis.windows.conf');
	}

	public function serviceUninstall()
	{
		$this->stop();
		if (Util::serviceExists($this->service_name))
			Util::exec($this->path.'\\redis-server.exe --service-uninstall --service-name '.$this->service_name);
	}
});