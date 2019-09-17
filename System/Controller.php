<?php

namespace System;

use \System\Load;

abstract class Controller {

	public function __construct() {
		$this->load = new Load();
	}

	public function __call($method, $args){
		if($this->before() !== false) {
			call_user_func_array([$this, $method], $args);
		}
		else {
			echo 'Access Denied.';
		}
	}

	protected function before() {

	}

}

?>