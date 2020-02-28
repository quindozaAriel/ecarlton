<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Monthly_model','monthly');
		date_default_timezone_set('Asia/manila');
	}

	public function index()
	{

	}

	public function get()
	{
		$result = $this->monthly->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function read($id)
	{
		$result = $this->monthly->read($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$post_data = $this->input->post();


		$post_data['status'] = 'ACTIVE';
		$post_data['timestamp'] = date('Y/m/d H:i:s');

		$result = $this->monthly->insert($post_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update($id)
	{
		$post_data = $this->input->post();

		$result = $this->monthly->update($id,$post_data['data']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete($id)
	{
		$result = $this->monthly->delete($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}
