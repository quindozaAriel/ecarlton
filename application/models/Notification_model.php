<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/manila');
	}

	public function get()
	{
		$this->db->where('date >=',date('Y-m-d'));
		$this->db->select('*');
		$this->db->from('notification_tbl');
		$this->db->order_by('date','DESC');
		return $this->db->get()->result_array();
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

		return ['notifications' => $notifications,'last_notification' => $last_notification['id']];
	}

	public function looper()
	{
		$array = [];
		for ($i=1; $i <= 12; $i++)
		{ 
			$array[$i] = $this->load_notification_per_month($i);	
		}
		return $array;
	}

	public function load_notification_per_month($month)
	{
		$query = $this->db->query('SELECT COUNT(*) AS count
			FROM notification_tbl
			where YEAR(date) = '.date("Y").'
			AND MONTH(date) = '.$month.' 
			');
		$result = $query->row_array();
		return $result;
	}

	public function load_numbers()
	{
		$this->db->select('contact_number');
		$this->db->from('resident_tbl');
		$result = $this->db->get();

		if($result->num_rows() > 0)
		{
			return $result->result_array();
		}
		else
		{
			return FALSE;
		}

	}
}