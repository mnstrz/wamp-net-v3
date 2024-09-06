<?php

namespace App\Controllers\Tools;

use App\Classes\Notify;
use App\Classes\Response;
use App\Classes\Util;

class ProcessController
{
	public function index()
	{
		require APP_PATH.'/app/views/tools/process.php';
	}

	public function kill($pid)
	{
		Util::killPid($pid);
		Notify::success('Kill signal sent');
		Response::redirect('/tools/process');
	}
}