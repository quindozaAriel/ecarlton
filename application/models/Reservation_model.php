<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function load_reservation_history()
	{
		$this->db->where('a.status','FINISHED');
		$this->db->select('a.date,a.total_amount,
			b.first_name,b.middle_name,b.last_name,
			c.quantity,c.total_amount as amount,
			d.description
		');
		$this->db->from('reservation_tbl as a');
		$this->db->join('resident_tbl as b','b.id = a.resident_id','left');
		$this->db->join('reservation_amenities_tbl as c','c.reservation_id = a.id','left');
		$this->db->join('amenities_tbl as d','d.id = c.amenities_id','left');
		$this->db->group_by('d.description');
		return $this->db->get()->result_array();
	}
}