<?php

namespace App\Classes;

class Response
{
	public static function redirect($url)
	{
		if (Request::isAjax())
		{
			debug("JS redirect to: $url");
			echo "window.location = '" . $url . "';\n";
		}
		else
		{
			debug("location header redirect to: $url");
			header('location: ' . $url);
		}

		exit;
	}

	public static function json()
	{
		header('Content-type: application/json');
	}
}