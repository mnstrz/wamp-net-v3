<?php

namespace App\Controllers;

use App\Classes\Database;
use App\Classes\Notify;
use App\Classes\Package;
use App\Classes\Request;
use App\Classes\Response;
use App\Classes\Util;

class PackageController
{
	public function index()
	{
		require APP_PATH.'/app/views/packages.php';
	}

	public function add($package_id)
	{
		$package = Package::getById($package_id);

		# New instance created will use vars above in constructor.
		(require APP_PATH.'/app/classes/instances/'.$package['class_file'])->init($package, 'preinstall');

		Response::redirect('/');
	}

	public function verify($package_id)
	{
		$package = Package::getById($package_id);

		# New instance created will use vars above in constructor.
		(require APP_PATH.'/app/classes/instances/'.$package['class_file'])->init($package, 'verify');

		Response::redirect('/');
	}

	public function wizard()
	{
		$_SESSION['wizard'] = '/package/'.$package_id.'/install';
		require APP_PATH.'/app/views/wizard.php';
	}

	public function install($package_id)
	{
		$package = Package::getById($package_id);

		# New instance created will use vars above in constructor.
		(require APP_PATH.'/app/classes/instances/'.$package['class_file'])->init($package, 'install');

		Response::redirect('/');
	}
}