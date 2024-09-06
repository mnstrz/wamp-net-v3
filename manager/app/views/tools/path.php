<?php

use App\Classes\Layout;
use App\Classes\Util;

Layout::header();

?>

<script>
	function toggleDeleted(obj)
	{
		if ($(obj).hasClass('btn-danger'))
		{
			$(obj).addClass('btn-success').removeClass('btn-danger');
			$(obj).find('.fa').addClass('fa-undo').removeClass('fa-trash');
			$(obj).parent().parent().find('span.path').css('text-decoration', 'line-through').addClass('deleted');
		}
		else
		{
			$(obj).addClass('btn-danger').removeClass('btn-success');
			$(obj).find('.fa').addClass('fa-trash').removeClass('fa-undo');
			$(obj).parent().parent().find('span.path').css('text-decoration', 'none').removeClass('deleted');;
		}
	}

	function addItem(path, isNew)
	{
		var isNew = isNew || false;

		var item = 	'<li class="list-group-item clearfix" draggable="true" style="line-height: 30px;">';
			item +=	'	<div class="pull-right">';
			item +=	'		<button class="btn btn-sm btn-danger" onclick="toggleDeleted(this)"><span class="fa fa-fw fa-trash"></span></button>';
			item +=	'	</div>';
			item +=	'	<span class="fas fa-arrows-alt"></span>&nbsp;&nbsp;<span class="path'+((isNew) ? ' text-success' : '')+'">'+path+'</span>';
			item +=	'</li>';
		$('#items').append(item);
	}

	function update()
	{
		var newPath = '';
		$(".path").not(".deleted").map(function()
		{
    		newPath += $(this).text()+';';
    	});

    	$.post('/tools/path', {newPath: newPath.replace(/;$/,'')}, function(result)
    	{
    		eval(result);
    	});
	}

	function applySortable()
	{
		$('.list-group-sortable-handles').sortable({placeholderClass: 'list-group-item'});
	}

	function addPath()
	{
		fb(function(data)
		{
			addItem(data, true);
			applySortable();
		});
	}

	$(document).ready(function()
	{
		applySortable();
	});
</script>

<div class="header">
	<div>System Path</div>
	<div><button type="button" class="btn btn-sm btn-success" onclick="addPath();">Add Path</button></div>
</div>

<div class="body notify">

	<p>Drag and Drop items to arrange order of priority</p><br>

	<div class="panel panel-default" style="margin-bottom: 20px;">

		<ul id="items" class="list-group list-group-sortable-handles">
			<?php
			$items = explode(';', trim(Util::shell_exec(WAMP_PATH.'/Wamp.NET.exe --path-get')));
			foreach($items as $item): ?>
				<script>addItem(<?= json_encode($item); ?>);</script>
			<?php endforeach ?>
		</ul>
	</div>

	<button class="btn btn-sm btn-success" onclick="update();">Update</button>

</div>

<?php Layout::footer();