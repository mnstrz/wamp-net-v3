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
					Installer::form_text(["id"=>"tcp_port", "label"=>"TCP Port", "placeholder"=>"The TCP port to listen on", "value"=>"11211"]);
					Installer::form_text(["id"=>"udp_port", "label"=>"UDP Port", "placeholder"=>"The UDP port to listen on", "value"=>"11211"]);
					Installer::form_text(["id"=>"max_memory", "label"=>"Maximum Memory (Megabytes)", "placeholder"=>"The maximum amount of memory used for items", "value"=>"64"]);
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
		$udp_port  = $_POST['udp_port'];

		if (Util::endpointInUse('tcp', $interface, $tcp_port))
			$v->control('tcp_port', $_POST['tcp_port'])->custom('Port already assigned or in use.');

		if (Util::endpointInUse('udp', $interface, $udp_port))
			$v->control('udp_port', $_POST['udp_port'])->custom('Port already assigned or in use.');

		$v->control('max_memory', $_POST['max_memory'])->number();

		$v->validate();

		parent::postVerify();
	}

	public function install()
	{
		parent::install();

		# endpoint stuff
		$interface = $_SESSION['pdata']['interface'];
		$tcp_port  = $_SESSION['pdata']['tcp_port'];
		$udp_port  = $_SESSION['pdata']['udp_port'];
		parent::registerEndpoint("tcp", $interface, $tcp_port);
		parent::registerEndpoint("udp", $interface, $udp_port);

		$max_memory = $_SESSION['pdata']['max_memory'];

		# create config file
		file_put_contents($this->path.'\\memcached.conf', "-l $interface -p $tcp_port -U $udp_port -m $max_memory");

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
			Util::background($this->process_name.' '.file_get_contents($this->path.'\\'.$this->package['conf_file']));

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
		Util::exec(TOOLS_PATH.'\\nssm.exe install '.$this->service_name.' '.$this->process_name.' '.file_get_contents($this->path.'\\'.$this->package['conf_file']));
	}

	public function serviceUninstall()
	{
		$this->stop();
		if (Util::serviceExists($this->service_name))
			Util::exec(TOOLS_PATH.'\\nssm.exe remove '.$this->service_name.' confirm');
	}
});