<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/manila');
	}

	public function check_notification()
	{
		$this->db->select('*');
		$this->db->from('notification_tbl');
		$this->db->where('date >=',date('Y-m-d'));
		$this->db->order_by('date','DESC');
		$notifications = $this->db->get()->result_array();

		$this->db->select('MAX(id) as id');
		$this->db->from('notification_tbl');
		$last_notification =  $this->db->get()->row_array();

		return ['notifications' => $notifications,'last_notification' => $last_notification['id']];
	}

	public function check_bills()
	{
		$user_id = $_SESSION['id'];

		$monthly_bills_query  = $this->db->query('SELECT bills.id as bills_id
			FROM bills_tbl as bills
			WHERE bills.status = "ACTIVE"
			AND bills.bill_type = "MONTHLY"
			AND bills.due_date >= '.date('d').'
			ORDER BY bills.id
			');

		$monthly_bills  = $monthly_bills_query->result_array();

		$resident_bills_query = $this->db->query('SELECT bills.id as bills_id
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

		$occasional_bills_query = $this->db->query('SELECT bills.id as bills_id
			FROM bills_tbl as bills
			WHERE bills.status = "ACTIVE"
			AND bills.bill_type = "OCCASIONAL"
			AND MONTH(bills.due_date) = '.date('n').'
			AND bills.due_date >= '.date('Y-m-d').'
			ORDER BY bills.id
			');

		$occasional_bills_result = $occasional_bills_query->result_array();

		$resident_bills_occasional = $this->db->query('SELECT bills.id as bills_id
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

		$due_bills_query = $this->db->query('SELECT due_bills.id as due_bills_id,
			bills.id as bills_id,bills.description,bills.bill_type
			FROM due_bills_tbl as due_bills
			LEFT JOIN bills_tbl as bills ON bills.id = due_bills.bills_id
			WHERE due_bills.status = "PENDING"
			AND due_bills.resident_id = '.$user_id.'
			');

		$due_bills = $due_bills_query->result_array();

		$result = [];
		$result= array_merge($monthly_bills,$occasional_bills_result, $due_bills);
		return $result;
	}

	public function check_reservation()
	{
		$id = $_SESSION['id'];

		$this->db->where('resident_id',$id);
		$this->db->where('status','PENDING');
		$this->db->select('COUNT(*) as PENDING');
		$this->db->from('reservation_tbl');
		$pending =  $this->db->get()->result_array();

		$this->db->where('resident_id',$id);
		$this->db->where('status','APPROVED');
		$this->db->select('COUNT(*) as APPROVED');
		$this->db->from('reservation_tbl');
		$approved =  $this->db->get()->result_array();

		$this->db->where('resident_id',$id);
		$this->db->where('status','PAID');
		$this->db->select('COUNT(*) as PAID');
		$this->db->from('reservation_tbl');
		$paid =  $this->db->get()->result_array();

		$this->db->where('resident_id',$id);
		$this->db->where('status','REJECTED');
		$this->db->select('COUNT(*) as REJECTED');
		$this->db->from('reservation_tbl');
		$rejected =  $this->db->get()->result_array();

		$result = array_merge($pending,$approved,$rejected,$paid);

		return $result;
	}
}