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

	public function get()
	{
		$result = $this->reservation->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function read($id)
	{
		$result = $this->reservation->read($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$post_data = $this->input->post();

		$post_data['timestamp'] = date('Y-m-d H:i:s');
		$result = $this->reservation->insert($post_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update($id)
	{
		$post_data = $this->input->post();

		$result = $this->reservation->update($id,$post_data['data']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete($id)
	{
		$result = $this->reservation->delete($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_reservation_history()
	{
		$result = $this->reservation->load_reservation_history();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

}