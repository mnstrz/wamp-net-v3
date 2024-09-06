<?php

namespace App\Classes\Instances;

use App\Classes\Database;
use App\Classes\Installer;
use App\Classes\Instance;
use App\Classes\Layout;
use App\Classes\Notify;
use App\Classes\Request;
use App\Classes\Response;
use App\Classes\Util;
use App\Classes\uPDO;
use App\Classes\Validator;

return (new class() extends Instance
{
	public function preinstall()
	{
		Installer::form_begin($this->package);
			Installer::form_site(["id"=>"site", "label"=>"Site", "placeholder"=>"", "autofocus"=>true]);
			Installer::form_break();
			Installer::form_database(['mysql', 'pgsql']);
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
		$config = file_get_contents("{$this->path}\\installation\\model\\forms\\database.xml");

		#######################################################################
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

			$config = str_replace('default="localhost"', "readonly=\"true\"\n\t\t\t\tdefault=\"$db_host:$db_port\"", $config);
			$config = str_replace('name="db_user"', "name=\"db_user\"\n\t\t\t\treadonly=\"true\"\n\t\t\t\tdefault=\"wamp\"", $config);
			$config = str_replace('name="db_pass"', "name=\"db_pass\"\n\t\t\t\treadonly=\"true\"\n\t\t\t\tdefault=\"\"", $config);
			$config = str_replace('name="db_name"', "name=\"db_name\"\n\t\t\t\treadonly=\"true\"\n\t\t\t\tdefault=\"$db_name\"", $config);
		}

		file_put_contents("{$this->path}\\installation\\model\\forms\\database.xml", $config);

		#######################################################################

		# remove stupid localhost test
		$data = file_get_contents("{$this->path}\\installation\\model\\database.php");
		$find = '$shouldCheckLocalhost = getenv(\'JOOMLA_INSTALLATION_DISABLE_LOCALHOST_CHECK\') !== \'1\';';
		$repl = '$shouldCheckLocalhost = false;';
		$data = str_replace($find, $repl, $data);
		file_put_contents("{$this->path}\\installation\\model\\database.php", $data);

		#######################################################################

		$this->appPostInstall();
	}
});