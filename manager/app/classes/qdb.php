<?php

namespace App\Classes;

use Exception;
use PDO;

class QDB
{
	public static function __callStatic($func, $args)
	{
		debug('********************************************************************************');
		debug('Raw info: '.json_encode($args));

		$driver   = $args[1]['driver']   ?? 'mysql';
		$host     = $args[1]['host']     ?? '127.0.0.1';
		$port     = $args[1]['port']     ?? (($driver == 'mysql') ? 3306 : 5432);
		$dbname   = $args[1]['dbname']   ?? (($driver == 'pgsql') ? 'postgres' : null);
		$username = $args[1]['username'] ?? (($driver == 'mysql') ? 'root' : 'postgres');
		$password = $args[1]['password'] ?? null;

		$dsn  = $driver.':host='.$host.';port='.$port.';';
		$dsn .= ($dbname) ? 'dbname='.$dbname.';' : '';

		debug('********************************************************************************');
		debug('Parsed info');
		debug('DSN: '.$dsn);
		debug('Function: '.$func);
		debug('Query: '.$args[0]);

		try
		{
			$pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
			$stmt = $pdo->prepare($args[0]);
			$result = $stmt->execute();

			switch($func)
			{
				case "all"    : debug($r = $stmt->fetchAll(PDO::FETCH_ASSOC)); return $r;
				case "single" : debug($r = $stmt->fetch(PDO::FETCH_ASSOC)); return $r;
				case "scalar" : debug($r = $stmt->fetchColumn()); return $r;
				case "insert" : debug($r = $pdo->lastInsertId()); return $r;
				case "exec"   : debug($r = (($result !== false) ? $stmt->rowCount() : $result)); return $r;
			}
		}
		catch (Exception $e)
		{
			debug('Exception: '.$e->getMessage());
		}
	}

	public static function databaseExists($instance_id, $db_name)
	{
		$database = static::info($instance_id);

		$db_type = $database['type'];
		$db_host   = ($database['interface'] == '0.0.0.0') ? '127.0.0.1' : $database['interface'];
		$db_port = $database['port'];

		$show_databases_query = ($db_type == 'pgsql') ? 'SELECT datname AS "Database" FROM pg_database' : 'SHOW DATABASES';

		$databases = static::all($show_databases_query, ["driver"=>$db_type, "username"=>"wamp", "host"=>$db_host, "port"=>$db_port]);

		if (!$databases)
			return null;

		return in_array($db_name, array_column($databases, 'Database'));
	}

	public static function createDatabase($instance_id, $db_name)
	{
		$database = static::info($instance_id);

		$db_driver = $database['type'];
		$db_host   = ($database['interface'] == '0.0.0.0') ? '127.0.0.1' : $database['interface'];
		$db_port   = $database['port'];

		$result = \App\Classes\QDB::exec("CREATE DATABASE $db_name;", ["driver"=>$db_driver, "host"=>$db_host, "port"=>$db_port, "username"=>"wamp"]);

		return $result;
	}

	public static function info($instance_id)
	{
		return Database::single('SELECT e.* FROM instance i INNER JOIN endpoint e ON i.id=e.instance_id
									WHERE (e.type="mysql" OR e.type="mariadb" OR e.type="pgsql") AND e.instance_id=?', $instance_id);
	}
}