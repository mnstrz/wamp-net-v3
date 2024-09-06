<?php

namespace App\Classes;

class Cache
{
	public static function init()
	{
		$url = parse_url($_SERVER['REQUEST_URI'])['path'];

		$file = str_replace('/', DS, APP_PATH.DS.'public'.$url);

		if (is_dir($file) && $url != "/")
			$file .= "index.php";

		if (is_file($file))
		{
			if (pathinfo($file)['extension'] == "php")
				return false;

			$lastModified = filemtime($file);
			$etagFile     = md5_file($file);

			header('Last-Modified: '. gmdate('D, d M Y H:i:s', $lastModified) .' GMT');
			header('Etag: '. $etagFile);
			header('Cache-Control: public');

			$modified_since = $_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? null;
			$none_match     = $_SERVER['HTTP_IF_NONE_MATCH']     ?? null;

			if (($modified_since && @strtotime($modified_since) == $lastModified) || ($none_match && trim($none_match) == $etagFile))
				header('HTTP/1.1 304 Not Modified');
			else
			{
				switch(pathinfo($file)['extension'])
				{
					case 'js'   : $type = 'text/javascript';               break;
					case 'css'  : $type = 'text/css';                      break;
					case 'woff' : $type = 'application/font-woff';         break;
					case 'woff2': $type = 'application/font-woff2';        break;
					case 'ttf'  : $type = 'application/x-font-ttf';        break;
					case 'eot'  : $type = 'application/vnd.ms-fontobject'; break;
					case 'html' : $type = 'text/html';					   break;
					default     : $type = 'application/octet-stream';      break;
				}
				header('Content-Type: '. $type);
				header('Content-length: '.filesize($file));
				readfile($file);
			}
		}
		else
			return true;
	}
}