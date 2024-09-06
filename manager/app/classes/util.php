<?php

namespace App\Classes;

class Util
{
	public static function getInterfaces()
	{
		$interfaces = explode("\n", trim(Util::shell_exec(WAMP_PATH.'\\Wamp.NET.exe --iplist')));

		$out = [];

		foreach($interfaces as $interface)
		{
			$parts = explode("\t", $interface);
			if (strpos($parts[0], ':') === false && $parts[0] != '127.0.0.1')
				$out[] = ["address"=>$parts[0], "name"=>$parts[1], "description"=>$parts[2]];
		}
		return $out;
	}

	public static function endpointInUse($proto, $interface, $port)
	{
		# check endpoint table
		if ($interface == '0.0.0.0')
		{
			if (Database::single('SELECT * FROM endpoint WHERE proto==? AND port=?', $proto, $port))
				return true;
		}
		else
		{
			if (Database::single('SELECT * FROM endpoint WHERE proto==? AND (interface=="0.0.0.0" OR interface=?) AND port=?', $proto, $interface, $port))
				return true;
		}

		# check if currently in use by another process
		list($p, $n) = explode("\n\n", trim(Util::shell_exec(WAMP_PATH.'\\Wamp.NET.exe --netstat')));
		$net_data = explode("\n", $n);

		foreach($net_data as $endpoint)
		{
			$parts = explode("\t", $endpoint);

			if ($interface == '0.0.0.0')
			{
				if ($parts[0]==$proto && $parts[2]==$port)
					return true;
			}
			else
			{
				if ($parts[0]==$proto && ($parts[1]=='0.0.0.0' || $parts[1]==$interface) && $parts[2]==$port)
					return true;
			}
		}

		return false;
	}

	public static function getFreeLocalTCPPort($exclude = [])
	{
		do
		{
			$random_port = rand(10000, 20000);

			if (in_array($random_port, $exclude))
				continue;

			$port = static::endpointInUse('tcp','127.0.0.1', $random_port);
		} while ($port);

		return $random_port;
	}

	public static function del($glob)
	{
		foreach(glob($glob) as $file)
		{
    		@unlink($file);
    	}
	}

	public static function serviceStatus($name)
	{
		$service = win32_query_Service_status($name);

		if (is_int($service) && $service == 1060)
		{
			# service doesn't exist
			return false;
		}
		else
		{
			switch($service['CurrentState'])
			{
				case WIN32_SERVICE_CONTINUE_PENDING : return 'continue_pending';
				case WIN32_SERVICE_PAUSE_PENDING    : return 'pause_pending';
				case WIN32_SERVICE_PAUSED           : return 'paused';
				case WIN32_SERVICE_RUNNING          : return 'running';
				case WIN32_SERVICE_START_PENDING    : return 'start_pending';
				case WIN32_SERVICE_STOP_PENDING     : return 'stop_pending';
				case WIN32_SERVICE_STOPPED          : return 'stopped';
			}
		}
	}

	public static function serviceExists($service)
	{
		debug("Util::serviceExists: $service");
		$result = (static::serviceStatus($service) != false) ? true : false;
		debug("Util::serviceExists: $service complete");
		return $result;
	}

	public static function background($cmd)
	{
		debug("********************************************************************************");
		debug("Util::background cmd: $cmd");
		exec(WAMP_PATH.'\\Wamp.NET.exe --bg '.$cmd, $output, $retval);
	}

	public static function explore($path)
	{
		static::exec(WAMP_PATH.'\\Wamp.NET.exe --explore "'.$path.'"');
	}

	public static function isElevated()
	{
		return (shell_exec("net session") !== null);
	}

	public static function shell_exec($cmd)
	{
		$out = shell_exec($cmd);
		return $out;
	}

	public static function exec($cmd)
	{
		debug("********************************************************************************");
		debug("Util::exec cmd: $cmd");
		exec($cmd . ' 2>&1', $output, $retval);
		debug("Util::exec retval: $retval");
		debug($output);
		return $retval;
	}

