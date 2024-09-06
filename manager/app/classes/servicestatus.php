<?php

namespace App\Classes;

use App\Classes\Util;

class ServiceStatus
{
	private $_pArray = [];

	private $_proc_data = null;
	private $_net_data  = null;

	public function __construct()
	{
		list($p, $n) = explode("\n\n", trim(Util::shell_exec(WAMP_PATH.'\\Wamp.NET.exe --netstat')));

		$this->_proc_data = explode("\n", $p);
		$this->_net_data  = explode("\n", $n);

		foreach($this->_proc_data as $p)
		{
			$parts = explode("\t", $p);

			$pid  = $parts[0];
			$path = strtolower($parts[1]);

			if (!isset($this->_pArray[$path]))
				$this->_pArray[$path] = ["pids"=>[], "endpoints"=>[]];

			$this->_pArray[$path]["pids"][] = $pid;

			foreach($this->_net_data as $n)
			{
				$parts = explode("\t", $n);
				if ($parts[3] == $pid)
					$this->_pArray[$path]["endpoints"][] = [$parts[0], $parts[1], $parts[2]];
			}
		}
	}

	public function getProcData()
	{
		return $this->_proc_data;
	}

	public function getByImage($image)
	{
		if (isset($this->_pArray[$image]))
			return $this->_pArray[$image];
		else
			return null;
	}
}