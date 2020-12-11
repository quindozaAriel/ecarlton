<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ResidentBill_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get()
    {
        $this->db->where('a.status', 'ACTIVE');
        $this->db->select('a.*,b.first_name,b.last_name');
        $this->db->from('resident_bills_tbl a');
        $this->db->join('resident_tbl b', 'a.resident_id = b.id');
        return $this->db->get()->result_array();
    }

    public function read($id)
    {
        $this->db->where('a.id', $id);
        $this->db->select('a.*,b.first_name,b.last_name');
        $this->db->from('resident_bills_tbl a');
        $this->db->join('resident_tbl b', 'a.resident_id = b.id');
        return $this->db->get()->row_array();
    }

    public function insert($insert_data)
    {
        $this->db->insert('resident_bills_tbl', $insert_data);
        $affected_row = $this->db->affected_rows();

        if ($affected_row == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function update($id, $update_data)
    {
        $this->db->where('id', $id);
        $this->db->update('resident_bills_tbl', $update_data);
        $affected_row = $this->db->affected_rows();

        if ($affected_row == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->update('resident_bills_tbl', ['status' => 'INACTIVE']);
        $affected_row = $this->db->affected_rows();

        if ($affected_row == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_bills($id)
    {
        $this->db->where('status','ACTIVE');
        $this->db->where('resident_id',$id);
        $this->db->select('*');
        $this->db->from('resident_bills_tbl');
        return $this->db->get()->result_array();
    }

    public function insert_payment_history($data)
    {
        $this->db->insert('payment_history_tbl',$data);
        return $this->db->insert_id();
    }

    public function insert_payment_details($data)
    {
        $result = $this->db->insert_batch('payment_details_tbl',$data);

        if($result > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}
