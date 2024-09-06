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
					Installer::form_text(["id"=>"udp_port", "label"=>"UDP Port", "placeholder"=>"The UDP port to listen on", "value"=>53]);
					Installer::form_break();
					Installer::form_text(["id"=>"primary", "label"=>"Primary Upstream DNS Server", "placeholder"=>"e.g. 8.8.8.8", "value"=>"8.8.8.8"]);
					Installer::form_text(["id"=>"secondary", "label"=>"Secondary Upstream DNS Server", "placeholder"=>"e.g. 1.1.1.1", "value"=>"1.1.1.1"]);
				Layout::tab_pane_end();
			Layout::tab_panes_end();
		Installer::form_end();
		exit;
	}

	public function verify()
	{
		$v = new Validator();

		$interface = $_POST['interface'];
		$udp_port  = $_POST['udp_port'];

		$v->control('udp_port')->number();

		if (Util::endpointInUse('udp', $interface, $udp_port))
			$v->control('udp_port')->custom('Port already assigned or in use.');

		$v->control('primary')->ipAddress();
		$v->control('secondary')->ipAddress();

		$v->validate();

		parent::postVerify();
	}

	public function install()
	{
		parent::install();

		# endpoint stuff
		$interface = $_SESSION['pdata']['interface'];
		$udp_port  = $_SESSION['pdata']['udp_port'];
		parent::registerEndpoint("udp", $interface, $udp_port, "dns");

		$primary   = $_SESSION['pdata']['primary'];
		$secondary = $_SESSION['pdata']['secondary'];

		$ini  = "[GlobalSection]\r\n";
		$ini .= "PrimaryServerAddress=$primary\r\n";
		$ini .= "PrimaryServerPort=53\r\n";
		$ini .= "PrimaryServerProtocol=UDP\r\n";
		$ini .= "SecondaryServerAddress=$secondary\r\n";
		$ini .= "SecondaryServerPort=53\r\n";
		$ini .= "SecondaryServerProtocol=UDP\r\n";
		$ini .= "LocalIPv4BindingAddress=$interface\r\n";
		$ini .= "LocalIPv4BindingPort=$udp_port\r\n";

		file_put_contents($this->path.'\\AcrylicConfiguration.ini', $ini);

		file_put_contents($this->path.'\\AcrylicHosts.txt', '@ '.realpath('/windows/system32').'\\drivers\\etc\\hosts');

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