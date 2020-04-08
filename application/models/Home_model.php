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
}