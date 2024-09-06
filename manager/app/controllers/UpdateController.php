<?php

namespace App\Controllers;

use App\Classes\Database;
use App\Classes\Downloader;
use App\Classes\Notify;
use App\Classes\Response;
use App\Classes\Util;

class UpdateController
{
	public function check()
	{
		$data = new Downloader(get('wamp_url').'update.php?cmd=check&version='.get('version').'&store_hash='.get('store_hash'));
		$result = $data->get();
		echo $result;
	}

	public function update()
	{
		$tmp_file = Util::getTempFile();
		$data = (new Downloader(get('wamp_url').'update.php?cmd=update&version='.get('version')))->save($tmp_file);
		require $tmp_file;
		exit;
	}

	public function sync()
	{
		$version = get('version');
		$store_hash_local = get('store_hash');

		$d = new Downloader(get('wamp_url').'store_sync.php?version='.$version.'&store_hash='.$store_hash_local);

		$data = $d->get();

		if ($data == "-1")
		{
			# not on latest Wamp.NET version
			Notify::error("You are required to be on the latest version of Wamp.NET in order to sync packages.");
		}
		else if ($data == $store_hash_local)
		{
			# already in sync
			Notify::error("You are already in sync!");
		}
		else
		{
			$json = json_decode($data);

			Database::execute('DELETE FROM vendor');
			foreach ($json->store->vendor as $v)
			{
				Database::execute('INSERT INTO vendor VALUES (?,?,?,?,?)',
					$v->id,
					$v->title,
					$v->description,
					$v->type,
					$v->logo);
			}

			Database::execute('DELETE FROM package');
			foreach ($json->store->package as $p)
			{
				Database::insert('INSERT INTO package (id,	version, class_file, process, conf_file, log_file, arch, filesize, filehash, vendor_id, disabled) VALUES (?,?,?,?,?,?,?,?,?,?,?)',
					$p->id,
					$p->version,
					$p->class_file,
					$p->process,
					$p->conf_file,
					$p->log_file,
					$p->arch,
					$p->filesize,
					$p->filehash,
					$p->vendor_id,
					$p->disabled);
			}

			set('store_hash', $json->hash);

			Notify::success("Packages successfully updated.");
		}

		Response::redirect('/');
	}
}