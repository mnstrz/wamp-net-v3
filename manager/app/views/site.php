<?php

use App\Classes\Database;
use App\Classes\Instance;
use App\Classes\Layout;
use App\Classes\Package;
use App\Classes\Util;
use App\Classes\Site;

if (!$isEditing)
{
	$title     = 'Create Site';
	$cmd       = 'create';
	$name      = '';
	$aliases   = '';
	$btn_text  = 'Create';
}
else
{
	$title     = 'Edit Site';
	$cmd       = 'edit';
	$btn_text  = 'Update';
	$site      = Site::getById($site_id);
	$name      = $site['name'];

	$aliases = Database::all("SELECT alias FROM alias WHERE site_id=?", $site_id);

	if (count($aliases) == 0)
		$aliases = '';
	else
		$aliases = implode(", ", array_column($aliases, 'alias'));

	if (!$site)
	{
		Notify::error('No such site.');
		redirect('/sites');
	}
}

Layout::header();

?>
<div class="header">
	<div><?= $title; ?></div>
</div>

<div class="body notify">

<form class="validate" method="POST" style="width: 50%;">
	<input type="hidden" name="cmd" value="<?= $cmd; ?>">

	<div class="form-group">
		<label class="control-label" for="name">Domain Name</label>
		<input type="text" style="text-transform: lowercase;" class="form-control" id="name" name="name" placeholder="e.g example.local" value="<?= $name; ?>" autofocus>
	</div>

	<div class="form-group">
		<label class="control-label" for="aliases">Domain Aliases</label>
		<input type="text" style="text-transform: lowercase;" class="form-control" id="aliases" name="aliases" placeholder="e.g www OR www, api OR *" value="<?= $aliases; ?>">
	</div>

	<div class="form-group">
		<label class="control-label" for="document_root">Document Root</label>
		<div class="input-group">
			<input id="document_root" name="document_root" type="text" class="form-control" placeholder="Leave blank for default" value="<?= ($isEditing) ? $site['document_root'] : ''; ?>">
			<div class="input-group-btn">
				<button type="button" class="btn btn-default" onclick="fb(function(data) { $('#document_root').val(data); });">Browse</button>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="control-label" for="httpd_package_id">Web Server</label>
		<select class="form-control" id="httpd_instance_id" name="httpd_instance_id">
			<option value="-1">-- Selected --</option>
			<?php
			foreach (Package::getInstancesByType(['httpd']) as $httpd_instance): ?>
			<option <?= ($isEditing && $site['httpd_instance_id']==$httpd_instance['id']) ? 'selected' : ''; ?> value="<?= $httpd_instance['id']; ?>"><?= $httpd_instance['label']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="form-group">
		<label class="control-label" for="php_instance_id">PHP Version</label>
		<select class="form-control" id="php_instance_id" name="php_instance_id">
			<option value="-1">-- Selected --</option>
			<?php
			foreach (Package::getInstancesByType(['php']) as $php_instance): ?>
			<option <?= ($isEditing && $site['php_instance_id']==$php_instance['id']) ? 'selected' : ''; ?> value="<?= $php_instance['id']; ?>"><?= $php_instance['label']; ?></option>
			<?php endforeach; ?>
		</select>
	</div>

	<div class="form-group">
		<button class="btn btn-sm btn-primary"><?= $btn_text; ?></button>
		<button onclick="window.location = '/sites';" type="button" class="btn btn-sm btn-link">Cancel</button>
	</div>
</form>

</div>

<?php
Layout::footer();