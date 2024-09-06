<?php

namespace App\Classes\Instances;

use App\Classes\Database;
use App\Classes\Installer;
use App\Classes\Instance;
use App\Classes\Layout;
use App\Classes\Notify;
use App\Classes\QDB;
use App\Classes\Request;
use App\Classes\Response;
use App\Classes\Site;
use App\Classes\Util;
use App\Classes\Validator;

return (new class() extends Instance
{
	public function preinstall()
	{
		Installer::form_begin($this->package);
			Layout::tabs_begin();
			 	Layout::tab(1, 'Site', true);
			 	Layout::tab(2, 'Database');
			 	Layout::tab(3, 'Laravel');
			Layout::tabs_end();
			Layout::tab_panes_begin();
				Layout::tab_pane_begin(1, true);
					Installer::form_site(["id"=>"site", "label"=>"Site", "placeholder"=>"", "autofocus"=>true]);
					Installer::form_break();
				Layout::tab_pane_end();
				Layout::tab_pane_begin(2);
					Installer::form_database(['mysql', 'pgsql']);
					Installer::form_break();
				Layout::tab_pane_end();
				Layout::tab_pane_begin(3);
					Installer::form_text(["id"=>"app_name", "label"=>"Application Name", "value"=>"Laravel", "placeholder"=>""]);
					Installer::form_text(["id"=>"app_env", "label"=>"Application Environment", "value"=>"local", "placeholder"=>""]);
					Installer::form_checkbox(["id"=>"app_debug", "label"=>"Application Debug", "checked"=>true, "placeholder"=>""]);
				Layout::tab_pane_end();
			Layout::tab_panes_end();
		Installer::form_end();
		exit;
	}

	public function verify()
	{
		$validator = new Validator();
		Installer::form_site_validate($validator);
		Installer::form_database_validate($validator);
		$validator->validate();
		parent::postVerify();
	}

	public function install()
	{
		$this->appInstall();

		# get contents of sample file
		$config = file_get_contents("{$this->path}\\.env");

		$app_name  = $_SESSION['pdata']['app_name'];
		$app_env   = $_SESSION['pdata']['app_env'];
		$app_key   = 'base64:'.base64_encode(bin2hex(openssl_random_pseudo_bytes(16)));
		$app_debug = (isset($_SESSION['pdata']['app_debug'])) ? 'true' : 'false';
		$app_url   = \App\Classes\Site::getUrl($_SESSION['pdata']['site_id']);

		# if this is a new or existing db, we do something interesting...
		if ($_SESSION['pdata']['db_type'] != 'none')
		{
			# create database if "new database" option select
			if ($_SESSION['pdata']['db_type'] == 'new')
				\App\Classes\QDB::createDatabase($_SESSION['pdata']['database_id'], $_SESSION['pdata']['db_name']);

			# get db info to populate db details
			$database = \App\Classes\QDB::info($_SESSION['pdata']['database_id']);

			$db_name   = $_SESSION['pdata']['db_name'];
			$db_driver = $database['type'];
			$db_host   = ($database['interface'] == '0.0.0.0') ? '127.0.0.1' : $database['interface'];
			$db_port   = $database['port'];

			$config = str_replace('DB_CONNECTION=', "DB_CONNECTION=$db_driver", $config);
			$config = str_replace('DB_HOST=',       "DB_HOST=$db_host", $config);
			$config = str_replace('DB_PORT=',       "DB_PORT=$db_port", $config);
			$config = str_replace('DB_DATABASE=',   "DB_DATABASE=$db_name", $config);
			$config = str_replace('DB_USERNAME=',   "DB_USERNAME=wamp", $config);
		}

		$config = str_replace('APP_NAME=',  "APP_NAME=$app_name", $config);
		$config = str_replace('APP_ENV=',   "APP_ENV=$app_env", $config);
		$config = str_replace('APP_DEBUG=', "APP_DEBUG=$app_debug", $config);
		$config = str_replace('APP_KEY=',   "APP_KEY=$app_key", $config);
		$config = str_replace('APP_URL=',   "APP_URL=$app_url", $config);

		file_put_contents("{$this->path}\\.env", $config);

		#######################################################################

		$this->appPostInstall();
	}
});