<?php

use App\Classes\Database;
use App\Classes\Instance;
use App\Classes\Layout;
use App\Classes\Package;
use App\Classes\ServiceStatus;
use App\Classes\Util;

Layout::header();

?>

<script>
	function uninstall(instance_id)
	{
		if (modalConfirm('Are you sure you want to uninstall this instance?', function()
		{
			modalWait('Please wait...');
			window.location = '/instance/'+instance_id+'/preUninstall';

		},{type:'danger', focusOnCancelButton: true}));
	}

	function rename(instance_id)
	{
		if (modalQuery('Please enter new label for this instance:', function(label)
		{
			$.post('/instance/'+instance_id+'/rename', {label: label}, function(data)
			{
				eval(data);
			});
		}));
	}

	function toggleService(event, sender, instance_id)
	{
		event.preventDefault();

		var verb = (sender.checked) ? 'Install' : 'Uninstall';
		var msg  = 'Are you sure you want to '+verb.toLowerCase()+' this service?';
		if (modalConfirm(msg, function()
		{
			modalWait(verb + 'ing');
			window.location = '/instance/'+instance_id+'/service'+verb;
		}, {}));
	}

	function control(sender)
	{
		var instance_id = $(sender).data('instance_id');
		switch(verb=$(sender).data('verb'))
		{
			case 'stop' 	: mdl_verb = 'Stopping'; break;
			case 'start' 	: mdl_verb = 'Starting'; break;
			case 'restart'	: mdl_verb = 'Restarting'; break;
		}
		modalWait(mdl_verb+'...');
		window.location = '/instance/'+instance_id+'/'+verb;
	}

	function fopen(type, instance_id)
	{
		$.get('/instance/'+instance_id+'/fopen/'+type);
	}

	function browse(instance_id)
	{
		$.get('/instance/'+instance_id+'/browse');
	}
</script>

	<div class="header">
		<div>Status</div>
		<div><button type="button" class="btn btn-sm btn-success" onclick="window.location = '/packages';">Install Packages</button></div>
	</div>

	<div class="body notify">

	<?php

	if (count($instances = Package::getInstances()) > 0)
	{
		$ss = new ServiceStatus();
		?>
		<div class="panel panel-default">
			<table class="table table-striped">
				<tr>
					<th>name</th>
					<th>installed</th>
					<th>interfaces</th>
					<th>pids</th>
					<th class="text-center">service</th>
					<th>&nbsp;</th>
				</tr>
			<?php
			foreach($instances as $instance)
			{
				# Is it installed as a service?
				$serviceStatus = Util::serviceStatus('wamp.net.'.$instance['name'].'.service');
				$svc = $ss->getByImage(strtolower(BIN_PATH.'\\'.$instance['name'].'\\'.$instance['process']));
				$pids = ($svc) ? Instance::pidsToLabels($svc['pids']) : [];
				$endpoints = ($svc) ? Instance::procsToLabels($svc['endpoints']) : [];

				$running = ($serviceStatus == "running" || count($pids) > 0);

				?>
				<tr>
					<td>
						<?= $instance['label']; ?>
					</td>
					<td>
						<?= gmdate('Y-m-d H:i:s', $instance['created']); ?>
					</td>
					<td style="white-space: normal;">
						<?= (count($endpoints) > 0) ? implode(" ", $endpoints) : '-'; ?>
					</td>
					<td style="white-space: normal;">
						<?= (count($pids) > 0) ? implode(" ", $pids) : '-'; ?>
					</td>
					<td class="text-center">
						<div class="checkbox checkbox-default">
							<input name="install_service_<?= $instance['id']; ?>" onclick="toggleService(event, this, <?= $instance['id']; ?>);" id="install_service_<?= $instance['id']; ?>" type="checkbox" class="checkbox checkbox" <?= ($serviceStatus !== false) ? ' checked' : ''; ?>>
							<label for="install_service_<?= $instance['id']; ?>"></label>
						</div>
					</td>
					<td class="text-right" style="min-width: 290px;">
						<?

						if ($running)
						{
							?>
							<button type="button" class="btn btn-sm btn-danger" data-instance_id="<?= $instance['id']; ?>" data-verb="stop" onclick="control(this);"><i class="fa fa-fw fa-stop"></i>&nbsp;&nbsp;Stop</button>
							<button type="button" class="btn btn-sm btn-warning" data-instance_id="<?= $instance['id']; ?>" data-verb="restart" onclick="control(this);"><i class="fa fa-fw fa-sync-alt"></i>&nbsp;&nbsp;Restart</button>
							<?php
						}
						else
						{
							?>
							<button type="button" class="btn btn-sm btn-success" data-instance_id="<?= $instance['id']; ?>" data-verb="start" onclick="control(this);"><i class="fa fa-fw fa-play"></i>&nbsp;&nbsp; Start</button>
							<?php
						}
						?>

						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-primary" onclick="browse(<?= $instance['id']; ?>);">Browse</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu">
								<li><a href="javascript:;" onclick="rename(<?= $instance['id']; ?>);">Rename</a></li>
								<li><a href="javascript:;" onclick="fopen('conf', <?= $instance['id']; ?>);"<?= (!$instance['conf_file'] || !is_file(BIN_PATH.'\\'.$instance['name'].'\\'.$instance['conf_file'])) ? ' disabled' : ''; ?>>Configure</a></li>

								<?php if ($instance['log_file'] && is_file(BIN_PATH.'\\'.$instance['name'].'\\'.$instance['log_file'])): ?>
								<li><a href="javascript:;" onclick="fopen('log', <?= $instance['id']; ?>);">Log File</a></li>
								<?php endif ?>

								<li><a href="javascript:;" onclick="fopen('cmd', <?= $instance['id']; ?>);">Command Prompt</a></li>

								<li role="separator" class="divider"></li>
								<li><a href="javascript:;" onclick="uninstall(<?= $instance['id']; ?>);"><span class="text-danger">Uninstall</span></a></li>
							</ul>
						</div>
					</td>
				</tr>
				<?php
			}
			?>
			</table>
		</div>
		<?php
	}
	else
	{
		?>
		<p>You have no packages installed.</p>
		<?php
	}
	?>

</div>

<?php
Layout::footer();