<?php

namespace App\Controllers;

use App\Classes\Database;
use App\Classes\Util;

class SettingsController
{
	public function index()
	{
		require APP_PATH.'/app/views/settings.php';
	}

	public function save()
	{
		$proxy_enable = (isset($_POST["proxy_enable"])) ? "true" : "false";
		$proxy_host   = $_POST["proxy_host"];
		$proxy_port   = $_POST["proxy_port"];
		$proxy_auth   = (isset($_POST["proxy_auth"])) ? "true" : "false";
		$proxy_user   = $_POST["proxy_user"];
		$proxy_pass   = $_POST["proxy_pass"];
		$editor_path  = $_POST["editor_path"];

		set('proxy_enable', $proxy_enable);
		set('proxy_host',   $proxy_host);
		set('proxy_port',   $proxy_port);
		set('proxy_auth',   $proxy_auth);
		set('proxy_user',   $proxy_user);
		set('proxy_pass',   $proxy_pass);
		set('editor_path',  $editor_path);

		###############################################################################
		#                                                                             #
		# default apps                                                                #
		#                                                                             #
		###############################################################################

		Util::removeJunction(BIN_PATH.'\\.php');
		Util::removeJunction(BIN_PATH.'\\.mysql');
		Util::removeJunction(BIN_PATH.'\\.pgsql');

		$php_instance_id   = ($_POST['php_instance_id']   == -1) ? null : $_POST['php_instance_id'];
		$mysql_instance_id = ($_POST['mysql_instance_id'] == -1) ? null : $_POST['mysql_instance_id'];
		$pgsql_instance_id = ($_POST['pgsql_instance_id'] == -1) ? null : $_POST['pgsql_instance_id'];

		if ($php_instance_id != null)
		{
			Util::createJunction(BIN_PATH.'\\.php', BIN_PATH.'\\'.Database::scalar('SELECT name FROM instance WHERE id=?', $php_instance_id));
		}

		if ($mysql_instance_id != null)
		{
			Util::createJunction(BIN_PATH.'\\.mysql', BIN_PATH.'\\'.Database::scalar('SELECT name FROM instance WHERE id=?', $mysql_instance_id).'\\bin');
		}

		if ($pgsql_instance_id != null)
		{
			Util::createJunction(BIN_PATH.'\\.pgsql', BIN_PATH.'\\'.Database::scalar('SELECT name FROM instance WHERE id=?', $pgsql_instance_id).'\\bin');
		}

		set('php_default_instance_id',   $php_instance_id);
		set('mysql_default_instance_id', $mysql_instance_id);
		set('pgsql_default_instance_id', $pgsql_instance_id);

		$php_symlink   = BIN_PATH.'\\.php';
		$mysql_symlink = BIN_PATH.'\\.mysql';
		$pgsql_symlink = BIN_PATH.'\\.pgsql';

		$path = Util::shell_exec(WAMP_PATH.'\\Wamp.NET.exe --path-get');

		if (strpos($path, $php_symlink) === false)
			$path = $php_symlink.';'.$path;

		if (strpos($path, $mysql_symlink) === false)
			$path = $mysql_symlink.';'.$path;

		if (strpos($path, $pgsql_symlink) === false)
			$path = $pgsql_symlink.';'.$path;

		Util::shell_exec(WAMP_PATH.'\\Wamp.NET.exe --path-set '.$path);

		###############################################################################

		\App\Classes\Notify::success('Settings Updated.');
		\App\Classes\Response::redirect('/settings');
	}
}