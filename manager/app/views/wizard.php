<?php

use App\Classes\Layout;

Layout::header();

?>

<script>
    function hermione()
    {
    	var currentLine = 0;

        $.ajax("<?= $_SESSION['wizard']; ?>",
        {
            xhrFields:
            {
                onprogress: function(e)
                {
                    var lines = e.currentTarget.response.split("\n");

                    while (lines.length > currentLine+1)
                    {
                    	eval(lines[currentLine]);
                    	currentLine++;
                    }
                }
            }
        });
    }

	var activeTask = 0;

	function init(title)
	{
		div_task.innerHTML = title;
	}

	function addTask(title)
	{
		$('<div class="task-block"><i class="far fa-fw fa-square"></i> <span class="task-title">' + title + '</span> <span class="task-progress"></span></div>').appendTo('#tasks');
	}

	function startTask()
	{
		$("#tasks .task-block:nth-child("+activeTask+") .task-progress").html('');
		$("#tasks .task-block:nth-child("+activeTask+") .fa-fw").removeClass("fa fa-cog fa-spin").addClass("far fa-check-square");
		$("#tasks .task-block:nth-child("+activeTask+") .fa-fw").height();

		activeTask++;
		$("#tasks .task-block").css('font-weight', 'normal');
		var new_task = $("#tasks .task-block:nth-child("+activeTask+")");
		new_task.css('font-weight', 'bold').find("i").addClass("fa fa-cog fa-spin");
		$("#tasks .task-block:nth-child("+activeTask+") .fa-fw").removeClass("far fa-square").addClass("fa fa-cog fa-spin");
	}

	function updateTask(data)
	{
		$("#tasks .task-block:nth-child("+activeTask+") .task-progress").html(data);
	}

	function complete(msg)
	{
		$("#tasks .task-block:nth-child("+activeTask+") .task-progress").html('');
		$("#tasks .task-block:nth-child("+activeTask+") .fa-fw").removeClass("fa fa-spin").addClass("far fa-check-square");
		$("#tasks .task-block").css('font-weight', 'normal');
		$("#div_task").html(msg);
	}

	$(window).on('load', function()
	{
		hermione();
	});

</script>

<div class="header">
	<div id="div_task"></div>
</div>

<div class="body notify">
	<div id="tasks"></div>
</div>

<?php

Layout::footer();

unset($_SESSION['wizard']);