<?php

namespace App\Classes;

abstract class Instance
{
	protected $package;
	protected $instance_id;

	# replacement method for __construct() in order to have an
	# "anonymous constructor"
	public function init($package, $cmd, $instance_id=null)
	{
		$this->package     = $package;
		$this->instance_id = $instance_id;

		if ($instance_id)
			$this->setInstanceVars();

		$this->$cmd();
	}

	public function getEndpoint()
	{
		return Database::single('SELECT CASE WHEN interface="0.0.0.0" THEN "127.0.0.1" ELSE interface END interface, port FROM endpoint WHERE instance_id=?', $this->instance_id);
	}

	public function registerEndpoint($proto, $interface, $port, $type=null)
	{
		Database::insert('INSERT INTO endpoint (instance_id, proto, interface, port, type) VALUES (?,?,?,?,?)',	$this->instance_id, $proto, $interface, $port, $type);
	}

	public function setInstanceVars()
	{
		$this->name         = sprintf("%d-%s_%s_%s", $this->instance_id, $this->package['title'], $this->package['version'], $this->package['arch']);
		$this->path         = BIN_PATH.'\\'.$this->name;
		$this->process_name = $this->path.'\\'.$this->package['process'];
		$this->service_name = 'wamp.net.'.$this->name.'.service';
	}

	public function postVerify()
	{
		# copy all post data into session pdata
		$_SESSION['pdata'] = $_POST;

		$_SESSION['wizard'] = '/package/'.$_REQUEST['package_id'].'/install';

		Response::redirect('/wizard');
	}

	public function appInstall()
	{
		$this->installer = new Installer(ucfirst($this->package['title'].' '.$this->package['version'].' ('.$this->package['arch'].')')." Installation");

		$this->installer->addTask('Initializing');
		$this->installer->addTask('Download');
		$this->installer->addTask('Unzipping');
		$this->installer->addTask('Configuring');

		# initialize
		$this->installer->startTask();

		$site_id = $_SESSION['pdata']['site_id'];

		$site = Database::single('SELECT * FROM site WHERE id=?', $site_id);

		# download the zip
		$this->installer->startTask()->download($this->package);

		# where we gonna put this shit? Strip \public
		$document_root = str_replace('\\public', '', $site['document_root']);

		$this->path = slash($document_root.$_SESSION['pdata']['path'], "\\");

		debug("\$path: '{$this->path}'");

		if (!is_dir($this->path))
		{
			if (!mkdir($this->path, null, true))
			{
				debug("Error creating directory: {$this->path}");
				Notify::error("Error creating directory: {$this->path}");
				Response::redirect('/sites');
			}
		}

		#unzip the zip
		$this->installer->startTask()->unzip($this->package, $this->path);

		# start configuration
		$this->installer->startTask();
	}

	public function appPostInstall()
	{
		$url = Site::getUrl($_SESSION['pdata']['site_id']).$_SESSION['pdata']['path'];
		Notify::success('<br><br>Application successfully installed to <a target="_blank" href="'.$url.'">'.$url.'</a>');
		$this->installer->complete('/sites');
	}

	public function install()
	{
		$this->installer = new Installer(ucfirst($_SESSION['pdata']['label'])." Installation");

		$this->installer->addTask('Initializing');
		$this->installer->addTask('Download');
		$this->installer->addTask('Unzipping');

		# initialize
		$this->installer->startTask();

		# add tasks passed in from child
		if ($this->tasks)
			foreach($this->tasks as $task)
				$this->installer->addTask($task);

		# download the zip
		$this->installer->startTask()->download($this->package);

		# set instance id to newly generated one
		$this->instance_id = Package::add($this->package['id'], $_SESSION['pdata']['label']);

		# now that we have an instance_id, we can set the instance vars
		$this->setInstanceVars();

		# only once this is set is the instance active and good to go
		Database::execute('UPDATE instance SET name=? WHERE id=?', $this->name, $this->instance_id);

		#unzip the zip
		$this->installer->startTask()->unzip($this->package, $this->path);
	}

	public function postInstall()
	{
		Notify::success('Installation Complete!');
		$this->installer->complete();
	}

	public function preUninstall()
	{
		# copy all post data into session pdata
		$_SESSION['pdata'] = $_POST;

		# set url so wizard knows what to do
		$_SESSION['wizard'] = '/instance/'.$this->instance_id.'/uninstall';

		Response::redirect('/wizard');
	}

	public function uninstall()
	{
		# create new installer object
		$this->installer = new Installer("Uninstalling...");

		$this->installer->addTask('Stopping active instances/removing services');
		$this->installer->addTask('Performing instance cleanup');

		if (isset($_SESSION["installer_abort"]))
		{
			unset($_SESSION["installer_abort"]);
			$this->installer->complete();
			exit;
		}

		# stop/remove if process/service exists and is running
		$this->installer->startTask();
		$this->serviceUninstall();
	}

	public function postUninstall()
	{
		# remove installation directory
		$this->installer->startTask();
		if (!empty($this->name))
			Util::deltree(BIN_PATH.'\\'.$this->name);

		# remove any endpoints that were registered
		Database::execute('DELETE FROM endpoint WHERE instance_id=?', $this->instance_id);

		# remove from instance table
		Database::execute('DELETE FROM instance WHERE id=?', $this->instance_id);

		Notify::success('Uninstall Complete!');
		$this->installer->complete();
	}

	public function postStart()
	{
		Util::sleep(1000);
	}

	public function restart()
	{
		$this->stop();
		$this->start();
	}

	public static function pidsToLabels($pids)
	{
		$out = [];
		foreach($pids as $pid)
			$out[] = '<span class="label label-default">'.$pid.'</span>';
		return $out;
	}

	public static function procsToLabels($endpoints)
	{
		$out = [];
		$endpoints = array_unique($endpoints, SORT_REGULAR);
		foreach($endpoints as $endpoint)
			$out[] = '<span class="label label-info">'.strtoupper($endpoint[0]).'&nbsp;&nbsp;&nbsp;'.$endpoint[1].'&nbsp;&nbsp;&nbsp;'.$endpoint[2].'</span>';
		return $out;
	}
}