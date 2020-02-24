<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model','admin');
		date_default_timezone_set('Asia/manila');
	}

	public function index()
	{

	}

	public function get()
	{
		$result = $this->admin->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function read($id)
	{
		$result = $this->admin->read($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$post_data = $this->input->post();
		if(isset($_FILES["image"]["name"]))  
		{  
			$config['upload_path'] = './uploads/admin/';  
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
				$post_data['timestamp'] = date('Y/m/d H:i:s');
				$post_data['password'] = password_hash($post_data['password'],PASSWORD_BCRYPT);
				unset($post_data['confirm_password']);

				$result = $this->admin->insert($post_data);
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}  
		} 
	}

	public function update($id)
	{
		$post_data = $this->input->post();

		if(empty($post_data['data']['password']))
		{
			unset($post_data['data']['password']);
		}
		else
		{
			$post_data['data']['password'] = password_hash($post_data['data']['password'],PASSWORD_BCRYPT);
		}

		$result = $this->admin->update($id,$post_data['data']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete($id)
	{
		$result = $this->admin->delete($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}
}
