<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Monthly_model','monthly');
		date_default_timezone_set('Asia/manila');
	}

	public function index()
	{

	}

	public function get()
	{
		$result = $this->monthly->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function read($id)
	{
		$result = $this->monthly->read($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$post_data = $this->input->post();


		$post_data['status'] = 'ACTIVE';
		$post_data['timestamp'] = date('Y-m-d H:i:s');

		if($post_data['bill_type'] == 'MONTHLY')
		{
			$dueday_padded = sprintf("%02d", $post_data['dueday']);
			$post_data['due_date'] = $dueday_padded;
			unset($post_data['dueday']);
			unset($post_data['duedate']);
		}
		else
		{
			$post_data['due_date'] = $post_data['duedate'];
			unset($post_data['dueday']);
			unset($post_data['duedate']);
		}
		$result = $this->monthly->insert($post_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function update($id)
	{
		$post_data = $this->input->post();

		if($post_data['data']['bill_type'] == 'MONTHLY')
		{
			$post_data['data']['due_date']   = sprintf("%02d", $post_data['data']['due_date']);
		}

		$result = $this->monthly->update($id,$post_data['data']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete($id)
	{
		$result = $this->monthly->delete($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_payment_history()
	{
		$post_data = $this->input->post();
		$result = $this->monthly->load_payment_history($post_data['date_from'],$post_data['date_to']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_payment_history_spec()
	{
		$post_data = $this->input->post();
		$result = $this->monthly->load_payment_history_spec($post_data['date_from'],$post_data['date_to']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_due_bills()
	{
		$result = $this->monthly->load_due_bills();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_sales_per_month()
	{
		$result = $this->monthly->looper();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function manual_payment()
	{
		$post_data = $this->input->post();

		$payment_history_insert_data = [
			'resident_id'      => $post_data['resident_id'],
			'payment_amount'   => $post_data['payment_amount'],
			'payment_datetime' => $post_data['payment_date'] ." ". date('H:i:s')
		];

		$payment_id = $this->monthly->insert_payment_history($payment_history_insert_data);

		$payment_details_insert_data = [];
		foreach ($post_data['details'] as $val)
		{
			$payment_details_insert_data[] = [
				'payment_id' => $payment_id,
				'bills_id'   => $val['bill_id'],
				'resident_bills_id' => "",
				'bill_type'  => 'NORMAL',
				'amount'     => $val['amount'],
				'timestamp'  => date('Y-m-d H:i:s')
			];
		}

		$result = $this->monthly->insert_payment_details($payment_details_insert_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));

	}
}
