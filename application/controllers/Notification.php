<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notification_model','notification');
		date_default_timezone_set('Asia/manila');
	}

	public function get()
	{
		$result = $this->notification->get();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function read($id)
	{
		$result = $this->notification->read($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function insert()
	{
		$post_data = $this->input->post();

		$post_data['timestamp'] = date('Y-m-d H:i:s');
		$result = $this->notification->insert($post_data);

		$show = $this->load_numbers($post_data);

		$this->output->set_content_type('application/json')->set_output(json_encode($show));
	}

	public function update($id)
	{
		$post_data = $this->input->post();

		$result = $this->notification->update($id,$post_data['data']);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function delete($id)
	{
		$result = $this->notification->delete($id);
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_all_notification()
	{
		$result = $this->notification->load_all_notification();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function realtime_retrieving()
	{
		$result = $this->notification->realtime_retrieving();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_notification_per_month()
	{
		$result = $this->notification->looper();
		$this->output->set_content_type('application/json')->set_output(json_encode($result));
	}

	public function load_numbers($data)
	{

		$result = $this->notification->load_numbers();

		$msg = $data['title'].': '.$data['content'];

		foreach ($result as $row)
		{
			$this->send_text($row['contact_number'],$msg);
		}

	}


	public function send_text($number,$message,$apicode='TR-JHONB232924_9L278',$passwd='@[e47i[![)'){
		$url = 'https://www.itexmo.com/php_api/api.php';
		$itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
		$param = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($itexmo),
			),
		);
		$context  = stream_context_create($param);
		file_get_contents($url, false, $context);
	}

}