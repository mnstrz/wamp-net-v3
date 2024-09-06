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
		Installer::form_end();
		exit;
	}

	public function verify()
	{
		$validator = new Validator();
		Installer::form_site_validate($validator);
		$validator->validate();
		parent::postVerify();
	}

	public function install()
	{
		$this->installer = new Installer(ucfirst($_SESSION['pdata']['label'])." Installation");

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

		$install_path = slash($document_root.$_SESSION['pdata']['path'], "\\");

		debug("\$install_path: '$install_path'");

		if (!is_dir($install_path))
		{
			if (!mkdir($install_path, null, true))
			{
				debug("Error creating directory: $install_path");
				Notify::error("Error creating directory: $install_path");
				Response::redirect('/sites');
			}
		}

		#unzip the zip
		$this->installer->startTask()->unzip($this->package, $install_path);

		# start configuration
		$this->installer->startTask();

		$config = file_get_contents("$install_path\\config.sample.inc.php");

		$secret = md5(bin2hex(openssl_random_pseudo_bytes(16)));

		$config = str_replace("\$cfg['blowfish_secret'] = ''", "\$cfg['blowfish_secret'] = '$secret'", $config);
		$config = str_replace("\$cfg['Servers'][\$i]['host'] = 'localhost'", "\$cfg['Servers'][\$i]['host'] = '127.0.0.1'", $config);
		$config = str_replace("\$cfg['Servers'][\$i]['AllowNoPassword'] = false;", "\$cfg['Servers'][\$i]['AllowNoPassword'] = true;", $config);

		file_put_contents("$install_path\\config.inc.php", $config);

		#######################################################################

		$this->appPostInstall();
	}
});