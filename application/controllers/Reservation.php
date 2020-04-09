<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reservation_model','reservation');
		date_default_timezone_set('Asia/manila');
	}

	public function load_reservation_history()
	{
		$result = $this->reservation->load_reservation_history();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_availability($id,$date_from,$date_to,$request_qty)
	{
		$result = $this->reservation->load_availability($id,$date_from,$date_to,$request_qty);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_amenity_reservation($amenity_id)
	{
		$result = $this->reservation->load_amenity_reservation($amenity_id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$post_data = $this->input->post();

		$insert_data = [
			'resident_id'    =>   $_SESSION['id'],
			'amenities_id'   =>   $post_data['amenities'],
			'date_from'      =>   $post_data['date_from'],
			'date_to'        =>   $post_data['date_to'],
			'quantity'       =>   $post_data['quantity'],
			'total_amount'   =>   $post_data['total_amount'],
			'status'         =>   'PENDING',
			'timestamp'      =>   date('Y-m-d H:i:s')
		];

		$result = $this->reservation->insert($insert_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function my_reservation()
	{
		$result = $this->reservation->my_reservation($_SESSION['id']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function sample_query()
	{
		$result = $this->reservation->sample_query();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_reservation_request()
	{
		$result = $this->reservation->load_reservation_request();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function request_action($reservation_id,$action)
	{
		$update_data = ['status' => $action];
		$result = $this->reservation->request_action($reservation_id,$update_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_pending_reservation()
	{
		$result = $this->reservation->load_pending_reservation();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}


}