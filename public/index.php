<?php

spl_autoload_register(function($class) {
	$root = dirname(__DIR__);
	$file = $root . '/' . str_replace('\\', '/', $class) . '.php';
	if(is_readable($file)) {
		require $file;
	}
});

$router = new System\Router();

$router->add('', ['controller' => 'home', 'action' => 'index']);
$router->add('{controller}/', ['action' => 'index']);
$router->add('{controller}', ['action' => 'index']);
$router->add('{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);

?>