<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resident_model extends CI_Model 
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
		// $this->db->where('status','ACTIVE');
		$this->db->select('*');
		$this->db->from('resident_tbl');
		return $this->db->get()->result_array();
	}

	public function read($id)
	{
		$this->db->where('id',$id);
		$this->db->select('*');
		$this->db->from('resident_tbl');
		return $this->db->get()->row_array();
	}

	public function insert($insert_data)
	{
		$this->db->where('email',$insert_data['email']);
		$this->db->where('username',$insert_data['username']);
		$this->db->select('*');
		$this->db->from('resident_tbl');
		$select = $this->db->get();

		if($select->num_rows() == 0)
		{
			$this->db->insert('resident_tbl',$insert_data);
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

	public function update($id,$update_data)
	{
		$this->db->where('id',$id);
		$this->db->update('resident_tbl',$update_data);
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
		$this->db->update('resident_tbl',['status' => 'INACTIVE']);
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

	public function load_phase()
	{
		$this->db->select('*');
		$this->db->from('phase_tbl');
		$this->db->order_by('phase');
		return $this->db->get()->result_array();
	}

	public function load_lot($phase_id)
	{
		$this->db->where('phase_id',$phase_id);
		$this->db->select('*');
		$this->db->from('lot_tbl');
		$this->db->order_by('lot');
		return $this->db->get()->result_array();
	}

	public function load_block($lot_id)
	{
		$this->db->where('id',$lot_id);
		$this->db->select('block_count');
		$this->db->from('lot_tbl');
		return $this->db->get()->row_array();
	}
}