<?php

namespace App\Classes;

class Installer
{
	public function __construct($title = '')
	{
		$this->title = $title;
		?>
		init(<?= json_encode($title); ?>);
		<?php
	}

	public function addTask($title)
	{
		?>
		addTask(<?= json_encode($title); ?>);
		<?php

		return $this;
	}

	public function startTask()
	{
		# Breathing room (not really required, but some installs are
		# so fast, it looks like it hasn't happened.)
		Util::sleep(250);
		?>
		startTask();
		<?php

		return $this;
	}

	public function console($data)
	{
		?>
		console.log(<?= json_encode($data); ?>);
		<?php

		return $this;
	}

	public function updateTask($data)
	{
		?>
		updateTask(<?= json_encode($data); ?>);
		<?php

		return $this;
	}

	public function download($package)
	{
		$cached_download = DOWNLOAD_PATH.'\\'.$package['id'].'.zip';

		# a cached version of the file might exist but may be corrupt from a previous transfer
		# which failed to delete. If so, delete now, it needs to be re-downloaded.
		if (file_exists($cached_download) && $package['filehash'] != sha1_file($cached_download))
			Util::del($cached_download);

		# If the file doesn't exist in local cache, download now...
		if (!is_file($cached_download))
		{
			# first, we will send version, to make sure we are up to date. This would avoid
			# the user trying to download a package that doesn't exist anymore for whatever
			# reason.

			$d = new Downloader(get('wamp_url').'version.php?version='.get('version'));

			if (($result = $d->get()) === null)
			{
				Notify::error($d->error);
				?>
				window.location = '/';
				<?php
				exit;
			}

			if ($result == '-1')
			{
				Notify::error('Please <a href="javascript: update_check();">update</a> to the latest version before installing packages.');
				?>
				window.location = '/';
				<?php
				exit;
			}

			$installer = $this;
			(new Downloader(get('wamp_url').'download.php?id='.$package['id'].'&version='.get('version'), function($progress) use ($installer)
			{
				$installer->updateTask('('.$progress.'%)');
			}))->save($cached_download);

			if ($package['filehash'] != sha1_file($cached_download))
			{
				Util::del($cached_download);
				Notify::error("Error downloading file");
				?>
				window.location = '/';
				<?php
				exit;
			}
		}
	}

	public function unzip($package, $dest)
	{
		$uz = new UnzipMe(DOWNLOAD_PATH.'\\'.$package['id'].'.zip');
		$installer = $this;
		$uz->on_next = function($file, $count) use ($uz, $installer)
		{
			$installer->updateTask(' ('.round($count/$uz->file_count*100).'% - '.$file.')');
		};
		$uz->unzip($dest, ["strip"=>1]);
	}

	public function complete($url = '/')
	{
		Response::redirect($url);
	}

	public static function form_begin($package)
	{
		Layout::header();
		?>
		<div class="header">
			<div><?= ucfirst($package['title']); ?> <?= $package['version']; ?> (<?= $package['arch']; ?>) Installation</div>
		</div>

		<div class="body notify">


			<div id="tasks"></div>

			<form method="POST" class="validate" style="width: 50%;">
				<input type="hidden" name="package_id" value="<?= $package['id']; ?>">
				<input type="hidden" name="cmd" value="verify">

		<?php
	}

	public static function form_text($options)
	{
		?>
		<div class="form-group">
			<label class="control-label" for="<?= $options['id']; ?>"><?= $options['label']; ?></label>
			<input
				type="text"
				class="form-control"
				id="<?= $options['id']; ?>"
				name="<?= $options['id']; ?>"
				<?= (isset($options['autofocus']))   ? 'autofocus' : ''; ?>
				<?= (isset($options['placeholder'])) ? 'placeholder="'.$options['placeholder'].'"' : ''; ?>
				<?= (isset($options['value']))       ? 'value="'.$options['value'].'"' : ''; ?>
			>
	    </div>
		<?php
	}

	public static function form_label($text)
	{
		?>
		<label><?= $text; ?></label>
		<?php
	}

