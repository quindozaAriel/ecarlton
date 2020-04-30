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
}
