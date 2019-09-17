<?php

namespace System;

class Load {

	public function view($file, $data = []) {
		extract($data, EXTR_SKIP);
		$view_file = '../Application/View/' . $file;
		if(is_readable($view_file . '.php')) {
			require $view_file . '.php';
		}
		elseif(is_readable($view_file . '.html')) {
			require $view_file . '.html';
		}
		else {
			echo "$file view not found.";
		}
	}

}

?>