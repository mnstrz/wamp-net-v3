<?php

namespace App\Classes;

use Exception;
use ZipArchive;

class UnzipMe
{
	private $_zip;
	private $_tmp;
	public $on_next = null;
	public $on_done = null;
	public $file_count = 0;

	public function __construct($zip_file)
	{
		$this->_zip = new ZipArchive;

		if (!$this->_zip->open($zip_file))
			throw new Exception("Whitney Houston, we have a problem...");

		$this->_tmp = sys_get_temp_dir().DS.uniqid().DS;
	}

	public function unzip($dest, $options = [])
	{
		if (!is_dir($dest))
			mkdir($dest, 0777, true);

		$strip          = (isset($options["strip"]))          ? $options["strip"]          : 0;
		$matches        = (isset($options["matches"]))        ? $options["matches"]        : null;
		$match_excludes = (isset($options["match_excludes"])) ? $options["match_excludes"] : true;

		$this->file_count = $this->_zip->numFiles;

	    for ($i = 0; $i < $this->file_count; $i++)
	    {
	    	$full_path = $this->_zip->statIndex($i)['name'];

    		if ($matches)
    		{
	    		if ($match_excludes)
	    		{
					foreach ($matches as $match)
						if (preg_match($match, $full_path)) continue 2;
	    		}
	    		else
	    		{
					$matched = false;

					foreach ($matches as $match)
						if (preg_match($match, $full_path))
							$matched = true;

					if (!$matched) continue;
				}
			}

	    	$parts = explode("/", $full_path);

	    	if (count($parts) <= $strip)
	    		continue;

			$stripped = implode("/", array_slice($parts, $strip));

	  		if ($this->on_next)
	  			call_user_func($this->on_next, $full_path, $i);

			$this->_zip->extractTo($this->_tmp, $this->_zip->statIndex($i)['name']);

			$dir  = $dest.DS.dirname($stripped);
			$file = basename($stripped);

			if ($stripped[-1]=='/')
				@mkdir($dest.DS.$stripped, 0777, true);

			if (strlen($file)!=0)
				@rename($this->_tmp.$this->_zip->statIndex($i)['name'], $dir.DS.$file);
	    }

	    $this->_clean($this->_tmp);

	    if ($this->on_done)
	    	call_user_func($this->on_done);
	}

	private function _clean($dir)
	{
    	foreach(scandir($dir) as $file)
    	{
        	if ($file==='.' || $file==='..') continue;
        	(is_dir($dir.DS.$file)) ? $this->_clean($dir.DS.$file) : unlink($dir.DS.$file);
    	}
    	rmdir($dir);
    }
}