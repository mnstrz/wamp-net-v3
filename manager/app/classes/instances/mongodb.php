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
			 	Layout::tab(1, 'Basic', true);
			 	Layout::tab(2, 'Advanced');
			Layout::tabs_end();
			Layout::tab_panes_begin();
				Layout::tab_pane_begin(1, true);
					Installer::form_text(["id"=>"label", "label"=>"Label", "placeholder"=>"My Instance", "value"=>$this->package['title'].' '.$this->package['version'].' ('.$this->package['arch'].')', "autofocus"=>true]);
					Installer::form_directory_browser('datadir', 'Data Location');
				Layout::tab_pane_end();
				Layout::tab_pane_begin(2);
					Installer::form_interface();
					Installer::form_text(["id"=>"tcp_port", "label"=>"TCP Port", "placeholder"=>"The TCP port to listen on for incoming connections", "value"=>27017]);
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

		if (Util::endpointInUse('tcp', $interface, $tcp_port))
			$v->control('tcp_port')->custom('Port already assigned or in use.');

		if (!empty($_POST['datadir']))
		{
			# use has provided a custom datadir, make sure it's empty or warn
			# this is to ensure that we don't overwrite anything that we shouldn't
			if (!Util::isDirectoryEmpty($_POST['datadir']))
				$v->control('datadir')->custom('The directory supplied is not empty');
		}

		$v->validate();

		$this->postVerify();
	}

	public function install()
	{
		$this->tasks =
		[
			'Initalize database',
			'Create wamp user',
			'Finalizing'
		];

		parent::install();

		# endpoint stuff
		$interface = $_SESSION['pdata']['interface'];
		$tcp_port  = $_SESSION['pdata']['tcp_port'];
		$this->registerEndpoint("tcp", $interface, $tcp_port);

		# if no directory provided, create one in default data dir
		if (empty($_SESSION['pdata']['datadir']))
		{
			$datadir = DATA_PATH.'\\'.$this->name;
			Util::mkdir($datadir);
		}
		else
		{
			$datadir = $_SESSION['pdata']['datadir'];
		}

		$conf  = 'systemLog:'.N;
		$conf .= '    destination: file'.N;
		$conf .= '    path: '.$this->path.'\\mongod.log'.N;
		$conf .= '    logAppend: true'.N;
		$conf .= 'storage:'.N;
		$conf .= '    dbPath: '.$datadir.N;

		if ($this->package['arch'] == 'x86')
			$conf .= '    engine: mmapv1'.N;

		$conf .= 'net:'.N;
		$conf .= '    bindIp: '.$interface.N;
		$conf .= '    port: '.$tcp_port.N;

		file_put_contents($this->path.'\\mongod.cfg', $conf);

		$this->postInstall();
	}

	public function uninstall()
	{
		parent::uninstall();
		$this->postUninstall();
	}

	public function start()
	{
		Util::del(DATA_PATH.'\\'.$this->name.'\\*.lock');

		if (Util::serviceExists($this->service_name))
			Util::serviceStart($this->service_name);
		else
			Util::background($this->process_name.' -f ..\mongod.cfg');

		$this->postStart();
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
		Util::exec($this->process_name.' --config '.$this->path.'\\mongod.cfg --install --serviceDisplayName='.$this->service_name.' --serviceName='.$this->service_name);
		$this->stop();
	}

	public function serviceUninstall()
	{
		$this->stop();
		if (Util::serviceExists($this->service_name))
			Util::exec($this->process_name.' --remove --serviceName='.$this->service_name);
	}
});