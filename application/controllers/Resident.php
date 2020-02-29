<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resident extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Resident_model','resident');
		date_default_timezone_set('Asia/manila');
	}

	public function index()
	{

	}

	public function get()
	{
		$result = $this->resident->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function read($id)
	{
		$result = $this->resident->read($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$post_data = $this->input->post();
		if(isset($_FILES["image"]["name"]))  
		{  
			$config['upload_path'] = './uploads/resident/';  
			$config['allowed_types'] = 'jpg|jpeg|png|gif';  
			$this->load->library('upload', $config);  
			if(!$this->upload->do_upload("image"))  
			{  
				$this->output->set_content_type('application/json')->set_output(json_encode(FALSE));
			}  
			else 
			{  
				$data = $this->upload->data();

				$post_data['image'] = $data['file_name'];
				$post_data['timestamp'] = date('Y-m-d H:i:s');
				$post_data['password'] = password_hash($post_data['username'],PASSWORD_BCRYPT);
				$post_data['status'] = 'INACTIVE';

				$result = $this->resident->insert($post_data);
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}  
		} 
	}

	public function update($id)
	{
		$post_data = $this->input->post();

		$result = $this->resident->update($id,$post_data['data']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete($id)
	{
		$result = $this->resident->delete($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_phase()
	{
		$result = $this->resident->load_phase();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_lot($phase_id)
	{
		$result = $this->resident->load_lot($phase_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_block($lot_id)
	{
		$result = $this->resident->load_block($lot_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}
