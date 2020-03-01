<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amenities extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Amenities_model','amenity');
		date_default_timezone_set('Asia/manila');
	}

	public function get()
	{
		$result = $this->amenity->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function read($id)
	{
		$result = $this->amenity->read($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$post_data = $this->input->post();

		$post_data['timestamp'] = date('Y-m-d H:i:s');
		$post_data['status'] = 'ACTIVE';
		$post_data['available_qty'] = $post_data['quantity'];
		$result = $this->amenity->insert($post_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update($id)
	{
		$post_data = $this->input->post();

		$result = $this->amenity->update($id,$post_data['data']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete($id)
	{
		$result = $this->amenity->delete($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}