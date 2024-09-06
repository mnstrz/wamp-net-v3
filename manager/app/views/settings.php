<?php

use App\Classes\Database;
use App\Classes\Layout;
use App\Classes\Site;

Layout::header();

?>

<div class="header">
	<div>Settings</div>
</div>

<div class="body notify">

<form class="validate" method="POST" style="width: 60%;">

	<div class="panel panel-default">
		<div class="panel-heading">Proxy Server</div>
		<div class="panel-body">
			<div class="checkbox checkbox-inline">
				<input class="form-control" type="checkbox" name="proxy_enable" id="proxy_enable" <?= (get('proxy_enable') == "true") ? 'checked' : ''; ?>>
				<label for="proxy_enable">Enabled</label><br><br>
			</div>

			<br>

			<div class="form-group">
				<label class="control-label" for="proxy_host">Host</label>
				<input class="form-control" type="text" name="proxy_host" id="proxy_host" value="<?= get('proxy_host'); ?>">
			</div>

			<div class="form-group">
				<label class="control-label" for="proxy_port">Port</label>
				<input class="form-control" type="text" name="proxy_port" id="proxy_port" value="<?= get('proxy_port'); ?>">
			</div>

			<br>

			<div class="checkbox checkbox-inline">
				<input class="form-control" type="checkbox" name="proxy_auth" id="proxy_auth" <?= (get('proxy_auth') == "true") ? 'checked' : ''; ?>>
				<label for="proxy_auth">Authentication</label><br><br>
			</div>

			<div class="form-group">
				<label class="control-label" for="proxy_user">Username</label>
				<input class="form-control" type="text" name="proxy_user" id="proxy_user" value="<?= get('proxy_user'); ?>">
			</div>

			<div class="form-group">
				<label class="control-label" for="proxy_pass">Password</label>
				<input class="form-control" type="password" name="proxy_pass" id="proxy_pass" value="<?= get('proxy_pass'); ?>">
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Code Launcher</div>
		<div class="panel-body">
			<p>Use variable <strong>%folder%</strong> to replace in path e.g. <strong>"c:\Program Files\Sublime Text 3\subl.exe" %folder%</strong></p>
			<div class="form-group">
				<label class="control-label" for="editor_path">Path</label>
				<input class="form-control" type="text" name="editor_path" id="editor_path" value="<?= htmlentities(get('editor_path')); ?>">
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">CLI Default Servers</div>
		<div class="panel-body">

			<div class="form-group">
				<label class="control-label" for="php_instance_id">PHP Version</label>
				<select class="form-control" id="php_instance_id" name="php_instance_id">
					<option value="-1">-- Disabled --</option>
					<?php
					foreach (\App\Classes\Package::getInstancesByType(['php']) as $httpd_instance): ?>
					<option <?= (get('php_default_instance_id')==$httpd_instance['id']) ? 'selected' : ''; ?> value="<?= $httpd_instance['id']; ?>"><?= $httpd_instance['label']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group">
				<label class="control-label" for="mysql_instance_id">MySQL Version</label>
				<select class="form-control" id="mysql_instance_id" name="mysql_instance_id">
					<option value="-1">-- Disabled --</option>
					<?php
					foreach (\App\Classes\Package::getInstancesByType(['mysql']) as $mysql_instance): ?>
					<option <?= (get('mysql_default_instance_id')==$mysql_instance['id']) ? 'selected' : ''; ?> value="<?= $mysql_instance['id']; ?>"><?= $mysql_instance['label']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group">
				<label class="control-label" for="pgsql_instance_id">PgSQL Version</label>
				<select class="form-control" id="pgsql_instance_id" name="pgsql_instance_id">
					<option value="-1">-- Disabled --</option>
					<?php
					foreach (\App\Classes\Package::getInstancesByType(['pgsql']) as $pgsql_instance): ?>
					<option <?= (get('pgsql_default_instance_id')==$pgsql_instance['id']) ? 'selected' : ''; ?> value="<?= $pgsql_instance['id']; ?>"><?= $pgsql_instance['label']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>

		</div>

	</div>

	<button class="btn btn-success btn-sm">Save Settings</button>

</form>

</div>

<?php

Layout::footer();