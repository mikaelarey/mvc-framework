<?php

namespace System;

class Router {

	private $routes = [];

	private $params = [];

	public function add($route, $params = []) {
		$route = preg_replace('/\//', '\\/', $route);
		$route = preg_replace('/\{([a-z-]+)\}/', '(?P<\1>[a-z-]+)', $route);
		$route = '/^' . $route . '$/i';
		$this->routes[$route] = $params;
	}

	private function match($uri) {
		$uri = $this->remove_query_string($uri);
		foreach($this->routes as $route => $params) {
			if(preg_match($route, $uri, $matches)) {
				foreach($matches as $key => $value) {
					if(is_string($key)) {
						$params[$key] = $value;
					}
				}
				$this->params = $params;
				return true;
			}
		}
		return false;
	}

	public function dispatch($uri) {
		if($this->match($uri)){
			$controller = $this->params['controller'];
			$controller = $this->studly_caps($controller);
			$controller = $this->get_namespace() . $controller;
			if(class_exists($controller)) {
				$controller_obj = new $controller();
				$action = $this->params['action'];
				$action = $this->camel_case($action);
				if(method_exists($controller_obj, $action)){
					$controller_obj->$action();
				}
				else {
					echo "$action action not exists.";
				}
			}
			else {
				echo "$controller controller not exists.";
			}
		}
		else {
			echo 'Page not found.';
		}
	}

	protected function remove_query_string($uri) {
		if(!empty($uri)) {
			$parts = explode('&', $uri, 2);
			if(strpos($parts[0], '=') === false) {
				$uri = $parts[0];
			}
			else {
				$uri = '';
			}
		}
		return $uri;
	}

	protected function camel_case($action) {
		return lcfirst($this->studly_caps($action));
	}

	protected function studly_caps($controller) {
		return str_replace(' ', '', ucwords(str_replace('-', '', strtolower($controller))));
	}

	protected function get_namespace() {
		$namespace = 'Application\Controller\\';
		if(array_key_exists('namespace', $this->params)) {
			$namespace .= $this->params['namespace'] . '\\';
		}
		return $namespace;
	}

}

?>