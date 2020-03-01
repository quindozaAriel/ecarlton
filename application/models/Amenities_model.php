<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amenities_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}

	public function get()
	{
		$this->db->where('status','ACTIVE');
		$this->db->select('*');
		$this->db->from('amenities_tbl');
		return $this->db->get()->result_array();
	}

	public function read($id)
	{
		$this->db->where('id',$id);
		$this->db->select('*');
		$this->db->from('amenities_tbl');
		return $this->db->get()->row_array();
	}

	public function insert($insert_data)
	{
		$this->db->insert('amenities_tbl',$insert_data);
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

	public function update($id,$update_data)
	{
		$this->db->where('id',$id);
		$this->db->update('amenities_tbl',$update_data);
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

	public function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->update('amenities_tbl',['status' => 'INACTIVE']);
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
}