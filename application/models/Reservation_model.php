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
		$this->db->where('reservation.status','FINISHED');
		$this->db->or_where('reservation.status','REJECTED');
		$this->db->select('reservation.id as reservation_id,reservation.date_from,reservation.date_to,reservation.quantity,reservation.total_amount,reservation.timestamp,reservation.status,
			amenity.description,
			resident.first_name,resident.last_name
			');
		$this->db->from('reservation_tbl as reservation');
		$this->db->join('amenities_tbl as amenity','amenity.id = reservation.amenities_id');
		$this->db->join('resident_tbl as resident','resident.id = reservation.resident_id');
		$this->db->order_by('reservation.timestamp');
		$result = $this->db->get()->result_array();
		return $result;
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
		$this->db->where('b.status ','PAID');
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

	public function load_reservation_request()
	{
		$this->db->where('reservation.status','PENDING');
		$this->db->select('reservation.id as reservation_id,reservation.date_from,reservation.date_to,reservation.quantity,reservation.total_amount,reservation.timestamp,
			amenity.description,
			resident.first_name,resident.last_name
			');
		$this->db->from('reservation_tbl as reservation');
		$this->db->join('amenities_tbl as amenity','amenity.id = reservation.amenities_id');
		$this->db->join('resident_tbl as resident','resident.id = reservation.resident_id');
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function request_action($reservation_id,$data)
	{
		$this->db->where('id',$reservation_id);
		$this->db->update('reservation_tbl',$data);
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

	public function load_pending_reservation()
	{
		$this->db->where('reservation.status','PAID');
		$this->db->select('reservation.id as reservation_id,reservation.date_from,reservation.date_to,reservation.quantity,reservation.total_amount,reservation.timestamp,
			amenity.description,
			resident.first_name,resident.last_name
			');
		$this->db->from('reservation_tbl as reservation');
		$this->db->join('amenities_tbl as amenity','amenity.id = reservation.amenities_id');
		$this->db->join('resident_tbl as resident','resident.id = reservation.resident_id');
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function looper()
	{
		$array = [];
		for ($i=1; $i <= 12; $i++)
		{ 
			$array[$i] = $this->load_reservation_per_month($i);	
		}
		return $array;
	}

	public function load_reservation_per_month($month)
	{
		$query = $this->db->query('SELECT COUNT(*) AS count
			FROM reservation_tbl
			where status != "REJECTED" AND status != "PENDING" AND status != "APPROVED"
			AND YEAR(date_from) = '.date("Y").' and YEAR(date_to) = '.date("Y").'
			AND (MONTH(date_from) = '.$month.' OR MONTH(date_to) = '.$month.')
			');
		$result = $query->row_array();
		return $result;
	}

	public function pay_reservation($data)
	{
		$this->db->insert('payment_history_tbl',$data);
		$insert_id = $this->db->insert_id();

		if($insert_id == 0)
		{
			return FALSE;
		}
		else
		{
			return $insert_id;
		}
	}

	public function update_payment($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('reservation_tbl',$data);
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

	public function looper2()
	{
		$array = [];
		for ($i=1; $i <= 12; $i++)
		{ 
			$result = $this->load_sales_per_month($i);	
			if($result['total_amount'] == null)
			{
				$array[$i] = 0;
			}
			else
			{
				$array[$i] = $result;
			}
		}
		return $array;
	}

	public function load_sales_per_month($month)
	{	
		$query = $this->db->query('SELECT SUM(history.payment_amount) as total_amount
			FROM reservation_tbl as reservation
			LEFT JOIN payment_history_tbl as history ON history.id = reservation.payment_id
			where  YEAR(reservation.timestamp) = '.date("Y").'
			AND (reservation.status = "FINISHED" OR reservation.status = "PAID")
			AND (history.id IS NOT NULL OR history.id != 0)
			AND MONTH(reservation.timestamp) = '.$month.'
			');

		$result = $query->row_array();
		return $result;
	}

	public function load_forpayment_reservation()
	{
		$this->db->where('reservation.status','APPROVED');
		$this->db->select('reservation.id as reservation_id,reservation.date_from,reservation.date_to,reservation.quantity,reservation.total_amount,reservation.timestamp,
			amenity.description,
			resident.first_name,resident.last_name
			');
		$this->db->from('reservation_tbl as reservation');
		$this->db->join('amenities_tbl as amenity','amenity.id = reservation.amenities_id');
		$this->db->join('resident_tbl as resident','resident.id = reservation.resident_id');
		$result = $this->db->get()->result_array();
		return $result;
	}
}