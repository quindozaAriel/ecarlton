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

	public function _mobile_login_verification()
	{
		if(isset($_SESSION['mobile_logged']) && $_SESSION['mobile_logged'] === TRUE)
		{
		}
		else
		{
			redirect(base_url('mobile-login'));
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
		if(isset($_SESSION['mobile_logged']) && $_SESSION['mobile_logged'] === TRUE)
		{
			$this->mobile_home_page();
		}
		else
		{
			$this->load->view('mobile/login');
		}
	}

	public function mobile_home_page()
	{
		$this->_mobile_login_verification();
		$this->load->view('mobile/template',['body' => 'mobile/home/body','css' => 'mobile/home/css','js' => 'mobile/home/js','module' => 'home']);
	}

	public function mobile_bills_page()
	{
		$this->_mobile_login_verification();
		$this->load->view('mobile/template',['body' => 'mobile/bills/body','css' => 'mobile/bills/css','js' => 'mobile/bills/js','module' => 'bills']);
	}

	public function mobile_reservation_page()
	{
		$this->_mobile_login_verification();
		$this->load->view('mobile/template',['body' => 'mobile/reservation/body','css' => 'mobile/reservation/css','js' => 'mobile/reservation/js','module' => 'reservation']);
	}

	public function mobile_notification_page()
	{
		$this->_mobile_login_verification();
		$this->load->view('mobile/template',['body' => 'mobile/notification/body','css' => 'mobile/notification/css','js' => 'mobile/notification/js','module' => 'notification']);
	}

	public function mobile_messages_page()
	{
		$this->_mobile_login_verification();
		$this->load->view('mobile/template',['body' => 'mobile/messages/body','css' => 'mobile/messages/css','js' => 'mobile/messages/js','module' => 'messages']);
	}

	public function mobile_profile_page()
	{
		$this->_mobile_login_verification();
		$this->load->view('mobile/template',['body' => 'mobile/profile/body','css' => 'mobile/profile/css','js' => 'mobile/profile/js','module' => 'profile']);
	}

	public function paymode()
	{
		$this->load->view('paymode/index');
	}

	public function gcash_success()
	{
		$this->load->view('paymode/gcash_success');
	}
}
