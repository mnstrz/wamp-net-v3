<?php

namespace App\Classes;

class Package
{
	public static function getById($package_id)
	{
		return Database::single('SELECT p.*, v.description, v.title FROM package p INNER JOIN vendor v ON p.vendor_id=v.id WHERE p.id=?', $package_id);
	}

	public static function getByInstanceId($instance_id)
	{
		return Database::single('SELECT p.*, v.description, v.title FROM package p INNER JOIN vendor v ON p.vendor_id=v.id WHERE p.id=(SELECT package_id FROM instance WHERE id=?)', $instance_id);
	}

	public static function add($package_id, $label)
	{
		return Database::insert('INSERT INTO instance (package_id, label, created) VALUES (?,?,?)', $package_id, $label, time());
	}

	public static function remove($instance_id)
	{
		Database::execute('DELETE FROM instance WHERE id=?', $instance_id);
	}

	public static function getInstances()
	{
		return Database::all('SELECT i.*, p.process, v.title, p.version, p.arch, v.type, p.conf_file, p.log_file FROM instance i
								INNER JOIN package p ON i.package_id=p.id
								INNER JOIN vendor v ON p.vendor_id=v.id');
	}

	public static function getInstancesByType($types)
	{
		return Database::all('SELECT i.id, i.label FROM instance i INNER JOIN package p ON i.package_id=p.id INNER JOIN vendor v ON p.vendor_id=v.id WHERE v.type IN (?)', $types);
	}

	public static function control($instance_id, $cmd)
	{
		$package = static::getByInstanceId($instance_id);
		(require APP_PATH.'\\app\\classes\\instances\\'.$package['class_file'])->init($package, $cmd, $instance_id);
	}
}