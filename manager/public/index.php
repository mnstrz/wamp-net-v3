<?php

###         ###  ###############  ###############  ###############
###         ###  ###############  ###############  ###############
###         ###  ###         ###  ###   ###   ###  ###         ###
###   ###   ###  ###         ###  ###   ###   ###  ###         ###
###   ###   ###  ###############  ###   ###   ###  ###############
###   ###   ###  ###############  ###         ###  ###############
###############  ###         ###  ###         ###  ###
###############  ###         ###  ###         ###  ###        .NET

define('N',	"\n");
define('T', "\t");
define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', dirname(__DIR__));
define('WAMP_PATH', realpath(APP_PATH.'\\..\\'));
define('TMP_PATH', WAMP_PATH.'\\tmp');
define('BIN_PATH', WAMP_PATH.'\\bin');
define('DATA_PATH', WAMP_PATH.'\\data');
define('SITE_PATH', WAMP_PATH.'\\sites');
define('TOOLS_PATH', WAMP_PATH.'\\manager\\bin\\tools');
define('DOWNLOAD_PATH', APP_PATH.'\\download');

###############################################################################
#                                                                             #
#  Error Logging                                                              #
#                                                                             #
###############################################################################

ini_set('error_log', WAMP_PATH."\\Wamp.NET.log");
ini_set('log_errors', 'on');

###############################################################################
#                                                                             #
#  Debugging                                                                  #
#                                                                             #
###############################################################################

$ini = parse_ini_file(WAMP_PATH."\\Wamp.NET.ini");

define('DEBUG', ((bool)$ini['debug'] ?? false));

function debug($data)
{
	if (DEBUG)
		error_log(is_scalar($data) ? $data : json_encode($data));
}

###############################################################################
#                                                                             #
#  Quick access to sqlite database conf table                                 #
#                                                                             #
###############################################################################

function get($name)
{
	return \App\Classes\Database::scalar('SELECT value FROM conf
											WHERE name=?', $name);
}

function set($name, $value)
{
	\App\Classes\Database::execute('UPDATE conf SET value=?
										WHERE name=?', $value, $name);
}

###############################################################################
#                                                                             #
#  Get it?                                                                    #
#                                                                             #
###############################################################################

function slash($saul, $hudson='/')
{
	return str_replace(['\\', '/'], [$hudson, $hudson], $saul);
}

function dotty($dorothy)
{
	return str_replace('.', '', $dorothy);
}

###############################################################################
#                                                                             #
#  Autoloading                                                                #
#                                                                             #
###############################################################################

spl_autoload_register(function($class)
{
	include APP_PATH.'\\'.$class.'.php';
});

###############################################################################
#                                                                             #
#  Cache                                                                      #
#                                                                             #
###############################################################################

if (!App\Classes\Cache::init())
	return false;

###############################################################################
#                                                                             #
#  Entry to app                                                               #
#                                                                             #
###############################################################################

session_start();

$router = new \App\Classes\Router();

$router->get ('/', 'Instance@index');

$router->get ('/sites',             'Site@index');
$router->get ('/site/add',          'Site@showAdd');
$router->post('/site/add',          'Site@doAdd');
$router->get ('/site/(\d+)/browse', 'Site@browse');
$router->get ('/site/(\d+)/edit',   'Site@showEdit');
$router->post('/site/(\d+)/edit',   'Site@doEdit');
$router->get ('/site/(\d+)/delete', 'Site@delete');
$router->get ('/site/(\d+)/code',   'Site@code');

$router->get ('/packages',              'Package@index');
$router->get ('/package/(\d+)/add',     'Package@add');
$router->post('/package/(\d+)/add',     'Package@verify');
$router->get ('/package/(\d+)/install', 'Package@install');

$router->get ('/dev',         'Dev@index');
$router->post('/dev/upload',  'Dev@upload');
$router->post('/dev/version', 'Dev@version');
$router->post('/dev/toggle',  'Dev@toggle');

$router->get ('/update/check',  'Update@check');
$router->get ('/update/update', 'Update@update');
$router->get ('/update/sync', 	'Update@sync');

$router->get ('/instance/(\d+)/browse',      'Instance@browse');
$router->get ('/instance/(\d+)/fopen/(\w+)', 'Instance@fopen');
$router->post('/instance/(\d+)/rename',      'Instance@rename');
$router->get ('/instance/(\d+)/(\w+)',       'Instance@control');

$router->get ('/tools/path',                    'Tools\Path@index');
$router->post('/tools/path',                    'Tools\Path@update');
$router->get ('/tools/process',                 'Tools\Process@index');
$router->get ('/tools/process/(\d+)',           'Tools\Process@kill');
$router->get ('/tools/hosts',                   'Tools\Host@index');
$router->post('/tools/hosts',                   'Tools\Host@update');
$router->get ('/tools/benchmarks',              'Tools\Benchmark@index');
$router->post('/tools/benchmarks',              'Tools\Benchmark@create');
$router->get ('/tools/benchmarks/(\d+)',        'Tools\Benchmark@report');
$router->get ('/tools/benchmarks/(\d+)/delete', 'Tools\Benchmark@delete');
$router->get ('/tools/benchmarks/clear',        'Tools\Benchmark@clear');
$router->get ('/tools/fb',                      'Tools\Folder@index');

$router->get ('/wizard');

$router->get ('/settings', 'Settings@index');
$router->post('/settings', 'Settings@save');

$router->get ('/mail',             'Mail@index');
$router->get ('/mail/delete/(.+)', 'Mail@delete');
$router->get ('/mail/open/(.+)',   'Mail@open');
$router->get ('/mail/empty',       'Mail@empty');
$router->get ('/mail/browse',      'Mail@browse');

###############################################################################
#                                                                             #
#  Let's Go!                                                                  #
#                                                                             #
###############################################################################

$router->dispatch();