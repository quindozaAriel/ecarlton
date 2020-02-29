<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly_model extends CI_Model 
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
		$this->db->from('bills_tbl');
		return $this->db->get()->result_array();
	}

	public function read($id)
	{
		$this->db->where('id',$id);
		$this->db->select('*');
		$this->db->from('bills_tbl');
		return $this->db->get()->row_array();
	}

	public function insert($insert_data)
	{
		$this->db->insert('bills_tbl',$insert_data);
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
		$this->db->update('bills_tbl',$update_data);
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
		$this->db->update('bills_tbl',['status' => 'INACTIVE']);
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

	public function load_due_bills()
	{
		$this->db->where('a.status','ACTIVE');
		$this->db->select('a.due_date,
			c.description,c.amount,
			d.first_name,d.middle_name,d.last_name');
		$this->db->from('due_bills_tbl as a');
		$this->db->join('resident_bills_tbl as b','b.id = a.rb_id','left');
		$this->db->join('bills_tbl as c','c.id = b.bill_id','left');
		$this->db->join('resident_tbl as d','d.id = b.resident_id','left');
		return $this->db->get()->result_array();
	}

	public function load_payment_history($from_date,$to_date)
	{
		$this->db->where('a.payment_date >= ',$from_date);
		$this->db->where('a.payment_date <= ',$to_date);
		$this->db->select('a.payment_date,a.amount,
			c.description,
			d.first_name,d.middle_name,d.last_name');
		$this->db->from('payment_history_tbl as a');
		$this->db->join('resident_bills_tbl as b','b.id = a.rb_id','left');
		$this->db->join('bills_tbl as c','c.id = b.bill_id','left');
		$this->db->join('resident_tbl as d','d.id = b.resident_id','left');
		return $this->db->get()->result_array();
	}

}