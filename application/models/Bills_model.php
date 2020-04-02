<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bills_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/manila');
	}

	public function get()
	{
		$this->db->where('MONTH(b.timestamp) !=',date('m'));
		$this->db->where('a.due_date >=',date('d'));	
		$this->db->where('a.status','ACTIVE');
		$this->db->where('a.bill_type','MONTHLY');
		$this->db->select('a.*,c.payment_amount,b.timestamp');
		$this->db->from('bills_tbl a');
		$this->db->join('payment_details_tbl b','b.bills_id = a.id','LEFT');
		$this->db->join('payment_history_tbl c','c.id = b.payment_id','LEFT');
		$monthly_bills =  $this->db->get()->result_array();

		$this->db->where('b.bills_id IS NULL');
		$this->db->where('MONTH(a.due_date)',date('m'));
		$this->db->where('a.due_date >=',date('Y-m-d'));
		$this->db->where('a.status','ACTIVE');
		$this->db->where('a.bill_type','OCCASIONAL');
		$this->db->select('a.*');
		$this->db->from('bills_tbl a');
		$this->db->join('payment_details_tbl b','b.bills_id = a.id','LEFT');
		$occasional_bills =  $this->db->get()->result_array();

		$final_result = array_merge($monthly_bills,$occasional_bills);

		return $final_result;
	}

	public function read($id)
	{
		$this->db->where('id',$id);
		$this->db->select('*');
		$this->db->from('notification_tbl');
		return $this->db->get()->row_array();
	}

	public function insert($insert_data)
	{
		$this->db->insert('notification_tbl',$insert_data);
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
		$this->db->update('notification_tbl',$update_data);
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
		$this->db->delete('notification_tbl');
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

	public function load_all_notification()
	{
		$this->db->where('date <=',date('Y-m-d'));
		$this->db->select('*');
		$this->db->from('notification_tbl');
		return $this->db->get()->result_array();
	}

	public function realtime_retrieving()
	{
		$this->db->select('*');
		$this->db->from('notification_tbl');
		$this->db->order_by('date','DESC');
		$notifications = $this->db->get()->result_array();

		$this->db->select('MAX(id) as id');
		$this->db->from('notification_tbl');
		$last_notification =  $this->db->get()->row_array();

		return ['notifications' => $notifications,
		'last_notification' => $last_notification['id']
	];
}
}