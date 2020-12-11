<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Standby_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function check_occasional_due_bill()
	{
		$this->db->where('bill.due_date <',date('Y-m-d'));
		$this->db->where('bill.bill_type','OCCASIONAL');
		$this->db->where('bill.status','ACTIVE');
		$this->db->select('bill.id as bill_id,bill.description,bill.due_date,bill.amount');
		$this->db->from('bills_tbl as bill');
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function get_all_active_resident()
	{
		$this->db->where('status','ACTIVE');
		$this->db->select('id as resident_id');
		$this->db->from('resident_tbl');
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function check_payment_details_occasional($bills_id,$resident_id)
	{
		$this->db->where('detail.bills_id',$bills_id);
		$this->db->where('history.resident_id',$resident_id);
		$this->db->select('history.id as history_id');
		$this->db->from('payment_details_tbl as detail');
		$this->db->join('payment_history_tbl as history','history.id = detail.payment_id');
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function check_if_exist($bills_id,$resident_id)
	{
		$this->db->where('bills_id',$bills_id);
		$this->db->where('resident_id',$resident_id);
		$this->db->select('*');
		$this->db->from('due_bills_tbl');
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function insert_due_bills($data)
	{
		$this->db->insert_batch('due_bills_tbl',$data);
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

	public function check_monthly_due_bill()
	{
		$this->db->where('bill.due_date <',date('d'));
		$this->db->where('bill.bill_type','MONTHLY');
		$this->db->where('bill.status','ACTIVE');
		$this->db->select('bill.id as bill_id,bill.description,bill.due_date,bill.amount');
		$this->db->from('bills_tbl as bill');
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function check_if_exist_monthly($bills_id,$resident_id)
	{
		$this->db->where('MONTH(due_date)',date('n'));
		$this->db->where('YEAR(due_date)',date('Y'));
		$this->db->where('bills_id',$bills_id);
		$this->db->where('resident_id',$resident_id);
		$this->db->select('*');
		$this->db->from('due_bills_tbl');
		$result = $this->db->get()->row_array();

		return $result;
	}


	public function check_payment_details_monthly($bills_id,$resident_id)
	{
		$this->db->where('MONTH(history.payment_datetime)',date('n'));
		$this->db->where('YEAR(history.payment_datetime)',date('Y'));
		$this->db->where('detail.bills_id',$bills_id);
		$this->db->where('history.resident_id',$resident_id);
		$this->db->select('history.id as history_id');
		$this->db->from('payment_details_tbl as detail');
		$this->db->join('payment_history_tbl as history','history.id = detail.payment_id');
		$result = $this->db->get()->row_array();

		return $result;
	}

	/*SPECIFIC BILLS*/

	public function check_spec_occasional_due_bill()
	{
		$this->db->where('bill.resident_id',$_SESSION['id']);
		$this->db->where('bill.due_date <',date('Y-m-d'));
		$this->db->where('bill.type','OCCASIONAL');
		$this->db->where('bill.status','ACTIVE');
		$this->db->select('bill.id as bill_id,bill.description,bill.due_date,bill.amount');
		$this->db->from('resident_bills_tbl as bill');
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function check_spec_monthly_due_bill()
	{
		$this->db->where('bill.resident_id',$_SESSION['id']);
		$this->db->where('bill.due_date <',date('d'));
		$this->db->where('bill.type','MONTHLY');
		$this->db->where('bill.status','ACTIVE');
		$this->db->select('bill.id as bill_id,bill.description,bill.due_date,bill.amount');
		$this->db->from('resident_bills_tbl as bill');
		$result = $this->db->get()->result_array();

		return $result;
	}

	public function check_if_exist_spec_occasional($bills_id,$resident_id)
	{
		$this->db->where('resident_bills_id',$bills_id);
		$this->db->where('resident_id',$resident_id);
		$this->db->select('*');
		$this->db->from('due_bills_tbl');
		$result = $this->db->get()->row_array();

		return $result;
	}
	public function check_if_exist_spec_monthly($bills_id,$resident_id)
	{
		$this->db->where('MONTH(due_date)',date('n'));
		$this->db->where('YEAR(due_date)',date('Y'));
		$this->db->where('resident_bills_id',$bills_id);
		$this->db->where('resident_id',$resident_id);
		$this->db->select('*');
		$this->db->from('due_bills_tbl');
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function check_payment_spec_occasional($bills_id,$resident_id)
	{
		$this->db->where('detail.resident_bills_id',$bills_id);
		$this->db->where('history.resident_id',$resident_id);
		$this->db->select('history.id as history_id');
		$this->db->from('payment_details_tbl as detail');
		$this->db->join('payment_history_tbl as history','history.id = detail.payment_id');
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function check_payment_spec_monthly($bills_id,$resident_id)
	{
		$this->db->where('MONTH(history.payment_datetime)',date('n'));
		$this->db->where('YEAR(history.payment_datetime)',date('Y'));
		$this->db->where('detail.resident_bills_id',$bills_id);
		$this->db->where('history.resident_id',$resident_id);
		$this->db->select('history.id as history_id');
		$this->db->from('payment_details_tbl as detail');
		$this->db->join('payment_history_tbl as history','history.id = detail.payment_id');
		$result = $this->db->get()->row_array();

		return $result;
	}

}