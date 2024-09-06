<?php

use App\Classes\Database;
use App\Classes\Instance;
use App\Classes\Layout;
use App\Classes\Package;
use App\Classes\Util;

Layout::header();

?>
<script>
	function install(package_id)
	{
		modalWait('Please wait...');
		window.location = '/package/'+package_id+'/add';
	}
</script>

<div class="header">
	<div>Packages</div>
</div>

<div class="body notify">

	<div id="package_grid">

<?php

$packages = Database::all('SELECT p.*, v.description, v.title, v.logo FROM package p
							INNER JOIN vendor v ON p.vendor_id=v.id
							WHERE p.disabled<>1
							ORDER BY v.title, version DESC, arch');

for ($i=0; $i<count($packages); $i++)
{
	$parts = explode('.', $packages[$i]['version']);

	$packages[$i]['version_normalised'] = str_pad($parts[0], 3, '0', STR_PAD_LEFT).str_pad($parts[1], 3, '0', STR_PAD_LEFT).str_pad($parts[2], 3, '0', STR_PAD_LEFT);
}

array_multisort(array_column($packages, 'title'),  SORT_ASC, array_column($packages, 'version_normalised'), SORT_DESC, array_column($packages, 'arch'), SORT_ASC, $packages);

$is64 = Util::is64();

$new = [];

$current_vendor = null;

foreach($packages as $package)
{
	if (!$is64 && $package['arch'] == 'x64') continue;

	$new[$package['vendor_id']][] = $package;
}

foreach ($new as $n)
{
	?>
	<div class="package-container">
		<div class="package-icon"><img src="<?= $n[0]['logo']; ?>"></div><br>
		<h3><?= ucfirst($n[0]['title']); ?></h3>
		<p><?= $n[0]['description']; ?></p>
		<div class="btn-group">
			<button type="button" onclick="install(<?= $n[0]['id']; ?>)" class="btn btn-success">Install <?= $n[0]['version']; ?> (<?= $n[0]['arch']; ?>)</button>
			<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="caret"></span>
				<span class="sr-only">Toggle Dropdown</span>
			</button>
			<ul class="dropdown-menu scrollable-menu">
				<?php foreach ($n as $p): ?>
				<li><a href="javascript:;" onclick="install(<?= $p['id']; ?>)"><?= $p['version']; ?> (<?= $p['arch']; ?>)</a></li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
	<?php
}
?>

	</div>

</div>

<?php Layout::footer();