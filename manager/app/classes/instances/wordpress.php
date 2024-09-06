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
			Installer::form_site(["id"=>"site", "label"=>"Site", "placeholder"=>"", "autofocus"=>true]);
			Installer::form_break();
			Installer::form_database(['mysql']);
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
		$config = file_get_contents("{$this->path}\\wp-config-sample.php");

		# get database details so we know where to connect to in order to create database
		if ($_SESSION['pdata']['db_type'] != 'none')
		{
			# create database if "new database" option select
			if ($_SESSION['pdata']['db_type'] == 'new')
				\App\Classes\QDB::createDatabase($_SESSION['pdata']['database_id'], $_SESSION['pdata']['db_name']);

			# get db info to populate db details
			$database = \App\Classes\QDB::info($_SESSION['pdata']['database_id']);

			$db_name   = $_SESSION['pdata']['db_name'];
			$db_host   = ($database['interface'] == '0.0.0.0') ? '127.0.0.1' : $database['interface'];
			$db_port   = $database['port'];

			$config = str_replace('database_name_here', "$db_name",          $config);
			$config = str_replace('username_here',      "wamp",              $config);
			$config = str_replace('password_here',      "",                  $config);
			$config = str_replace('localhost',          "$db_host:$db_port", $config);
		}

		# create those strings for cookie encryption etc.
		for ($i=0; $i<8; $i++)
		{
			$config = preg_replace('`put your unique phrase here`', \App\Classes\Util::randomString(64, "'"), $config, 1);
		}

		file_put_contents("{$this->path}\\wp-config.php", $config);

		#######################################################################

		$this->appPostInstall();
	}
});