	public static function form_break()
	{
		?>
		<br>
		<?php
	}

	public static function form_checkbox($options)
	{
		?>
		<div class="form-group">
			<div class="checkbox checkbox-default">
				<input id="<?= $options['id']; ?>" name="<?= $options['id']; ?>" type="checkbox"<?= ($options['checked']) ? ' checked' : ''; ?> <?= ($options['disabled']) ? ' disabled' : ''; ?> <?= (isset($options['depends'])) ? ' onclick="(!$(this).prop(\'checked\')) ? $(\'#'.implode(", #", $options['depends']).'\').prop(\'disabled\', false) : $(\'#'.implode(", #", $options['depends']).'\').prop(\'checked\', true).prop(\'disabled\', true);"' : ''; ?>>
				<label class="control-label" for="<?= $options['id']; ?>"><?= $options['label']; ?></label>
		    </div>
		</div>
		<?php
	}

	public static function form_directory_browser($name, $label, $path='')
	{
		?>
		<div class="form-group">
			<label for="<?= $name; ?>"><?= $label; ?></label>
			<div class="input-group">
				<input id="<?= $name; ?>" name="<?= $name; ?>" type="text" class="form-control" placeholder="Leave blank to assign automatically (Recommended)" value="<?= $path; ?>">
				<div class="input-group-btn">
					<button type="button" class="btn btn-default" onclick="fb(function(data) { $('#<?= $name; ?>').val(data); });">Browse</button>
				</div>
			</div>
		</div>
		<?php
	}

	public static function form_interface()
	{
		?>
		<div class="form-group">
			<label>Interface</label>
			<select class="form-control" id="interface" name="interface">
				<option class="text-success" selected value="127.0.0.1">127.0.0.1 (Local Only - Recommended)</option>
				<option class="text-danger" value="0.0.0.0">0.0.0.0 (All Interfaces)</option>
				<?php foreach(Util::getInterfaces() as $interface): ?>
				<option class="text-warning" value="<?= $interface['address']; ?>"><?= $interface['address']; ?> (<?= $interface['name']; ?> - <?= $interface['description']; ?>)</option>
				<?php endforeach ?>
			</select>
	    </div>
		<?php
	}

	public static function form_site($options = [])
	{
	    ?>
		<div class="form-group" id="fg_site_id">
			<label class="control-label" for="site_id">Site</label>
			<select class="form-control" id="site_id" name="site_id" <?= (isset($options['autofocus'])) ? 'autofocus' : ''; ?>>
				<option selected value="-1">-- Select --</option>
				<?php foreach(\App\Classes\Site::getAll() as $site): ?>
				<option value="<?= $site['id']; ?>"><?= $site['name']; ?></option>
				<?php endforeach ?>
			</select>
		</div>

    	<div class="form-group">
			<label class="control-label" for="path">Path</label>
			<input class="form-control" type="text" id="path" name="path" placeholder="e.g. /dir/blog (Optional - leave blank to install in root of site)">
		</div>
		<?php
	}

	public static function form_site_validate($validator)
	{
	    $validator->control('site_id', $_POST['site_id'])->option('Please select a site.')->validate();

	    $site = Site::getById($_POST['site_id']);

	    $document_root = $site['document_root'];

		# if not path specified and document root is not empty
		if (empty($_POST['path']) && !Util::isDirectoryEmpty($document_root))
		{
			$validator->control('site_id', $_POST['site_id'])->custom('Document root already contains files/folders')->validate();
		}

		if (!empty($_POST['path']))
		{
			$validator->control('path', $_POST['path'])->regex(["pattern"=>"`^\/(?:(?:[\w\d-]\/?)*[A-Za-z0-9])$`", "msg"=>"Format incorrect: start with a forward slash with no trailing slash"])->validate();

			$path = slash($document_root.$_POST['path'], "\\");

			if (is_dir($path) && !Util::isDirectoryEmpty($path))
				$validator->control('path', $_POST['path'])->custom('Folder already contains files/folders')->validate();
		}
	}

