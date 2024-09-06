<?php

namespace App\Controllers;

class MailController
{
	public function index()
	{
		require APP_PATH.'/app/views/mail.php';
	}

	public function delete($file)
	{
		unlink(base64_decode($file));
	}

	public function open($file)
	{
		\App\Classes\Util::exec(base64_decode($file));
	}

	public function empty()
	{
		\App\Classes\Notify::success("Mailbox Emptied.");
		\App\Classes\Util::del(WAMP_PATH.'\\manager\\mail\\*.eml');
		\App\Classes\Response::redirect("/mail");
	}

	public function browse()
	{
		\App\Classes\Util::explore(WAMP_PATH.'\\manager\\mail');
	}
}