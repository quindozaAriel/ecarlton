<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function index()
	{
		$this->load->view('main/login');
	}
	
	public function dashboard()
	{
		$this->load->view('main/template',['body' => 'main/dashboard/body','css' => 'main/dashboard/css','js' => 'main/dashboard/js','module' => 'dashboard']);
	}

	public function resident()
	{
		$this->load->view('main/template',['body' => 'main/resident/body','css' => 'main/resident/css','js' => 'main/resident/js','module' => 'resident']);
	}

	public function reservation()
	{
		$this->load->view('main/template',['body' => 'main/reservation/body','css' => 'main/reservation/css','js' => 'main/reservation/js','module' => 'reservation']);
	}

	public function monthly_due()
	{
		$this->load->view('main/template',['body' => 'main/monthly_due/body','css' => 'main/monthly_due/css','js' => 'main/monthly_due/js','module' => 'monthly_due']);
	}

	public function notification()
	{
		$this->load->view('main/template',['body' => 'main/notification/body','css' => 'main/notification/css','js' => 'main/notification/js','module' => 'notification']);
	}

	public function masterlist()
	{
		$this->load->view('main/template',['body' => 'main/masterlist/body','css' => 'main/masterlist/css','js' => 'main/masterlist/js','module' => 'masterlist']);
	}

	public function admin()
	{
		$this->load->view('main/template',['body' => 'main/admin/body','css' => 'main/admin/css','js' => 'main/admin/js','module' => 'admin']);
	}

	public function mobile_login_page()
	{
		$this->load->view('mobile/login');
	}
}
