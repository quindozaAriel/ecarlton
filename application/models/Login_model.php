<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function verify_client_account($post_data)
	{
		if(empty($post_data['username']) || empty($post_data['password']))
		{
			return FALSE;
		}
		else
		{
			$this->db->where('username',$post_data['username']);
			$this->db->select('*');
			$this->db->from('admin_tbl');
			$query_result = $this->db->get()->row_array();
			if($query_result != '' || $query_result != null || $query_result != FALSE)
			{
				if(count($query_result) > 0)
				{
					if(password_verify($post_data['password'],$query_result['password']) === TRUE)
					{
						return $query_result;
					} 
					else
					{
						return FALSE;
					}
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
		}
	} 

	public function verify_mobile_login($post_data)
	{
		if(empty($post_data['username']) || empty($post_data['password']))
		{
			return FALSE;
		}
		else
		{
			$this->db->where('username',$post_data['username']);
			$this->db->select('*');
			$this->db->from('resident_tbl');
			$query_result = $this->db->get()->row_array();
			if($query_result != '' || $query_result != null || $query_result != FALSE)
			{
				if(count($query_result) > 0)
				{
					if(password_verify($post_data['password'],$query_result['password']) === TRUE)
					{
						return $query_result;
					} 
					else
					{
						return FALSE;
					}
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
		}
	}
}