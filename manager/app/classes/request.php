<?php

namespace App\Classes;

class Request
{
	public static function isAjax()
	{
		return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	}

	public static function isSecure()
	{
		return (!empty($_SERVER['HTTPS']));
	}
}