<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notification_model','notification');
		date_default_timezone_set('Asia/manila');
	}

	public function get()
	{
		$result = $this->notification->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function read($id)
	{
		$result = $this->notification->read($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$post_data = $this->input->post();

		$post_data['timestamp'] = date('Y-m-d H:i:s');
		$result = $this->notification->insert($post_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update($id)
	{
		$post_data = $this->input->post();

		$result = $this->notification->update($id,$post_data['data']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete($id)
	{
		$result = $this->notification->delete($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_all_notification()
	{
		$result = $this->notification->load_all_notification();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

}