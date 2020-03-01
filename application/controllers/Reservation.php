<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reservation_model','reservation');
		date_default_timezone_set('Asia/manila');
	}

	public function load_reservation_history()
	{
		$result = $this->reservation->load_reservation_history();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

}