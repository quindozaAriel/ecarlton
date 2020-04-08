<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Home_model','home');
		date_default_timezone_set('Asia/manila');
	}

	public function check_notification()
	{
		$result = $this->home->check_notification();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function check_bills()
	{
		$result = $this->home->check_bills();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

}
