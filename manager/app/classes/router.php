<?php

namespace App\Classes;

class Router
{
	private $routes = [];

	public function __call($method, $args)
	{
		$this->routes[] = ["method"=>strtoupper($method), "pattern"=>$args[0], "target"=>$args[1] ?? null];
	}

	public function dispatch()
	{
		foreach($this->routes as $route)
		{
			if ((($route['method']=='ANY') || ($_SERVER['REQUEST_METHOD'] == $route['method'])) && preg_match('`^'.$route['pattern'].'$`', parse_url($_SERVER['REQUEST_URI'])['path'], $params))
			{
				if ($route['target'] == null)
				{
				    require APP_PATH.'/app/views'.$route['pattern'].'.php';
				}
				else if($route['target'] instanceof \Closure)
				{
					array_shift($params);
					call_user_func_array($route['target'], $params);
				}
				else
				{
					list($class, $method) = explode('@', $route['target']);
					$class = ($class[0]=='\\') ? "{$class}Controller" : "\\App\\Controllers\\{$class}Controller";
					array_shift($params);
					call_user_func_array([new $class(), $method], $params);
				}
				exit;
			}
		}
		http_response_code(404);
		Notify::error('Your request for <strong>'.$_SERVER['REQUEST_URI'].'</strong> could not be found');
		Response::redirect('/');
	}
}