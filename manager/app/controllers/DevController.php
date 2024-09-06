<?php

namespace App\Controllers;

use App\Classes\Database;
use App\Classes\Notify;
use App\Classes\Package;
use App\Classes\Request;
use App\Classes\Response;
use App\Classes\Util;

class DevController
{
	public function index()
	{
		require APP_PATH.'/app/views/developer.php';
	}

	public function upload()
	{
		$package = Database::single('SELECT * FROM package WHERE id=?', $_POST['id']);

		$package_id = Database::insert('INSERT INTO package (version, class_file, process, conf_file, log_file, arch, filesize, filehash, vendor_id, disabled) VALUES (?,?,?,?,?,?,?,?,?,?)',
			$_POST['version'],
			$package['class_file'],
			$package['process'],
			$package['conf_file'],
			$package['log_file'],
			$package['arch'],
			filesize($_FILES["package"]["tmp_name"]),
			sha1_file($_FILES["package"]["tmp_name"]),
			$package['vendor_id'],
			0);

		move_uploaded_file($_FILES["package"]["tmp_name"], WAMP_PATH."\\manager\\download\\".$package_id.".zip");
		Notify::success("Package successfully uploaded with ID: $package_id.");
		Response::redirect('/dev');
	}

	public function version()
	{
		$version = $_POST['version'];
		set('version', $version);
		Notify::success('Version successfully changed');
		Response::redirect('/dev');
	}

	public function toggle()
	{
		if (get('dev'))
		{
			Database::execute('DELETE FROM conf WHERE name=?', 'dev');
			Response::redirect('/');
		}
		else
		{
			set('dev', true);
			Response::redirect('/dev');
		}
	}
}