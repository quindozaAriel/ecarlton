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
		$user_id = $_SESSION['id'];

		$monthly_bills_query  = $this->db->query('SELECT bills.id as bills_id,bills.description,bills.amount,bills.due_date,bills.bill_type
			FROM bills_tbl as bills
			WHERE bills.status = "ACTIVE"
			AND bills.bill_type = "MONTHLY"
			AND bills.due_date >= '.date('d').'
			ORDER BY bills.id
			');

		$monthly_bills  = $monthly_bills_query->result_array();

		$resident_bills_query = $this->db->query('SELECT bills.id as bills_id,bills.description,bills.amount,bills.due_date,bills.bill_type
			FROM payment_history_tbl as history
			INNER JOIN payment_details_tbl as details ON details.payment_id = history.id
			INNER JOIN bills_tbl as bills ON bills.id = details.bills_id
			WHERE history.resident_id = '.$user_id.'
			AND MONTH(history.payment_datetime) = '.date('n').'
			AND bills.bill_type = "MONTHLY"
			AND details.bill_type = "NORMAL"
			');

		$resident_bills = $resident_bills_query->result_array();


		foreach($monthly_bills as $monthly_key => $monthly_val)
		{
			foreach($resident_bills as $resident_key => $resident_val)
			{
				if($monthly_val['bills_id'] == $resident_val['bills_id'])
				{
					unset($monthly_bills[$monthly_key]);
				}
			}
		}

		$this->db->where('a.due_date >=',date('Y-m-d'));
		$this->db->where('MONTH(a.due_date)',date('n'));
		$this->db->where('a.status','ACTIVE');
		$this->db->where('a.bill_type','OCCASIONAL');
		$this->db->select('a.id as bills_id,a.description,a.amount,a.due_date,a.bill_type');
		$this->db->from('bills_tbl a');
		$occasional_bills_result = $this->db->get()->result_array();

		$resident_bills_occasional = $this->db->query('SELECT bills.id as bills_id,bills.description,bills.amount,bills.due_date,bills.bill_type
			FROM payment_history_tbl as history
			INNER JOIN payment_details_tbl as details ON details.payment_id = history.id
			INNER JOIN bills_tbl as bills ON bills.id = details.bills_id
			WHERE history.resident_id = '.$user_id.'
			AND bills.bill_type = "OCCASIONAL"
			AND details.bill_type = "NORMAL"
			');

		$resident_bills_occasional_result = $resident_bills_occasional->result_array();


		foreach($occasional_bills_result as $occasional_key => $occasional_val)
		{
			foreach($resident_bills_occasional_result as $rb_key => $rb_val)
			{
				if($occasional_val['bills_id'] == $rb_val['bills_id'])
				{
					unset($occasional_bills_result[$occasional_key]);
				}
			}
		}

		/*RESIDENT BILLS*/
		$specific_bills_monthly  = $this->db->query('SELECT rb.id as bills_id,rb.description,rb.amount,rb.due_date,rb.type
			FROM resident_bills_tbl as rb
			WHERE rb.status = "ACTIVE"
			AND rb.resident_id = '.$user_id.'
			AND rb.type = "MONTHLY"
			AND rb.due_date >= '.date('d').'
			ORDER BY rb.id
			');

		$specific_monthly  = $specific_bills_monthly->result_array();

		$specific_bills_monthly_payments = $this->db->query('SELECT bills.id as bills_id,bills.description,bills.amount,bills.due_date,bills.type
			FROM payment_history_tbl as history
			INNER JOIN payment_details_tbl as details ON details.payment_id = history.id
			INNER JOIN resident_bills_tbl as bills ON bills.id = details.resident_bills_id
			WHERE history.resident_id = '.$user_id.'
			AND MONTH(history.payment_datetime) = '.date('n').'
			AND bills.type = "MONTHLY"
			AND details.bill_type = "NORMAL"
			');

		$specific_monthly_payment = $specific_bills_monthly_payments->result_array();


		foreach($specific_monthly as $specific_monthly_key => $specific_monthly_val)
		{
			foreach($specific_monthly_payment as $specific_monthly_payment_key => $specific_monthly_payment_val)
			{
				if($specific_monthly_val['bills_id'] == $specific_monthly_payment_val['bills_id'])
				{
					unset($specific_monthly[$specific_monthly_payment_key]);
				}
			}
		}

		$this->db->where('a.due_date >=',date('Y-m-d'));
		$this->db->where('MONTH(a.due_date)',date('n'));
		$this->db->where('a.status','ACTIVE');
		$this->db->where('a.type','OCCASIONAL');
		$this->db->where('a.resident_id',$user_id);
		$this->db->select('a.id as bills_id,a.description,a.amount,a.due_date,a.type');
		$this->db->from('resident_bills_tbl a');
		$specific_bills_occasional = $this->db->get()->result_array();

		$specific_bills_occasional_payments = $this->db->query('SELECT bills.id as bills_id,bills.description,bills.amount,bills.due_date,bills.type
			FROM payment_history_tbl as history
			INNER JOIN payment_details_tbl as details ON details.payment_id = history.id
			INNER JOIN resident_bills_tbl as bills ON bills.id = details.resident_bills_id
			WHERE history.resident_id = '.$user_id.'
			AND bills.type = "OCCASIONAL"
			AND details.bill_type = "NORMAL"
			');

		$specific_bills_occasional_payment = $specific_bills_occasional_payments->result_array();


		foreach($specific_bills_occasional as $specific_bills_occasional_key => $specific_bills_occasional_val)
		{
			foreach($specific_bills_occasional_payment as $specific_bills_occasional_payment_key => $specific_bills_occasional_payment_val)
			{
				if($specific_bills_occasional_val['bills_id'] == $specific_bills_occasional_payment_val['bills_id'])
				{
					unset($specific_bills_occasional[$specific_bills_occasional_key]);
				}
			}
		}


		$due_bills_query = $this->db->query('SELECT due_bills.id as due_bills_id,due_bills.due_amount as amount,due_bills.due_date,
			bills.id as bills_id,bills.description,bills.bill_type
			FROM due_bills_tbl as due_bills
			LEFT JOIN bills_tbl as bills ON bills.id = due_bills.bills_id
			WHERE due_bills.status = "PENDING"
			AND due_bills.resident_id = '.$user_id.'
			');

		$due_bills = $due_bills_query->result_array();

		$result = [];
		$result['bills'] = array_merge($monthly_bills,$occasional_bills_result);
		$result['due_bills'] = $due_bills;
		$result['specific_bills'] = array_merge($specific_monthly,$specific_bills_occasional);
		return $result;
	}

	public function transaction_history()
	{
		$user_id = $_SESSION['id'];

		$query =  $this->db->query('SELECT bills.id as bills_id, bills.description  as bills_description,
			rb.id as rb_id, rb.description as rb_description,
			details.amount,
			history.payment_amount,history.payment_datetime,history.id as history_id
			FROM payment_history_tbl as history
			INNER JOIN payment_details_tbl as details ON details.payment_id = history.id
			LEFT JOIN bills_tbl as bills ON bills.id = details.bills_id
			LEFT JOIN resident_bills_tbl as rb ON rb.id = details.resident_bills_id
			WHERE history.resident_id = '.$user_id.'
			');

		$query_res = $query->result_array();

		$result = array();
		foreach ($query_res as $element)
		{
			$result[$element['history_id']][] = $element;
		}
		return 	$result;
	}

	public function insert_payment_history($data)
	{		
		$this->db->insert('payment_history_tbl',$data);
		return $this->db->insert_id();
	}

	public function update_due_bills($due_id,$payment_id)
	{
		$update_data = [
			'payment_id' => $payment_id,
			'status'     => "PAID"
		];

		$this->db->where('id',$due_id);
		$this->db->update('due_bills_tbl',$update_data);
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


	public function create_tracker($data)
	{
		$this->db->insert('payment_tracker_tbl',$data);
		return $this->db->insert_id();
	}
}