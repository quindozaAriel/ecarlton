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
		$this->db->select('a.date_from,a.date_to,a.total_amount,a.quantity as reserved_qty,a.timestamp,
			b.first_name,b.middle_name,b.last_name,
			d.description
			');
		$this->db->from('reservation_tbl as a');
		$this->db->join('resident_tbl as b','b.id = a.resident_id','left');
		$this->db->join('amenities_tbl as d','d.id = a.amenities_id','left');
		$this->db->group_by('d.description');
		return $this->db->get()->result_array();
	}

	public function load_availability($amenities_id,$date_from,$date_to,$request_qty)
	{
		$query = $this->db->query('SELECT a.description,a.quantity,a.available_qty,a.amount,
			b.id,b.date_from,b.date_to,b.quantity as reserved_qty
			FROM amenities_tbl as a
			INNER JOIN reservation_tbl as b ON b.amenities_id = a.id
			WHERE a.id ='.$amenities_id.' AND a.status = "ACTIVE" AND b.status = "APPROVED" 
			AND ((b.date_from >= "'.$date_from.'" AND b.date_from <= "'.$date_to.'") OR (b.date_to >= "'.$date_from.'" AND b.date_to <= "'.$date_to.'"))
			');

		if($query->num_rows() > 0)
		{
			$data = $query->result_array();

			$reservation_dates = [];
			$format = 'Y-m-d';
			foreach($data as $row)
			{
				$interval = new DateInterval('P1D'); 
				$realEnd = new DateTime($row['date_to']); 
				$realEnd->add($interval); 
				$period = new DatePeriod(new DateTime($row['date_from']), $interval, $realEnd); 

				foreach($period as $date)
				{      
					$array_key = "" ;
					foreach ($reservation_dates as $key => $value)
					{
						if($value['date'] == $date->format($format))
						{
							$array_key = $key;
						}
					}

					if($array_key != "")
					{	
						$reservation_dates[$array_key]['reserved_qty']  = intval($reservation_dates[$array_key]['reserved_qty']) + intval( $row['reserved_qty']);
						$reservation_dates[$array_key]['available_qty'] = intval($reservation_dates[$array_key]['available_qty']) - $reservation_dates[$array_key]['reserved_qty'];
					}
					else
					{
						$reservation_dates[] =  [
							'date'			=>	$date->format($format),
							'reserved_qty'	=>  intval($row['reserved_qty']),
							'available_qty' =>  intval($row['available_qty']) - intval($row['reserved_qty'])
						];  
					}
				} 
			}

			$interval = new DateInterval('P1D'); 
			$realEnd = new DateTime($date_to); 
			$realEnd->add($interval); 
			$period = new DatePeriod(new DateTime($date_from), $interval, $realEnd); 
			$request_dates = [];
			foreach($period as $date)
			{      
				$request_dates[] = [
					'date'         => $date->format($format),
					'request_qty'  => intval($request_qty)
				];
			}

			$return_key = [];
			foreach($request_dates as $request_key => $request_val)
			{
				foreach($reservation_dates as $reserve_key => $reserve_val)
				{
					if($request_val['date'] == $reserve_val['date'])
					{
						if($reserve_val['available_qty'] < $request_val['request_qty'])
						{
							$return_key[] = $reserve_key;
						}
					}
				}
			}

			if(empty($return_key))
			{
				return 'AVAILABLE';
			}
			else
			{
				return 'FULL';
			}
		}
		else
		{
			return 'AVAILABLE';
		}

	}

	public function load_amenity_reservation($amenity_id)
	{
		$this->db->where('a.status','ACTIVE');
		$this->db->where('b.status ','APPROVED');
		$this->db->where('b.amenities_id',$amenity_id);
		$this->db->select('a.description,a.quantity,a.amount,
			b.id,b.date_from,b.date_to,b.quantity as reserved_qty,b.total_amount,
			c.first_name,c.last_name');
		$this->db->from('amenities_tbl as a');
		$this->db->join('reservation_tbl as b','b.amenities_id = a.id','left');
		$this->db->join('resident_tbl as c','b.resident_id = c.id','left' );
		return $this->db->get()->result_array();
	}

	public function insert($insert_data)
	{
		$this->db->insert('reservation_tbl',$insert_data);
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

	public function my_reservation($resident_id)
	{
		$this->db->where('a.resident_id',$resident_id);
		$this->db->select('a.*,b.description');
		$this->db->from('reservation_tbl as a');
		$this->db->join('amenities_tbl as b','a.amenities_id = b.id','left');
		$this->db->order_by('a.date_from','DESC');
		return $this->db->get()->result_array();
	}


	public function sample_query()
	{
		
		$query = $this->db->query('SELECT a.description,a.quantity,a.available_qty,a.amount,
			b.id,b.date_from,b.date_to,b.quantity as reserved_qty
			FROM amenities_tbl as a
			LEFT JOIN reservation_tbl as b ON b.amenities_id = a.id
			WHERE a.id ="1" AND a.status = "ACTIVE" AND b.status <> "FINISHED" AND b.status <> "DECLINED" 
			AND (b.date_from >= "2020-03-24" AND b.date_from <= "2020-03-26") OR (b.date_to >= "2020-03-24" AND b.date_to <= "2020-03-26")
			');

		if($query->num_rows() > 0)
		{
			$data = $query->result_array();

			$reservation_dates = [];
			$format = 'Y-m-d';
			foreach($data as $row)
			{
				$interval = new DateInterval('P1D'); 
				$realEnd = new DateTime($row['date_to']); 
				$realEnd->add($interval); 
				$period = new DatePeriod(new DateTime($row['date_from']), $interval, $realEnd); 

				foreach($period as $date)
				{      
					$array_key = "" ;
					foreach ($reservation_dates as $key => $value)
					{
						if($value['date'] == $date->format($format))
						{
							$array_key = $key;
						}
					}

					if($array_key != "")
					{	
						$reservation_dates[$array_key]['reserved_qty']  = intval($reservation_dates[$array_key]['reserved_qty']) + intval( $row['reserved_qty']);
						$reservation_dates[$array_key]['available_qty'] = intval($reservation_dates[$array_key]['available_qty']) - $reservation_dates[$array_key]['reserved_qty'];
					}
					else
					{
						$reservation_dates[] =  [
							'date'			=>	$date->format($format),
							'reserved_qty'	=>  intval($row['reserved_qty']),
							'available_qty' =>  intval($row['available_qty']) - intval($row['reserved_qty'])
						];  
					}
				} 
			}

			$interval = new DateInterval('P1D'); 
			$realEnd = new DateTime('2020-03-25'); 
			$realEnd->add($interval); 
			$period = new DatePeriod(new DateTime('2020-03-24'), $interval, $realEnd); 
			$request_dates = [];
			foreach($period as $date)
			{      
				$request_dates[] = [
					'date'         => $date->format($format),
					'request_qty'  => 5
				];
			}

			$return_key = [];
			foreach($request_dates as $request_key => $request_val)
			{
				foreach($reservation_dates as $reserve_key => $reserve_val)
				{
					if($request_val['date'] == $reserve_val['date'])
					{
						if($reserve_val['available_qty'] < $request_val['request_qty'])
						{
							$return_key[] = $reserve_key;
						}
					}
				}
			}

			if(empty($return_key))
			{
				return TRUE;
			}
			else
			{
				return 'FULL';
			}
		}
		else
		{
			return TRUE;
		}
	}

	
	public function getDatesFromRange($start, $end, $format = 'Y-m-d')
	{ 
		$array = []; 

		

		$realEnd = new DateTime($end); 
		$realEnd->add($interval); 

		$period = new DatePeriod(new DateTime($start), $interval, $realEnd); 


		foreach($period as $date) {                  
			$array[] = $date->format($format);  
		} 


		return $array; 
	} 
}