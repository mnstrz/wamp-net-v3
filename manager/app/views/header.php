<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Wamp.NET Manager</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/font-awesome-5.13.0-all.min.css">
	<link rel="stylesheet" href="/css/wamp.net.css?<?= get('version'); ?>">
	<script src="/js/jquery-3.5.1.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/jquery.sortable.min.js"></script>
	<script src="/js/wamp.net.js?<?= md5_file(APP_PATH.'\\public\\js\\wamp.net.js'); ?>"></script>
</head>
<body>
	<!-- Hidden Div (font preloading dramas) -->
	<div style="width:0px; height:0px; overflow: hidden;">
		<i class="fa fa-cog"></i>
		<i class="far fa-check-square"></i>
		<i class="far fa-fw fa-square"></i>
		<span style="font-family: 'Play';">What you looking at?</span>
		<span style="font-family: 'Play'; font-weight: 700;">What you looking at?</span>
	</div>
	<div class="site-wrapper">
		<div class="side">
			<div style="padding: 22px;">
				<img src="/img/logo.png" style="float: left;">
				<div style="margin-right: -2px; margin-bottom: 15px; margin-top: 4px; text-align: right; float: right;">Wamp.NET<br>v<?= get('version'); ?></div>
				<div class="clearfix"></div>
			</div>
			<div id="nav">
				<ul>
					<li><a href="/"><i class="fa fa-fw fa-server"></i>Status</a></li>
					<li><a href="/sites"><i class="fa fa-fw fa-globe"></i>Sites</a></li>
					<li><a href="#" data-toggle="collapse" data-target="#mnu_tools"><i class="fa fa-fw fa-wrench"></i>Tools</a>
						<ul id="mnu_tools" class="collapse">
							<li><a href="/tools/benchmarks"><i class="fa fa-fw fa-chart-bar"></i>Benchmarks</a></li>
							<li><a href="/tools/hosts"><i class="fa fa-fw fa-hashtag"></i>Hosts Editor</a></li>
							<li><a href="/tools/path"><i class="fa fa-fw fa-terminal"></i>System Path</a></li>
							<li><a href="/tools/process"><i class="fa fa-fw fa-microchip"></i>Processes</a></li>
						</ul>
					</li>
					<li><a href="/mail"><i class="fa fa-fw fa-envelope"></i>Mail</a></li>
					<li><a href="/settings"><i class="fa fa-fw fa-cog"></i>Settings</a></li>
					<li><a href="javascript: update_check();"><i class="fa fa-fw fa-sync-alt"></i>Update</a></li>
				</ul>
			</div>
			<script>highliteMenu();</script>
			<div id="footer">
				Copyright &copy; <?= date("Y"); ?> <a href="https://wamp.net/" target="_blank">Wamp.NET</a><br>All rights reserved.
			</div>
		</div>
		<div class="main">

			<?php App\Classes\Notify::display(); ?>