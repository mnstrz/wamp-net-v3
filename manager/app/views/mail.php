<?php

use App\Classes\Database;
use App\Classes\Layout;
use App\Classes\Site;

Layout::header();

?>

<script>
	function empty(id)
	{
		if (modalConfirm('Are you sure you want to empty the mail folder?', function()
		{
			window.location = '/mail/empty';
		}, {type: 'danger'}));
	}
</script>

<div class="header">
	<div>Mail</div>
	<div>
		<div class="btn-toolbar pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-danger" onclick="empty();">Empty</button>
				<button type="button" class="btn btn-sm btn-primary" onclick="$.get('/mail/browse');">Browse</button>
			</div>
		</div>
	</div>
</div>

<div class="body notify">

<?php

$mails = array_reverse(glob(WAMP_PATH."\\manager\\mail\\*.eml"));

if (count($mails) == 0)
{
	?>
	Mail directory is empty.
	<?php
}
else
{
	$count = 0;
	foreach (array_reverse($mails) as $mail)
	{
		$count++;
		?>
		<div id="mail_<?= $count; ?>" class="panel panel-default mail">
			<div class="panel-heading"><?= gmdate("Y-m-d H:i:s", (int)substr(pathinfo($mail)['filename'], 0, 10)); ?> UTC</div>
			<div class="panel-body">
				<div style="white-space: pre-wrap; font-family: monospace;" id="mail_<?= $count; ?>"><?= htmlentities(trim(file_get_contents($mail))); ?></div>
			</div>
			<div class="panel-footer">
				<button onclick="$.get('/mail/open/<?= base64_encode($mail); ?>');" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-envelope-open"></i>&nbsp;&nbsp;Open</button>
				<button onclick="remove(<?= $count; ?>, '/mail/delete/<?= base64_encode($mail); ?>');" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-times"></i>&nbsp;&nbsp;Delete</button>
			</div>
		</div>
		<?php
	}
}
?>

<script>
	function remove(id, file)
	{
		$.get(file); $('#mail_'+id).remove();

		if ($('.mail').length == 0)
			window.location = '/mail';
	}
</script>

</div>

<?php

Layout::footer();