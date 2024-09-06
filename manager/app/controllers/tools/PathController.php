<?php

namespace App\Controllers\Tools;

use App\Classes\Notify;
use App\Classes\Response;
use App\Classes\Util;

class PathController
{
	public function index()
	{
		require APP_PATH.'/app/views/tools/path.php';
	}

	public function update()
	{
		$newPath = $_REQUEST['newPath'];
		Util::exec(WAMP_PATH.'/Wamp.NET.exe --path-set '.$newPath);
		Notify::success('Path successfully updated');
		Response::redirect('/tools/path');
	}
}