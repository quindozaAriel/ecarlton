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
			LEFT JOIN payment_details_tbl as details ON details.payment_id = history.id
			LEFT JOIN bills_tbl as bills ON bills.id = details.bills_id
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

		$occasional_bills_query = $this->db->query('SELECT bills.id as bills_id,bills.description,bills.amount,bills.due_date,bills.bill_type
			FROM bills_tbl as bills
			WHERE bills.status = "ACTIVE"
			AND bills.bill_type = "OCCASIONAL"
			AND MONTH(bills.due_date) = '.date('n').'
			AND bills.due_date >= '.date('Y-m-d').'
			ORDER BY bills.id
			');

		$occasional_bills_result = $occasional_bills_query->result_array();

		$resident_bills_occasional = $this->db->query('SELECT bills.id as bills_id,bills.description,bills.amount,bills.due_date,bills.bill_type
			FROM payment_history_tbl as history
			LEFT JOIN payment_details_tbl as details ON details.payment_id = history.id
			LEFT JOIN bills_tbl as bills ON bills.id = details.bills_id
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
		return $result;
	}

	public function transaction_history()
	{
		$user_id = $_SESSION['id'];

		$query =  $this->db->query('SELECT bills.id as bills_id, bills.description,
			details.amount,
			history.payment_amount,history.payment_datetime,history.id as history_id
			FROM payment_history_tbl as history
			INNER JOIN payment_details_tbl as details ON details.payment_id = history.id
			INNER JOIN bills_tbl as bills ON bills.id = details.bills_id
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
}