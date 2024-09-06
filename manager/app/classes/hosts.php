<?php

namespace App\Classes;

class Hosts
{
	private $_path    = null;
	private $_data    = [];
	private $_restart = false;

	public function __construct()
	{
		$this->_path = GetEnv("SystemDrive").'\\windows\\system32\\drivers\\etc\\hosts';
		$this->_data = array_map(function($a){ return trim($a); }, explode("\n", file_get_contents($this->_path)));
	}

	public function get()
	{
		return implode("\r\n", $this->_data);
	}

	public function add($address, $hostname)
	{
		debug("Hosts::add($address, $hostname)");
		if ($hostname == 'localhost')
			return;

		if (strpos($hostname, '*') !== false)
			$this->_restart = true;

		$this->remove($hostname);
		array_push($this->_data, "$address\t$hostname");
	}

	public function remove($hostname)
	{
		if (strpos($hostname, '*') !== false)
			$this->_restart = true;

		$h_esc = str_replace(['.','*'], ['\.','\*'], $hostname);
		debug("Hosts::remove($hostname) parsed to $h_esc)");

		$this->_data = array_filter($this->_data, function($item) use ($h_esc)
		{
    		$result = !preg_match('`^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\s+'.$h_esc.'($|\s.*)`', $item);

    		if ($item[0] != '#')
    			debug("\"$h_esc\" compared to \"$item\": ".strtoupper(var_export(!$result, true)));

    		return $result;
		});
	}

	public function save()
	{
		file_put_contents($this->_path, trim($this->get()));
	}
}