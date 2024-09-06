<?php

namespace App\Controllers;

use App\Classes\Database;
use App\Classes\Notify;
use App\Classes\Package;
use App\Classes\Request;
use App\Classes\Response;
use App\Classes\Util;

class InstanceController
{
	public function index()
	{
		require APP_PATH.'/app/views/instances.php';
	}

	public function browse($instance_id)
	{
		$instance_name = Database::scalar('SELECT name FROM instance WHERE id=?', $instance_id);
		Util::exec(WAMP_PATH.'/Wamp.NET.exe --explore '.BIN_PATH.'\\'.$instance_name);
	}

	public function fopen($instance_id, $type)
	{
		$instance_name = Database::scalar('SELECT name FROM instance WHERE id=?', $instance_id);
		$package = Package::getByInstanceId($instance_id);

		if ($type=='cmd')
		{
			pclose(popen("start cmd.exe /k cd ".BIN_PATH.'\\'.$instance_name.'\\', "r"));
			exit;
		}

		Util::exec(BIN_PATH.'\\'.$instance_name.'\\'.$package[$type.'_file']);
	}

	public function rename($instance_id)
	{
		Database::execute('UPDATE instance SET label=? WHERE id=?', $_POST['label'], $instance_id);
		Notify::success('Label change successful.');
		Response::redirect('/');
	}

	public function control($instance_id, $cmd)
	{
		# All commands from this page should be relating to an instance, not a package,
		# except for installing a new instance.
		$instance_id = $instance_id ?? null;

		# If instance_id is null, then this should be an install of a new instance.
		# In which case, we can load the package using the package_id that will be passed in.
		$package = ($instance_id) ? Package::getByInstanceId($instance_id) : Package::getById($_REQUEST['package_id']);

		# New instance created will use vars above in constructor.
		(require APP_PATH.'/app/classes/instances/'.$package['class_file'])->init($package, $cmd, $instance_id);

		Response::redirect('/');
	}
}