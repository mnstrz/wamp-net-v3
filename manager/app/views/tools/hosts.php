<?php

use App\Classes\Database;
use App\Classes\Layout;

Layout::header();

?>
	<div class="header">
		<div>Hosts Editor</div>
	</div>

	<div class="body-static">
		<div class="body-static-top notify"></div>
		<div class="body-static-content">
			<form id="frmHostsEditor" spellcheck="false" class="validate" method="POST" style="display: grid; height: 100%">
				<textarea class="body-static-editor" name="data"><?= file_get_contents(trim(shell_exec('echo %systemroot%\system32')).'\\drivers\\etc\\hosts'); ?></textarea>
			</form>
		</div>
		<div class="body-static-bottom">
			<button type="submit" class="btn btn-sm btn-success" onclick="$('#frmHostsEditor').submit();">Save Changes</button>
		</div>
	</div>
<?php

Layout::footer();