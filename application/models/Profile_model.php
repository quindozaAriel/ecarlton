<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/manila');
	}

	public function update_password($id,$update_data)
	{
		$this->db->where('id',$id);
		$this->db->select('*');
		$this->db->from('resident_tbl');
		$resident_data = $this->db->get()->row_array();

		if($resident_data != '' || $resident_data != null || $resident_data != FALSE)
		{
			if(password_verify($update_data['current_password'],$resident_data['password']) === TRUE)
			{
				$this->db->where('id',$id);
				$this->db->update('resident_tbl',['password' => $update_data['new_password']]);
				$affected_row = $this->db->affected_rows();

				if($affected_row == 0)
				{
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			} 
			else
			{
				return FALSE;
			}
		}
	}

	public function update_image($id,$image)
	{
		$this->db->where('id',$id);
		$this->db->update('resident_tbl',['image' => $image]);
		$affected_row = $this->db->affected_rows();

		if($affected_row == 0)
		{
			return FALSE;
		}
		else
		{
			$this->session->set_userdata('image', $image);
			return TRUE;
		}

	}
}