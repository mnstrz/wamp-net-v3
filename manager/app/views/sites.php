<?php

use App\Classes\Database;
use App\Classes\Layout;
use App\Classes\Site;

Layout::header();

?>

<script>
	function siteDelete(id)
	{
		if (modalConfirm('Are you sure you want to remove this site?', function()
		{
			modalWait('Removing site...');
			window.location = '/site/'+id+'/delete';
		}, {type: 'danger'}));
	}
</script>

<div class="header">
	<div>Sites</div>
	<div>
		<button type="button" class="btn btn-sm btn-success" onclick="window.location = '/site/add';">Create Site</button>
	</div>
</div>

<div class="body notify">

<?php if (count($sites = Site::getAll()) > 0): ?>

<div class="panel panel-default">
	<table class="table table-striped">
	<tr>
	<th>Domain Name</th>
	<th>Aliases</th>
	<th class="text-center">Browse</th>
	<th>Document Root</th>
	<th class="text-center">Web Server</th>
	<th class="text-center">PHP Version</th>
	<th>&nbsp;</th>
	</tr>

<?php

foreach($sites as $site)
{
	$aliases = '-';

	# Would you mind telling me what ports you're running on for the earls?
	# If you aren't assigned to a web server, don't create earls anyway.
	if (($httpd_instance_id=$site['httpd_instance_id'])==null)
	{
		$browse  = '-';
	}
	else
	{
		$aliases = Database::all('SELECT alias FROM alias WHERE site_id=?', $site['id']);

		if (count($aliases) > 0)
		{
			$aliases = implode(', ', array_column($aliases, 'alias'));
		}
		else
		{
			$aliases = '-';
		}


		$http_port  = Database::scalar('SELECT port FROM endpoint WHERE instance_id=? AND type=?', $site['httpd_instance_id'], 'http');
		$https_port = Database::scalar('SELECT port FROM endpoint WHERE instance_id=? AND type=?', $site['httpd_instance_id'], 'https');

		$browse  = '<a target="_blank" href="http://' .$site['name'].(($http_port != 80) ? ':'.$http_port  : '') . '">http</a>';
		$browse .= ' | ';
		$browse .= '<a target="_blank" href="https://'.$site['name'].(($https_port!=443) ? ':'.$https_port : '') . '">https</a>';
	}
	?>
	<tr>
		<td><?= $site['name']; ?></td>
		<td><?= $aliases; ?></td>
		<td class="nowrap text-center"><?= $browse; ?></td>
		<td><a href="javascript:;" onclick="$.get('/site/<?= $site['id']; ?>/browse'); this.blur();"><?= $site['document_root']; ?></a></td>
		<?php $httpd_title = Database::scalar('SELECT label FROM instance WHERE id=?', $site['httpd_instance_id']); ?>
		<td class="text-center"><?= ($httpd_title) ? $httpd_title : '-'; ?></td>
		<?php $php_version = Database::scalar('SELECT label FROM instance WHERE id=?', $site['php_instance_id']); ?>
		<td class="text-center"><?= ($php_version) ? $php_version : '-'; ?></td>
		<td class="text-right nowrap">
			<div class="btn-group btn-group-flex">
				<button onclick="siteDelete(<?= $site['id']; ?>);" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></button>
				<button onclick="window.location = '/site/<?= $site['id']; ?>/edit';" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-cog"></i></button>

				<?php if (!empty(get('editor_path'))): ?>
				<button onclick="$.get('/site/<?= $site['id']; ?>/code');" class="btn btn-sm btn-info"><i class="fa fa-fw fa-code"></i></button>
				<?php else: ?>
				<button onclick="alert('Please enter valid path to editor in settings.');" class="btn btn-sm btn-info"><i class="fa fa-fw fa-code"></i></button>
				<?php endif; ?>
			</div>

		</td>
	</tr>

<?php
}
?>

</table>
</div>

<?php else: ?>

<p>You do not have any sites configured.</p>

<?php endif; ?>

</div>

<?php Layout::footer();