	public static function killByPath($path)
	{
		$svc = (new ServiceStatus())->getByImage(strtolower($path));

		if ($svc)
			foreach($svc['pids'] as $pid)
				exec(WAMP_PATH.'\\Wamp.NET.exe --kill '.$pid);
	}

	public static function sleepTillProcessDead($process_path, $timeout=10)
	{
		debug("SleepTillDead: $process_path");
		$count=0;

		while(static::processExistsByPath($process_path))
		{
			static::sleep(500);
			debug("SleepTillDead: sleeping for 500ms");
			$count++;

			if ($count >= $timeout)
				throw new \Exception('Timeout waiting for process to finish');
		}
		debug("SleepTillDead: $process_path done!");
	}

	public static function processExistsByPath($path)
	{
		return (new ServiceStatus())->getByImage(strtolower($path));
	}

	public static function killPid($pid)
	{
		exec('taskkill.exe /F /PID '.$pid);
	}

	public static function serviceStop($service)
	{
		exec("net stop $service", $output, $retval);
		return ($retval==0) ? true : false;
	}

	public static function serviceStart($service)
	{
		debug("Util::serviceStart: $service");
		exec("net start $service", $output, $retval);
		debug("Util::serviceStart: $service complete: $retval");
		return ($retval==0) ? true : false;
	}

	public static function serviceRestart($service)
	{
		static::serviceStop($service);
		static::serviceStart($service);

		return ($retval==0) ? true : false;
	}

	public static function createJunction($junction, $real_path)
	{
		exec("mklink /J $junction $real_path");
	}

	public static function removeJunction($junction)
	{
		exec("rmdir $junction");
	}

	public static function deltree($dir, $retries=3)
	{
		if (!is_dir($dir))
			return true;

		if (in_array($dir, [BIN_PATH, BIN_PATH.DS]))
			return false;

		while ($retries > 0)
		{
			exec("rmdir /S /Q $dir");

			clearstatcache();

			if (is_dir($dir))
			{
				$retries--;
				static::sleep(200);
			}
			else return true;
		}

		return false;
	}

	public static function copy($src, $dst)
	{
		exec("xcopy $src $dst /s /e", $output, $retval);
		return ($retval == 0);
	}

	public static function mkdir($dir)
	{
		exec("mkdir $dir", $output, $retval);
		return ($retval == 0);
	}

	public static function createSymlink($fake, $real)
	{
		exec("mklink $fake $real");
	}

	public static function sleep($ms)
	{
		usleep($ms*1000);
	}

	public static function isDirectoryEmpty($dir)
	{
	    return (count(glob("$dir/*")) == 0);
	}

	public static function is64()
	{
		return (strpos(shell_exec('wmic os get osarchitecture'), '64') !== false);
	}

	public static function getTempFile($prefix='w.n-')
	{
		return tempnam(sys_get_temp_dir(), $prefix);
	}

	public static function get_dir_size($directory)
	{
    	$size = 0;
    	$files= glob($directory.'/*');
    	foreach($files as $path)
    	{
        	is_file($path) && $size += filesize($path);
        	is_dir($path) && static::get_dir_size($path);
    	}
    	return $size;
    }

    public static function randomString($length=32, $exclude = '')
	{
		$chars = str_replace(str_split($exclude), '', '!#$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_abcdefghijklmnopqrstuvwxyz{|}');

		$str = '';

		for ($i=0; $i< $length; $i++)
			$str .= $chars[random_int(0, strlen($chars) -1)];

		return $str;
	}

	public static function formatBytes($bytes, $precision = 2)
	{
		$units = array('B', 'KB', 'MB', 'GB', 'TB');

		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		// Uncomment one of the following alternatives
		// $bytes /= pow(1024, $pow);
		$bytes /= (1 << (10 * $pow));

		return round($bytes, $precision) . ' ' . $units[$pow];
	}
}