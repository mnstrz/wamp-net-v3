<?php

namespace App\Controllers\Tools;

use App\Classes\Database;
use App\Classes\Notify;
use App\Classes\Response;
use App\Classes\Util;
use App\Classes\Validator;

class BenchmarkController
{
	public function index()
	{
		$domains = [];

		$sites = Database::all('SELECT * FROM site WHERE httpd_instance_id NOT NULL ORDER BY name');

		foreach($sites as $site)
		{
			array_push($domains, ["id"=>$site['id'], "name"=>$site['name']]);

			$aliases = Database::all('SELECT * FROM alias WHERE site_id='.$site['id'].' AND alias<> "*" ORDER BY alias');

			foreach($aliases as $alias)
				array_push($domains, ["id"=>$alias['site_id'], "name"=>$alias['alias'].".".$site['name']]);
		}

		$benchmarks = Database::all('SELECT * FROM benchmark ORDER BY created DESC');

		foreach($benchmarks as $benchmark)
		{
			if (!$benchmark['raw'])
			{
				if (!file_exists(TMP_PATH."\\{$benchmark['id']}.pid"))
				{
					$file_data = file_get_contents(TMP_PATH."\\{$benchmark['id']}.txt");

					# Requests per second:    77.12 [#/sec] (mean)
					preg_match('`Requests per second:\s+(\d+\.\d+)`', $file_data, $match);

					$rps = $match[1] ?? '-';

					Database::execute('UPDATE benchmark SET rps=?, raw=? WHERE id=?', $rps, file_get_contents(TMP_PATH."\\{$benchmark['id']}.txt"), $benchmark['id']);
					unlink(TMP_PATH."\\{$benchmark['id']}.txt");
				}
			}
		}

		$benchmarks = Database::all('SELECT * FROM benchmark ORDER BY created DESC');

		require APP_PATH.'/app/views/tools/benchmarks.php';
	}

	public function create()
	{
		$requests    = $_POST['requests'];
		$concurrency = $_POST['concurrency'];
		$site_id     = $_POST['site_id'];
		$domain      = $_POST['domain'];
		$script      = $_POST['script'];
		$proto       = $_POST['proto'];
		$headers     = $_POST['headers'];
		$method      = $_POST['method'];
		$verbosity   = $_POST['verbosity'];
		$data        = $_POST['data'];
		$data_type   = $_POST['data_type'];

		switch($method)
		{
			case 'HEAD'    :
			case 'GET'     :
			case 'DELETE'  :
			case 'OPTIONS' :
			case 'TRACE'   : $m = "-m ".$method;
							 $T = '';
							 $pp = '';
							 break;
			case 'POST'    :
			case 'PUT'     : file_put_contents(TMP_PATH."\\data.txt", $data);
							 $pp = (($method == "PUT") ? '-u ' : '-p ').TMP_PATH."\\data.txt";
							 $m = "";
							 $T = '-T \\"'.$data_type.'\\"';
 		}

		$headers = array_filter(explode("\r\n", trim($headers)));

		$h = '';
		foreach($headers as $header)
		{
			$h .= "-H \\\"".trim($header)."\\\" ";
		}

		$v = new Validator();

		if ($concurrency > 20000)
		{
			$v->control('concurrency', $concurrency)->custom("Can't be greater than 20,000");
		}

		if ($requests < $concurrency)
		{
			$v->control('concurrency', $concurrency)->custom("Can't be greater than requests");
		}

		$v->control('requests', $requests)->required()->number();
		$v->control('concurrency', $concurrency)->required()->number();
		$v->control('domain', $domain)->option();

		$v->validate();

		$site = Database::single('SELECT e.port, e.type, s.name, s.httpd_instance_id, h.label AS httpd, p.label AS php FROM site s
								LEFT JOIN instance h on h.id=s.httpd_instance_id
								LEFT JOIN instance p on p.id=s.php_instance_id
								INNER JOIN endpoint e ON e.instance_id=h.id
								WHERE s.id=? AND type=?', $site_id, $proto);

		$address = $site['type']."://".$domain.":".$site['port']."/".$script;

		$insert_id = Database::insert('INSERT INTO benchmark (created, c, n, address, httpd, php)
			VALUES (?,?,?,?,?,?)', time(), $concurrency, $requests, $address, $site['httpd'], $site['php']);

		$cmd = TOOLS_PATH."\\ab\\abs.exe -q -v $verbosity $m $h $pp $T -c $concurrency -n $requests $address > ".TMP_PATH."\\$insert_id.txt 2>&1 & del ".TMP_PATH."\\$insert_id.pid";

		Util::background("cmd.exe /C \"$cmd\" > ".TMP_PATH."\\$insert_id.pid");
		usleep(100000);

		Notify::success('Benchmark queued');
		Response::redirect('/tools/benchmarks');
	}

	public function report($id)
	{
		echo htmlentities(Database::scalar('SELECT raw FROM benchmark WHERE id=?', $id));
	}

	public function delete($id)
	{
		Database::execute('DELETE FROM benchmark WHERE id=?', $id);
		Notify::success('Benchmark deleted');
		Response::redirect('/tools/benchmarks');
	}

	public function clear()
	{
		Database::execute('DELETE FROM benchmark');
		Notify::success('Benchmarks cleared');
		Response::redirect('/tools/benchmarks');
	}
}