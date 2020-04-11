<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bills extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Bills_model','bill');
		date_default_timezone_set('Asia/manila');
	}

	public function get()
	{
		$result = $this->bill->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function transaction_history()
	{
		$result = $this->bill->transaction_history();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$post_data = $this->input->post();

		$payment_history_insert_data = [
			'resident_id'      => $_SESSION['id'],
			'payment_amount'   => $post_data['total_amount'],
			'payment_datetime' => date('Y-m-d H:i:s')
		];

		$payment_id = $this->bill->insert_payment_history($payment_history_insert_data);

		$bills = [];
		foreach ($post_data['bills'] as $row)
		{
			$row = str_replace("-","_",$row);
			$new_data = explode("_",$row);
			$bills[] = $new_data;
		}

		$payment_details_insert_data = [];
		foreach ($bills as $val)
		{
			$bill_type = "NORMAL";
			if($val[0] == "due")
			{
				$this->bill->update_due_bills($val[1],$payment_id);
				$bill_type = "DUE";
			}

			$payment_details_insert_data[] = [
				'payment_id' => $payment_id,
				'bills_id'   => $val[1],
				'bill_type'  => $bill_type,
				'amount'     => $val[2],
				'timestamp'  => date('Y-m-d H:i:s')
			];
		}

		$result = $this->bill->insert_payment_details($payment_details_insert_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));

	}

}