	public static function form_database($types = [])
	{
		?>
		<div class="form-group">
			<div class="radio radio-inline radio-primary">
				<input checked type="radio" id="rdo_db_new" name="db_type" value="new" onclick="$('#database_id, #db_name').prop('disabled', false); $('#lbl_db').html('New Database Name');">
				<label for="rdo_db_new">New Database</label>
			</div>
			<div class="radio radio-inline radio-primary">
				<input type="radio" id="rdo_db_existing" name="db_type" value="existing" onclick="$('#database_id, #db_name').prop('disabled', false); $('#lbl_db').html('Existing Database Name');">
				<label for="rdo_db_existing">Existing Database</label>
			</div>
			<div class="radio radio-inline radio-primary">
				<input type="radio" id="rdo_db_none" name="db_type" value="none" onclick="$('#database_id, #db_name').prop('disabled', true);">
				<label for="rdo_db_none">No Database</label>
			</div>
		</div>

		<div class="form-group">
			<label class="control-label" for="database_id">Database Server</label>
			<select class="form-control" id="database_id" name="database_id">
				<option selected value="-1">-- Select --</option>
				<?php foreach (\App\Classes\Package::getInstancesByType($types) as $database): ?>
				<option value="<?= $database['id']; ?>"><?= $database['label']; ?></option>
				<?php endforeach ?>
			</select>
	    </div>
	    <div class="form-group">
			<label class="control-label" for="db_name" id="lbl_db">New Database Name</label>
			<input class="form-control" type="text" id="db_name" name="db_name" placeholder="e.g. laravel">
		</div>
		<?php
	}

	public static function form_database_validate($validator)
	{
		if ($_POST['db_type'] != 'none')
		{
			$validator->control('database_id', $_POST['database_id'])->option('Please select a database.')->validate();

			if (empty($_POST['db_name']))
				$validator->control('db_name', $_POST['db_name'])->required()->validate();

			if ($_POST['db_type'] == 'new' || $_POST['db_type'] == 'existing')
			{
				$db_exists = \App\Classes\QDB::databaseExists($_POST['database_id'], $_POST['db_name']);

				if ($db_exists === null)
				{
					$validator->control('database_id', $_POST['database_id'])->custom('Could not connect to database. Is it running?');
				}
				else
				{
					if ($_POST['db_type'] == 'new' && $db_exists)
					{
						$validator->control('db_name', $_POST['db_name'])->custom('Database already exists');
					}

					if ($_POST['db_type'] == 'existing' && !$db_exists)
					{
						$validator->control('db_name', $_POST['db_name'])->custom('No such database');
					}

					$validator->validate();
				}
			}
		}
	}

	public static function form_integer($name, $label, $value)
	{
		?>
		<div class="form-group">
			<label for="<?= $name; ?>"><?= $label; ?></label><br>
			<input class="form-control" id="<?= $name; ?>" name="<?= $name; ?>" style="width: 240px; display: inline;" type="text" value="<?= $value; ?>">
	    </div>
		<?php
	}

	public static function form_password($name, $label)
	{
		?>
		<div class="form-group">
			<label><?= $label; ?></label><br>
			<input class="form-control" name="<?= $name; ?>" style="width: 240px; display: inline;" type="password" value="<?= $value; ?>">
	    </div>
		<?php
	}

	public static function form_select($name, $label, $arr, $default='')
	{
		?>
		<div class="form-group">
			<label><?= $label; ?></label><br>
			<select class="form-control" name="<?= $name; ?>">
				<?php foreach($arr as $a): ?>
				<option<?php if ($default == $a['value']) echo ' selected'; ?>><?= $a['value']; ?></option>
				<?php endforeach ?>
			</select>
	    </div>
		<?php
	}

	public static function form_end()
	{
		?>
				<br>
				<div class="form-group">
					<button class="btn btn-sm btn-primary" type="submit">Continue</button>
					<button onclick="window.location = '/packages';" class="btn btn-sm btn-link" type="button">Cancel</button>
				</div>
			</form>
		</div>
		<?php Layout::footer();
	}
}