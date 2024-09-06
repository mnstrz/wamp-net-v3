<?php

namespace App\Controllers\Tools;

use App\Classes\Database;
use App\Classes\Notify;
use App\Classes\Response;
use App\Classes\Util;

class HostController
{
	public function index()
	{
		require APP_PATH.'/app/views/tools/hosts.php';
	}

	public function update()
	{
		$data = $_POST['data'];
		file_put_contents(trim(shell_exec('echo %systemroot%\system32')).'\\drivers\\etc\\hosts', $data);
		Notify::success('Host file successfully updated.');
		Response::redirect('/tools/hosts');
	}
}