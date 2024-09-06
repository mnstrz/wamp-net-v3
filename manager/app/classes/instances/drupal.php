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

		# get database details so we know where to connect to in order to create database
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

			$settings = "<?php\n\n\$databases['default']['default'] = [\n'database' => '$db_name',\n'username' => 'wamp',\n'password' => '',\n'host' => '$db_host',\n'port' => '$db_port',\n'driver' => '$db_driver',\n'prefix' => '',\n'collation' => 'utf8mb4_general_ci'\n];\n\n\$settings['trusted_host_patterns'] = ['.*'];";

			//$config = file_get_contents("{$this->path}\\sites\\default\\settings.php");

			//$config = str_replace('$databases = [];', "$settings", $config);

			file_put_contents("{$this->path}\\sites\\default\\settings.php", $settings);
		}

		#######################################################################

		$this->appPostInstall();
	}
});