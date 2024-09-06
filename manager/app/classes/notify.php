<?php

namespace App\Classes;

class Notify
{
	public static function success($text)
	{
		static::_notify('success', $text);
	}

	public static function info($text)
	{
		static::_notify('info', $text);
	}

	public static function warn($text)
	{
		static::_notify('warning', $text);
	}

	public static function error($text)
	{
		static::_notify('error', $text);
	}

	private static function _notify($type, $text)
	{
		$_SESSION["notify_type"] = $type;
		$_SESSION["notify_text"] = $text;
	}

	public static function display()
	{
		if (isset($_SESSION["notify_type"]))
		{
			$type = $_SESSION["notify_type"];
			$text = $_SESSION["notify_text"];

			?>
				<div class="alert alert-<?= strtolower(($type == 'error') ? 'danger' : $type); ?> alert-dismissable">
  					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  					<strong><?= ucfirst($_SESSION["notify_type"]); ?></strong> <?= $text; ?>
				</div>
			<?php

			unset($_SESSION["notify_type"]);
			unset($_SESSION["notify_text"]);
		}
	}
}