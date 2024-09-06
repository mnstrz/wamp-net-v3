<?php

namespace App\Classes;

class Layout
{
	public static function header()
	{
		require APP_PATH . '/app/views/header.php';
	}

	public static function footer()
	{
		require APP_PATH . '/app/views/footer.php';
	}

	public static function tabs_begin()
	{
		?>
		<ul class="nav nav-tabs">
		<?php
	}

	public static function tabs_end()
	{
		?>
		</ul>
		<?php
	}

	public static function tab($num, $name, $active=false)
	{
		?>
		<li<?php if ($active) echo ' class="active"'; ?>><a data-toggle="tab" href="#tab_<?= $num; ?>"><?= $name; ?></a></li>
		<?php
	}

	public static function tab_panes_begin()
	{
		?>
		<div class="tab-content">
		<?php
	}

	public static function tab_panes_end()
	{
		?>
		</div>
		<?php
	}

	public static function tab_pane_begin($num, $active=false)
	{
		?>
			<div id="tab_<?= $num; ?>" class="tab-pane fade <?php if ($active) echo ' in active'; ?>">
		<?php
	}

	public static function tab_pane_end()
	{
		?>
		</div>
		<?php
	}

	public static function checkbox($name, $text, $checked)
	{
		?>
		<div class="checkbox checkbox-primary">
			<input name="chk_<?= $name; ?>" id="chk_<?= $name; ?>" type="checkbox" <?= ($checked) ? ' checked' : ''; ?>>
			<label for="chk_<?= $name; ?>"><?= $text; ?></label>
		</div>
		<?php
	}
}