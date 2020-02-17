<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function index()
	{
		$this->load->view('main/login');
	}

	public function home()
	{
		$this->load->view('main/home');
	}

	public function mobile_login_page()
	{
		$this->load->view('mobile/login');
	}
}
