<?php

namespace App\Classes;

use PDO;
use Exception;

class Database
{
	private static $_instance = null;

	public static $interpolated = null;

	private $_pdo;
	private $_stmt;

	public static function get_instance()
	{
		return self::$_instance ?? self::$_instance = new self();
	}

	private function __construct()
	{
		try
		{
			$this->_pdo = new PDO('sqlite:'.APP_PATH.'/manager.db');
        }
        catch(PDOException $e)
		{
			$this->_exception($e);
        }
	}

	/**
	 * Strip outer quotes for cases where LIKE '%%' needs to be used.
	 */
	public static function quote($str, $strip_outer_quotes = false)
	{
		if ($strip_outer_quotes)
			return trim(self::get_instance()->_pdo->quote($str), "'");
		else
			return self::get_instance()->_pdo->quote($str);
	}

	private function _exception($e)
	{
		echo $e->getMessage();
	}

	private function _prepare($sql, ...$vals)
	{
		try
		{
			$c = 0;
			foreach  ($vals as $v)
			{
				$str = '';
				if (is_array($v))
					foreach ($v as $i)
						$str .= ':c' . $c++ . ',';
				else
					$str = ':c' . $c++;
				$sql = substr_replace($sql, trim($str, ','), strpos($sql, '?')) . substr($sql, strpos($sql, '?')+1);
			}

			self::$interpolated = $sql;

			$this->_stmt = $this->_pdo->prepare($sql);

			$c = 0;
			foreach  ($vals as $v)
				if (is_array($v))
					foreach ($v as $i)
						$this->_bind(':c' . $c++, $i);
				else $this->_bind(':c' . $c++, $v);
		}
		catch (Exception $e)
		{
			$this->_exception($e);
		}
	}

	private function _bind($c, $v)
	{
		switch (true)
		{
			case is_int($v)  : $type = PDO::PARAM_INT;  $interpolated_val = $v;     break;
			case is_bool($v) : $type = PDO::PARAM_BOOL; $interpolated_val = $v;     break;
			case is_null($v) : $type = PDO::PARAM_NULL; $interpolated_val = 'NULL'; break;
			default          : $type = PDO::PARAM_STR;  $interpolated_val = $this->_pdo->quote($v);
		}

		self::$interpolated = preg_replace('`'.$c.'`', $interpolated_val, self::$interpolated, 1);

		try
		{
			$this->_stmt->bindValue($c, $v, $type);
		}
		catch (Exception $e)
		{
			$this->_exception($e);
		}
	}

	private function _execute()
	{
		try
		{
			$this->_stmt->execute();
		}
		catch (Exception $e)
		{
			$this->_exception($e);
		}
	}

	public static function all($sql, ...$values)
	{
		self::get_instance();
		self::$_instance->_prepare($sql, ...$values);
		self::$_instance->_execute();
		try
		{
			return self::$_instance->_stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $e)
		{
			self::$_instance->_exception($e);
		}
	}

	public static function single($sql, ...$values)
	{
		self::get_instance();
		self::$_instance->_prepare($sql, ...$values);
		self::$_instance->_execute();
		try
		{
			return self::$_instance->_stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch(Exception $e)
		{
			self::$_instance->_exception($e);
		}

	}

	public static function scalar($sql, ...$values)
	{
		self::get_instance();
		self::$_instance->_prepare($sql, ...$values);
		self::$_instance->_execute();

		try
		{
			return self::$_instance->_stmt->fetchColumn();
		}
		catch(Exception $e)
		{
			self::$_instance->_exception($e);
		}
	}

	public static function insert($sql, ...$values)
	{
		self::get_instance();
		self::$_instance->_prepare($sql, ...$values);
		self::$_instance->_execute();
		try
		{
			return intval(self::$_instance->_pdo->lastInsertId());
		}
		catch(Exception $e)
		{
			self::$_instance->_exception($e);
		}
	}

	public static function execute($sql, ...$values)
	{
		self::get_instance();
		self::$_instance->_prepare($sql, ...$values);
		self::$_instance->_execute();
		return self::$_instance->_stmt->rowCount();
	}

	/**
	 * Last two parameters should be $page number and record count in that order
	 */
	public static function paginate($sql, ...$values)
	{
		$sql = preg_replace('`select(\s)`i', 'select SQL_CALC_FOUND_ROWS ', $sql, 1) . ' LIMIT ? OFFSET ?';

		if (count($values) < 2)
			throw new Exception('Pagination requires that $values contains at least parameters for $page and $count');

		$count = array_pop($values);
		$page  = array_pop($values);

		if (!is_numeric($page) || !is_numeric($count))
			throw new Exception('Pagination $page and $count are not valid integer values');

		# Create new object to return pagination information
		$result = new \stdClass();

		if (count($values) > 0)
		{
			array_push($values, $count);
			array_push($values, ($page-1)*$count);
			$result->data = static::all($sql, ...$values);
		}
		else
		{
			$result->data = static::all($sql, $count, ($page-1)*$count);
		}

		$result->total = static::scalar('SELECT FOUND_ROWS()');
		$result->from  = (($page-1)*$count)+1;
		$result->to    = ((($page-1)*$count)+$count > $result->total) ? $result->total : (($page-1)*$count)+$count;
		$result->rows  = count($result->data);
		$result->page  = $page;
		$result->count = $count;
		$result->pages = ceil($result->total/$result->count);

		return $result;
	}
}