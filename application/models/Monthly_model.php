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
		$this->db->join('bills_tbl as c','c.id = a.bills_id');
		$this->db->join('resident_tbl as d','d.id = a.resident_id');
		return $this->db->get()->result_array();
	}

	public function load_payment_history($from_date,$to_date)
	{
		$this->db->where('a.payment_datetime >= ',$from_date);
		$this->db->where('a.payment_datetime <= ',$to_date);
		$this->db->select('a.payment_datetime,a.payment_amount as total_amount,
			b.amount,
			c.description,
			d.first_name,d.middle_name,d.last_name');
		$this->db->from('payment_history_tbl as a');
		$this->db->join('payment_details_tbl as b','b.payment_id = a.id');
		$this->db->join('bills_tbl as c','c.id = b.bills_id');
		$this->db->join('resident_tbl as d','d.id = a.resident_id');
		return $this->db->get()->result_array();
	}

	public function looper()
	{
		$array = [];
		for ($i=1; $i <= 12; $i++)
		{ 
			$result = $this->load_sales_per_month($i);
			if($result['total_amount'] == null)
			{
				$array[$i] = 0;
			}
			else
			{
				$array[$i] = $result['total_amount'];
			}

		}
		return $array;
	}

	public function load_sales_per_month($month)
	{	
		$query = $this->db->query('SELECT SUM(detail.amount) as total_amount
			FROM payment_history_tbl as history
			INNER JOIN payment_details_tbl as detail ON detail.payment_id = history.id
			where  YEAR(history.payment_datetime) = '.date("Y").'
			AND MONTH(history.payment_datetime) = '.$month.'
			');

		$result = $query->row_array();
		return $result;
	}

	public function insert_payment_history($data)
	{
		$this->db->insert('payment_history_tbl',$data);
		return $this->db->insert_id();
	}

	public function insert_payment_details($data)
	{
		$result = $this->db->insert_batch('payment_details_tbl',$data);

		if($result > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}