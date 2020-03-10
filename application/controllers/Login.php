<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Login_model','login');
		date_default_timezone_set('Asia/manila');
	}

	public function verify()
	{
		$result = $this->login->verify_client_account($this->input->post());

		if($result !== FALSE)
		{
			$session_data = array(
				'id'             => $result['id'],
				'first_name'     => $result['first_name'],
				'middle_name'    => $result['middle_name'],
				'last_name'      => $result['last_name'],
				'email'          => $result['email'],
				'contact_number' => $result['contact_number'],
				'username'       => $result['username'],
				'admin_logged'   => TRUE
			);

			$this->session->set_userdata($session_data);

			$this->output->set_content_type('application/json')->set_output(json_encode(TRUE));
		}
		else
		{
			$this->output->set_content_type('application/json')->set_output(json_encode(FALSE));
		}
		
	}

	public function logout()
	{
		if(isset($_SESSION['admin_logged']))
		{
			session_destroy();
			redirect(base_url());
		}
		else if(isset($_SESSION['mobile_logged']))
		{
			session_destroy();
			redirect(base_url('mobile-login'));
		}
	}

	public function verify_mobile_login()
	{
		$result = $this->login->verify_mobile_login($this->input->post());

		if($result !== FALSE)
		{
			$session_data = array(
				'id'             => $result['id'],
				'first_name'     => $result['first_name'],
				'middle_name'    => $result['middle_name'],
				'last_name'      => $result['last_name'],
				'email'          => $result['email'],
				'contact_number' => $result['contact_number'],
				'username'       => $result['username'],
				'phase_no'       => $result['phase_no'],
				'lot_no'         => $result['lot_no'],
				'block_no'       => $result['block_no'],
				'mobile_logged'   => TRUE
			);

			$this->session->set_userdata($session_data);

			$this->output->set_content_type('application/json')->set_output(json_encode(TRUE));
		}
		else
		{
			$this->output->set_content_type('application/json')->set_output(json_encode(FALSE));
		}
		
	}
}