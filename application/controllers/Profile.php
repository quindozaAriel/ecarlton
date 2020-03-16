<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Profile_model','profile');
		date_default_timezone_set('Asia/manila');
	}

	public function update_password($id)
	{
		$post_data = $this->input->post();
		$post_data['data']['new_password'] = password_hash($post_data['data']['new_password'],PASSWORD_BCRYPT);

		$result = $this->profile->update_password($id,$post_data['data']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update_image()
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

				$result = $this->profile->update_image($post_data['id'],$post_data['image']);
				
				$this->output->set_content_type('application/json')->set_output(json_encode($result));
			}  
		} 
	}
}
