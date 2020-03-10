<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function index()
	{
		if(isset($_SESSION['client_logged_in']) && $_SESSION['client_logged_in'] === TRUE)
		{	
			$this->dashboard();
		}
		else
		{
			redirect(base_url('login'));
			die();
		}
	}

	public function _admin_login_verification()
	{
		if(isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === TRUE)
		{
		}
		else
		{
			redirect(base_url('login'));
			die();
		}
	}
	
	public function login()
	{
		if(isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === TRUE)
		{
			$this->dashboard();
		}
		else
		{
			$this->load->view('main/login');
		}
	}

	public function dashboard()
	{
		$this->_admin_login_verification();
		$this->load->view('main/template',['body' => 'main/dashboard/body','css' => 'main/dashboard/css','js' => 'main/dashboard/js','module' => 'dashboard']);
	}

	public function resident()
	{
		$this->_admin_login_verification();
		$this->load->view('main/template',['body' => 'main/resident/body','css' => 'main/resident/css','js' => 'main/resident/js','module' => 'resident']);
	}

	public function reservation()
	{
		$this->_admin_login_verification();
		$this->load->view('main/template',['body' => 'main/reservation/body','css' => 'main/reservation/css','js' => 'main/reservation/js','module' => 'reservation']);
	}

	public function monthly_due()
	{
		$this->_admin_login_verification();
		$this->load->view('main/template',['body' => 'main/monthly_due/body','css' => 'main/monthly_due/css','js' => 'main/monthly_due/js','module' => 'monthly_due']);
	}

	public function notification()
	{
		$this->_admin_login_verification();
		$this->load->view('main/template',['body' => 'main/notification/body','css' => 'main/notification/css','js' => 'main/notification/js','module' => 'notification']);
	}

	public function masterlist()
	{
		$this->_admin_login_verification();
		$this->load->view('main/template',['body' => 'main/masterlist/body','css' => 'main/masterlist/css','js' => 'main/masterlist/js','module' => 'masterlist']);
	}

	public function admin()
	{
		$this->_admin_login_verification();
		$this->load->view('main/template',['body' => 'main/admin/body','css' => 'main/admin/css','js' => 'main/admin/js','module' => 'admin']);
	}

	public function mobile_login_page()
	{
		$this->load->view('mobile/login');
	}

	public function mobile_home_page()
	{
		$this->load->view('mobile/template',['body' => 'mobile/home/body','css' => 'mobile/home/css','js' => 'mobile/home/js','module' => 'home']);
	}
}
