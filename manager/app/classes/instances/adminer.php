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
		$this->appInstall();
		$this->appPostInstall();
	}
});