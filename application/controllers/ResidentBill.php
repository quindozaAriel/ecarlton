<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ResidentBill extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ResidentBill_model', 'resbill');
        date_default_timezone_set('Asia/manila');
    }

    public function get()
    {
        $result = $this->resbill->get();
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function read($id)
    {
        $result = $this->resbill->read($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function insert()
    {
        $post_data = $this->input->post();


        $post_data['status'] = 'ACTIVE';
        $post_data['timestamp'] = date('Y-m-d H:i:s');
        
        $result = $this->resbill->insert($post_data);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function update($id)
    {
        $post_data = $this->input->post();
        
        $result = $this->resbill->update($id, $post_data['datas']);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function delete($id)
    {
        $result = $this->resbill->delete($id);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function get_bills($resident_id)
    {
       $result = $this->resbill->get_bills($resident_id);
       $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }


    public function manual_payment()
    {
        $post_data = $this->input->post();

        $payment_history_insert_data = [
            'resident_id'      => $post_data['resident_id'],
            'payment_amount'   => $post_data['payment_amount'],
            'payment_datetime' => $post_data['payment_date']
        ];

        $payment_id = $this->resbill->insert_payment_history($payment_history_insert_data);

        $payment_details_insert_data = [];
        foreach ($post_data['details'] as $val)
        {
            $payment_details_insert_data[] = [
                'payment_id' => $payment_id,
                'resident_bills_id'   => $val['resident_bill_id'],
                'bills_id'   => "",
                'bill_type'  => 'NORMAL',
                'amount'     => $val['amount'],
                'timestamp'  => date('Y-m-d H:i:s')
            ];
        }

        $result = $this->resbill->insert_payment_details($payment_details_insert_data);
        $this->output->set_content_type('application/json')->set_output(json_encode($result));

    }
}
