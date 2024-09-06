<?php

use App\Classes\Layout;
use App\Classes\Util;

Layout::header();

function str_trunc($str, $len, $breakWord=false)
{
    if (strlen($str) > $len)
    {
        $str = substr($str, 0, ($len -3));

        if ($breakWord)
            $str .= '...';
        else
            $str = substr($str, 0, strrpos($str,' ')).'...';
    }
    return $str;
}

?>

<script>
	function kill(pid)
	{
		$.get('/tools/process/'+pid, {}, function(data)
		{
			eval(data);
		});
	}
</script>

<div class="header">
	<div>Processes</div>
</div>

<div class="body notify">
	<div class="panel panel-default">
		<table class="table table-striped">
			<tr>
				<th>ID</th>
				<th>Executable</th>
				<th>Path</th>
				<th>&nbsp;</th>
			</tr>
			<?php

			$ss = new \App\Classes\ServiceStatus();

			foreach($ss->getProcData() as $omg)
			{
				list($pid, $proc) = explode("\t", $omg);
				$jesus = explode('\\', $proc);
				$executable = end($jesus);
				$path = dirname($proc);
				?>
				<tr>
					<td><?= $pid; ?></td>
					<td title="<?= $executable; ?>"><?= str_trunc($executable, 64, true); ?></td>
					<td title="<?= $path; ?>"><?= str_trunc($path, 64, true); ?></td>
					<td style="text-align: right;"><button class="btn btn-sm btn-danger" onclick="kill(<?= $pid; ?>);"><i class="fa fa-fw fa-times"></i>&nbsp;&nbsp;Kill</button></td>
				</tr>
				<?php
			}
			?>

		</table>
	</div>
</div>

<?php Layout::footer();