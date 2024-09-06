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
					Installer::form_text(["id"=>"tcp_port", "label"=>"TCP Port", "placeholder"=>"The TCP port to listen on for incoming connections", "value"=>3306]);
					Installer::form_integer('key_buffer_size', 'key_buffer_size', '32');
					Installer::form_integer('max_allowed_packet', 'max_allowed_packet', '128');
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

		$v->control('key_buffer_size')->number();
		$v->control('max_allowed_packet')->number();

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
		$this->registerEndpoint("tcp", $interface, $tcp_port, "mysql");

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

		# create interim my.ini always using localhost and a random
		# port. This is so we can add access to other networks if
		# an interface other than localhost is supplied.
		$random_port = Util::getFreeLocalTCPPort();

		$data  = '[client]'.N;
		$data .= 'port='.$random_port.N;
		$data .= N;
		$data .= '[mysqld]'.N;
		$data .= 'bind-address=127.0.0.1'.N;
		$data .= 'port='.$random_port.N;
		$data .= 'datadir='.slash($datadir).N;
		$data .= 'log-error='.slash($this->path).'/error.log'.N;
		$data .= 'pid-file='.slash($this->path).'/mysqld.pid'.N;
		$data .= 'key_buffer_size='.$_SESSION['pdata']['key_buffer_size'].'M'.N;
		$data .= 'max_allowed_packet='.$_SESSION['pdata']['max_allowed_packet'].'M';
		file_put_contents($this->path.'\\my.ini', $data);

		$this->installer->startTask();
		Util::exec($this->path.'\\bin\\mysqld.exe --initialize-insecure');
		Util::sleepTillProcessDead($this->process_name);

		$this->installer->startTask();
		$this->start();

		#  has the user specified a root password?
		if (!empty($_SESSION['pdata']['root_password']))
		{
			$root_password = $_SESSION['pdata']['root_password'];

			# since we're delimiting the password with quotes to the PASSWORD() function
			# we need to escape single quotes
			$root_password = str_replace("'", "\'", $root_password);

			$root_password_query = "IDENTIFIED BY '$root_password'";
		}
		else
		{
			$root_password = null;
			$root_password_query = "";
		}

		# if 0.0.0.0 was provided for interface, change access permission to 127.0.0.1
		# as 0.0.0.0 is not a valid address to connect to.
		$final_interface = ($interface == '0.0.0.0') ? '127.0.0.1' : $interface;

		# if server has to listen on any interface other than 127.0.0.1/localhost, we need
		# to create an additional root user to allow connections from the local machine.
		#
		# if user wants to be able log in from another host on the network for the interface
		# specified, they need to change the host to % or xxx.xxx.xxx.%
		if ($final_interface != '127.0.0.1')
		{
			$query  = "CREATE USER `wamp`@`$final_interface`;";
			$query .= "GRANT ALL PRIVILEGES ON *.* TO `wamp`@`$final_interface` WITH GRANT OPTION;";
			$query .= "CREATE USER `root`@`$final_interface`;";
			$query .= "GRANT ALL PRIVILEGES ON *.* TO `root`@`$final_interface` $root_password_query WITH GRANT OPTION;";
		}
		else
		{
			$query  = "CREATE USER `wamp`@`localhost`;";
			$query .= "GRANT ALL PRIVILEGES ON *.* TO `wamp`@`localhost` WITH GRANT OPTION;";
			$query .= "CREATE USER `wamp`@`127.0.0.1`;";
			$query .= "GRANT ALL PRIVILEGES ON *.* TO `wamp`@`127.0.0.1` WITH GRANT OPTION;";
		}

		if ($root_password)
		{
			$query .= "SET PASSWORD FOR `root`@`localhost` = PASSWORD('$root_password');";
			//$query .= "SET PASSWORD FOR `root`@`127.0.0.1` = PASSWORD('$root_password');";
		}

		$query .= "SHUTDOWN;";

		QDB::m_exec($query, ["port"=>$random_port]);

		Util::sleepTillProcessDead($this->process_name);

		# create real my.ini with gin-u-wine interface and port
		$data  = '[client]'.N;
		$data .= 'port='.$tcp_port.N;
		$data .= N;
		$data .= '[mysqld]'.N;
		$data .= 'bind-address='.$interface.N;
		$data .= 'port='.$tcp_port.N;
		$data .= 'datadir='.slash($datadir).N;
		$data .= 'log-error='.slash($this->path).'/error.log'.N;
		$data .= 'pid-file='.slash($this->path).'/mysqld.pid'.N;
		$data .= 'key_buffer_size='.$_SESSION['pdata']['key_buffer_size'].'M'.N;
		$data .= 'max_allowed_packet='.$_SESSION['pdata']['max_allowed_packet'].'M';
		file_put_contents($this->path.'\\my.ini', $data);

		$this->postInstall();
	}

	public function uninstall()
	{
		parent::uninstall();
		$this->postUninstall();
	}

	public function start()
	{
		if (Util::serviceExists($this->service_name))
			Util::serviceStart($this->service_name);
		else
			Util::background($this->process_name);

		$this->postStart();
	}

	public function stop()
	{
		if (Util::processExistsByPath($this->process_name))
		{
			extract($this->getEndpoint());
			Util::exec($this->path.'\\bin\\mysqladmin.exe --host='.$interface.' --port='.$port.' -u wamp shutdown');
			Util::sleepTillProcessDead($this->process_name);
		}
	}

	public function serviceInstall()
	{
		$this->stop();
		Util::exec($this->path.'\\bin\\mysqld.exe --install '.$this->service_name);
	}

	public function serviceUninstall()
	{
		$this->stop();
		if (Util::serviceExists($this->service_name))
			Util::exec($this->path.'\\bin\\mysqld.exe --remove '.$this->service_name);
	}
});