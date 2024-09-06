<?php

namespace App\Classes\Instances;

use App\Classes\Database;
use App\Classes\Installer;
use App\Classes\Instance;
use App\Classes\Layout;
use App\Classes\QDB;
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
					Installer::form_password('root_password', 'Root Password');
				Layout::tab_pane_end();
				Layout::tab_pane_begin(2);
					Installer::form_interface();
					Installer::form_text(["id"=>"tcp_port", "label"=>"TCP Port", "placeholder"=>"The TCP port to listen on for incoming connections", "value"=>5432]);
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
			'Finalizing'
		];

		parent::install();

		# endpoint stuff
		$interface = $_SESSION['pdata']['interface'];
		$tcp_port  = $_SESSION['pdata']['tcp_port'];
		$this->registerEndpoint("tcp", $interface, $tcp_port, 'pgsql');

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

		$mask = ($interface == '0.0.0.0') ? '0' : '32';

		$hba = "host\tall\twamp\t$interface/$mask\ttrust\r\n";

		if (!empty($_SESSION['pdata']['root_password']))
		{
			$hba .= "host\tall\tpostgres\t$interface/$mask\tmd5\r\n";
		}
		else
		{
			$hba .= "host\tall\tpostgres\t$interface/$mask\ttrust\r\n";
		}

		$hba .= "host\tall\tall\t$interface/$mask\tmd5";

		$this->installer->startTask();

		exec($this->path.'\\bin\\initdb.exe -U postgres -E utf8 -D '.$datadir);

		rename($datadir.'\\postgresql.conf', $this->path.'\\postgresql.conf');
		rename($datadir.'\\pg_ident.conf', $this->path.'\\pg_ident.conf');
		rename($datadir.'\\pg_hba.conf', $this->path.'\\pg_hba.conf');

		#######################################################################
		#                                                                     #
		#  postgres.conf                                                      #
		#                                                                     #
		#######################################################################

		$conf = file_get_contents($this->path.'\\postgresql.conf');

		$conf = str_replace("#data_directory = 'ConfigDir'",           "data_directory = '".slash($datadir)."/'", $conf);
		$conf = str_replace("#hba_file = 'ConfigDir/pg_hba.conf'",     "hba_file = '".slash($this->path)."/pg_hba.conf'", $conf);
		$conf = str_replace("#ident_file = 'ConfigDir/pg_ident.conf'", "ident_file = '".slash($this->path)."/pg_ident.conf'", $conf);
		$conf = str_replace("#listen_addresses = 'localhost'",         "listen_addresses = '$interface'", $conf);
		$conf = str_replace("#port = 5432",                            "port = $tcp_port", $conf);

		file_put_contents($this->path.'\\postgresql.conf', $conf);

		#######################################################################

		# temp file to allow any connection
		file_put_contents($this->path.'\\pg_hba.conf', "host\tall\tall\tall\ttrust\r\n");

		$this->start();

		if ($interface == '0.0.0.0')
			if ($interface = '127.0.0.1');


		# create wamp user
		QDB::exec('CREATE ROLE wamp WITH CREATEDB CREATEROLE SUPERUSER LOGIN', ["driver"=>"pgsql", "host"=>$interface, "port"=>$tcp_port]);

		# change postgres password
		if (!empty($_SESSION['pdata']['root_password']))
			QDB::exec("ALTER USER postgres WITH PASSWORD '{$_SESSION['pdata']['root_password']}'", ["driver"=>"pgsql", "host"=>$interface, "port"=>$tcp_port]);

		$this->stop();

		file_put_contents($this->path.'\\pg_hba.conf', $hba);

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
		{
			Util::background($this->path.'\\bin\\pg_ctl.exe -D '.$this->path.' start');
		}

		$this->postStart();
	}

	public function stop()
	{
		if (Util::serviceExists($this->service_name))
			Util::serviceStop($this->service_name);
		else
		{
			Util::exec($this->path.'\\bin\\pg_ctl.exe -D '.$this->path.' stop');
			Util::sleepTillProcessDead($this->process_name);
		}

	}

	public function serviceInstall()
	{
		$this->stop();
		Util::exec($this->path.'\\bin\\pg_ctl.exe register -N '.$this->service_name.' -D '.$this->path);
	}

	public function serviceUninstall()
	{
		$this->stop();
		if (Util::serviceExists($this->service_name))
			Util::exec($this->path.'\\bin\\pg_ctl.exe unregister -N '.$this->service_name);
	}
});