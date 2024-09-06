<?php

use App\Classes\Database;
use App\Classes\Instance;
use App\Classes\Layout;
use App\Classes\Package;
use App\Classes\Util;

Layout::header();

?>

<div class="header">
	<div>Developer</div>
</div>

<div class="body notify">

	<div class="panel panel-default">
		<div class="panel-heading">Package Upload</div>
		<div class="panel-body">
			<form method="POST" style="width: 50%;" enctype="multipart/form-data" action="/dev/upload">
				<div class="form-group">
					<label class="control-label" for="name">Copy Values From Package</label>
					<select class="form-control" name="id">
						<option>-- Select --</option>
						<?php
						$packages = Database::all('SELECT p.*, v.title FROM package p INNER JOIN vendor v ON p.vendor_id=v.id ORDER BY title, version, arch DESC');

						foreach ($packages as $package): ?>
						<option value="<?= $package['id']; ?>"><?= $package['title']; ?> <?= $package['version']; ?> (<?= $package['arch']; ?>)</option>
						<?php endforeach ?>

						?>
					</select>
				</div>
				<div class="form-group">
					<label class="control-label" for="version">New Package Version</label>
					<input type="text" style="text-transform: lowercase;" class="form-control" id="version" name="version" placeholder="e.g 10.9.3">
				</div>
				<div class="form-group">
					<label class="control-label" for="document_root">Package</label>
					<input style="cursor: pointer;" class="form-control" readonly onclick="$(this).parent().find('input[type=file]').click();">
					<span class="input-group-btn">
						<input name="package" id="package" onchange="$(this).parent().parent().find('.form-control').val($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file">
					</span>
				</div>
		  		<div class="form-group">
					<button class="btn btn-sm btn-primary">Upload</button>
				</div>
			</form>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">Set Version</div>
		<div class="panel-body">
			<form method="POST" style="width: 50%;" action="/dev/version">
				<div class="form-group">
					<label class="control-label" for="version">Version</label>
					<input type="text" style="text-transform: lowercase;" class="form-control" id="version" name="version" value="9.9.9" placeholder="e.g 10.9.3">
				</div>
				<div class="form-group">
					<button class="btn btn-sm btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>

</div>

<?php Layout::footer();