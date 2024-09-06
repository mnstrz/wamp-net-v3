<?php

namespace App\Classes;

class Downloader
{
	private $_dest;
	private $_url;
	private $_progress;
	private $_last_val = 0;
	private $_onProgress;
	private $_data = null;

	public function __construct($url, $progress=null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if (get('proxy_enable') == "true")
		{
			curl_setopt($ch, CURLOPT_PROXY, get('proxy_host').":".get('proxy_port'));

			if (get('proxy_auth') == "true")
				curl_setopt($ch, CURLOPT_PROXYUSERPWD, get('proxy_user').":".get('proxy_pass'));
		}

		if ($progress!=null)
		{
			$this->_onProgress = $progress;
			curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, [$this, '_progressFunction']);
			curl_setopt($ch, CURLOPT_NOPROGRESS, false);
		}

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Wamp.NET '.get('version'));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		if (($this->_data = curl_exec($ch)) === false)
		{
			$this->error = curl_error($ch);
			$this->_data = null;
		}

		curl_close($ch);
	}

	public function get()
	{
		return $this->_data;
	}

	public function save($path)
	{
		file_put_contents($path, $this->_data);
	}

	private function _progressFunction($resource, $download_size, $downloaded, $upload_size, $uploaded)
	{
		if ($download_size > 0)
		{
			$current_val = round($downloaded / $download_size  * 100);

			if ($current_val != $this->_last_val)
			{
				$this->_last_val = $current_val;
				call_user_func($this->_onProgress, $this->_last_val);
			}
		}
	}
}