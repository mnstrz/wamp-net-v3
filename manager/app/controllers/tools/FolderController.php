<?php

namespace App\Controllers\Tools;

class FolderController
{
	public function index()
	{
		echo exec(TOOLS_PATH.'\fb\fb.exe "c:\Wamp.NET\sites"');
	}
}