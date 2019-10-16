<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_principal extends CI_Controller {
	
	public function index() {
		$this->load->view('frontend/index');
	}

	public function apps() {
		$this->load->view('frontend/aplications');
	}
}