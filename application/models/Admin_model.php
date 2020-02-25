<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}

	public function get()
	{
		$this->db->select('*');
		$this->db->from('admin_tbl');
		return $this->db->get()->result_array();
	}

	public function read($id)
	{
		$this->db->where('id',$id);
		$this->db->select('*');
		$this->db->from('admin_tbl');
		return $this->db->get()->row_array();
	}

	public function insert($insert_data)
	{
		$this->db->insert('admin_tbl',$insert_data);
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

	public function update($id,$update_data)
	{
		$this->db->where('id',$id);
		$this->db->update('admin_tbl',$update_data);
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

	public function delete($id)
	{
		$this->db->delete('admin_tbl',['id' => $id]);
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

	public function insert_phase_data($data)
	{
		$this->db->insert('phase_tbl',$data);
		$affected_row = $this->db->affected_rows();

		if($affected_row == 0)
		{
			return FALSE;
		}
		else
		{
			return $this->db->insert_id();
		}
	}

	public function insert_lot_data($data)
	{
		$this->db->insert_batch('lot_tbl',$data);
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

	public function load_residence()
	{
		$this->db->select('*');
		$this->db->from('phase_tbl');
		$this->db->order_by('phase');
		$phase = $this->db->get()->result_array();


		$this->db->select('*');
		$this->db->from('lot_tbl');
		$lot = $this->db->get()->result_array();

		$array_data = [];

		foreach ($phase as $row)
		{
			$phase_data = [];
			$lot_block = [];
			foreach($lot as $lot_row)
			{
				if($row['id'] === $lot_row['phase_id'])
				{
					for($ii = 1;$ii <= intval($lot_row['block_count']);$ii++)
					{
						$lot_data =[
							'lot' => 'LOT NO: '.$lot_row['lot'].' BLOCK NO: '.$ii,
						];
						array_push($lot_block,$lot_data);
					}
					
				}
			}
			$phase_data['phase'] = $row['phase'];
			$phase_data['lot_block']= $lot_block;
			array_push($array_data,$phase_data);
		}
		return $array_data;

	}
}