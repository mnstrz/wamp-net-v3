<?php

namespace App\Controllers;

use App\Classes\Database;
use App\Classes\Notify;
use App\Classes\Response;
use App\Classes\Site as SiteClass;
use App\Classes\Util;
use App\Classes\Validator;

class SiteController
{
	public function index()
	{
		require APP_PATH.'/app/views/sites.php';
	}

	public function showAdd()
	{
		$isEditing = false;

		require APP_PATH.'/app/views/site.php';
	}

	public function doAdd()
	{
		$name              = strtolower($_POST['name']);
		$aliases           = strtolower($_POST['aliases']);
		$document_root     = $_POST['document_root'];
		$httpd_instance_id = ($_POST['httpd_instance_id'] != -1) ? $_POST['httpd_instance_id'] : null;
		$php_instance_id   = ($_POST['php_instance_id'] != -1) ? $_POST['php_instance_id'] : null;

		$v = new Validator();

		$v->control('name', $name)->required()->validate();
		$v->control('name', $name)->regex(["pattern"=>"`^[0-9a-z.-]+$`", "msg"=>"Please enter a valid domain"])->validate();;

		//$v->control('document_root', $document_root)->dirExists();

		# Check not in use
		if (SiteClass::exists($name))
		{
			$v->_add('name', 'Domain name already in use');
		}

		$v->validate();

		SiteClass::create($name, $aliases, $document_root, $httpd_instance_id, $php_instance_id);

		Notify::success('Site successfully created.');
		Response::redirect('/sites');
	}

	public function showEdit($site_id)
	{
		$isEditing = true;

		require APP_PATH.'/app/views/site.php';
	}

	public function doEdit($site_id)
	{
		$name              = $_POST['name'];
		$aliases           = $_POST['aliases'];
		$document_root     = $_POST['document_root'];
		$httpd_instance_id = ($_POST['httpd_instance_id'] != -1) ? $_POST['httpd_instance_id'] : null;
		$php_instance_id   = ($_POST['php_instance_id'] != -1) ? $_POST['php_instance_id'] : null;

		//$v = new Validator();

		//$v->control('document_root', $document_root)->dirExists();

		//$v->validate();

		SiteClass::update($site_id, $name, $aliases, $document_root, $httpd_instance_id, $php_instance_id);

		Notify::success('Site successfully updated.');
		Response::redirect('/sites');
	}

	public function delete($site_id)
	{
		SiteClass::delete($site_id);
	}

	public function browse($site_id)
	{
		Util::explore(SiteClass::getById($site_id)['document_root']);
	}

	public function code($site_id)
	{
		$folder = Database::scalar('SELECT document_root FROM site WHERE id=?', $site_id);
		$folder = str_replace('\public', '', $folder);
		$path = str_replace('%folder%', $folder, get('editor_path'));
		exec($path);
	}
}