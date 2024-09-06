<?php

$stdin = fopen('php://stdin', 'r');

$output = '';

while(!feof($stdin))
	$output .= trim(fgets($stdin))."\n";

file_put_contents(realpath(__DIR__.'\\..\\..\\mail')."\\".round(microtime(true)*1000).".eml", $output);