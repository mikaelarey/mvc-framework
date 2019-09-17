<?php

namespace Application\Controller;

class Home extends \System\Controller {

	public function index() {
		$data['title'] = 'Home Page';
		$this->load->view('home', $data);
	}

	protected function before() {
		return false;
	}

}

?>