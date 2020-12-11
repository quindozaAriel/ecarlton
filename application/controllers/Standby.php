<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Standby extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Standby_model','standby');
		date_default_timezone_set('Asia/manila');
	}

	public function cronJob()
	{
		$this->check_occasional_due_bills();
		$this->check_due_bills();

		$this->check_specific_bills_occasional();
		$this->check_specific_bills_monthly();
	}
	
	public function check_occasional_due_bills()
	{
		$residents = $this->get_all_active_resident();
		$occasional_bills = $this->check_occasional_due_bill();
		
		$due_info = [];

		foreach ($residents as $resident_row)
		{
			foreach ($occasional_bills as $bill_row)
			{
				$exist_result = $this->check_if_exist($bill_row['bill_id'],$resident_row['resident_id']);

				if($exist_result == NULL)
				{
					$payment_details_result = $this->check_payment_details_occasional($bill_row['bill_id'],$resident_row['resident_id']);

					if($payment_details_result == NULL)
					{
						$due_info[] = [
							'resident_id' => $resident_row['resident_id'],
							'bills_id'    => $bill_row['bill_id'],
							'resident_bills_id' => "",
							'due_amount'  => $bill_row['amount'],
							'due_date'    => date('Y-m-d'),
							'status'      => "PENDING",
							'timestamp'   => date('Y-m-d H:i:s')
						];
					}
				}
			}
		}

		if(!empty($due_info))
		{
			$final_result = $this->insert_due_bills($due_info);
		}
		else
		{
			$final_result = FALSE;
		}


		$this->output->set_content_type('application/json')->set_output(json_encode($final_result));
	}

	public function check_occasional_due_bill()
	{
		$result = $this->standby->check_occasional_due_bill();
		return $result;
	}

	public function get_all_active_resident()
	{
		$result = $this->standby->get_all_active_resident();
		return $result;
	}

	public function check_payment_details_occasional($bills_id,$resident_id)
	{
		$result = $this->standby->check_payment_details_occasional($bills_id,$resident_id);
		return $result;
	}

	public function check_if_exist($bills_id,$resident_id)
	{
		$result = $this->standby->check_if_exist($bills_id,$resident_id);
		return $result;
	}

	public function insert_due_bills($data)
	{
		$result = $this->standby->insert_due_bills($data);
		return $result;
	}

	public function check_due_bills()
	{
		$residents = $this->get_all_active_resident();
		$monthly_bills = $this->check_monthly_due_bill();

		$due_info = [];

		foreach ($residents as $resident_row)
		{
			foreach ($monthly_bills as $bill_row)
			{
				$exist_result = $this->check_if_exist_monthly($bill_row['bill_id'],$resident_row['resident_id']);

				if($exist_result == NULL)
				{
					$payment_details_result = $this->check_payment_details_monthly($bill_row['bill_id'],$resident_row['resident_id']);

					if($payment_details_result == NULL)
					{
						$due_info[] = [
							'resident_id' => $resident_row['resident_id'],
							'bills_id'    => $bill_row['bill_id'],
							'resident_bills_id' => "",
							'due_amount'  => $bill_row['amount'],
							'due_date'    => date('Y-m-d'),
							'status'      => "PENDING",
							'timestamp'   => date('Y-m-d H:i:s')
						];
					}
				}
			}
		}

		if(!empty($due_info))
		{
			$final_result = $this->insert_due_bills($due_info);
		}
		else
		{
			$final_result = FALSE;
		}
		
		$this->output->set_content_type('application/json')->set_output(json_encode($final_result));
	}

	public function check_monthly_due_bill()
	{
		$result = $this->standby->check_monthly_due_bill();
		return $result;
	}

	public function check_if_exist_monthly($bills_id,$resident_id)
	{
		$result = $this->standby->check_if_exist_monthly($bills_id,$resident_id);
		return $result;
	}


	public function check_payment_details_monthly($bills_id,$resident_id)
	{
		$result = $this->standby->check_payment_details_monthly($bills_id,$resident_id);
		return $result;
	}

	public function check_specific_bills_occasional()
	{

		$occasional_bills = $this->check_spec_occasional_due_bill();
		
		$due_info = [];

		foreach ($occasional_bills as $bill_row)
		{
			$exist_result = $this->check_if_exist_spec_occasional($bill_row['bill_id'],$resident_row['resident_id']);

			if($exist_result == NULL)
			{
				$payment_details_result = $this->check_payment_spec_occasional($bill_row['bill_id'],$resident_row['resident_id']);

				if($payment_details_result == NULL)
				{
					$due_info[] = [
						'resident_id' => $resident_row['resident_id'],
						'bills_id'    => "", 
						'resident_bills_id' => $bill_row['bill_id'],
						'due_amount'  => $bill_row['amount'],
						'due_date'    => date('Y-m-d'),
						'status'      => "PENDING",
						'timestamp'   => date('Y-m-d H:i:s')
					];
				}
			}
		}
		

		if(!empty($due_info))
		{
			$final_result = $this->insert_due_bills($due_info);
		}
		else
		{
			$final_result = FALSE;
		}


		$this->output->set_content_type('application/json')->set_output(json_encode($final_result));
	}


	public function check_specific_bills_monthly()
	{
		$monthly_bills = $this->check_spec_monthly_due_bill();
		
		$due_info = [];

		foreach ($monthly_bills as $bill_row)
		{
			$exist_result = $this->check_if_exist_spec_monthly($bill_row['bill_id'],$resident_row['resident_id']);

			if($exist_result == NULL)
			{
				$payment_details_result = $this->check_payment_spec_monthly($bill_row['bill_id'],$resident_row['resident_id']);

				if($payment_details_result == NULL)
				{
					$due_info[] = [
						'resident_id' => $resident_row['resident_id'],
						'bills_id'    => "", 
						'resident_bills_id' => $bill_row['bill_id'],
						'due_amount'  => $bill_row['amount'],
						'due_date'    => date('Y-m-d'),
						'status'      => "PENDING",
						'timestamp'   => date('Y-m-d H:i:s')
					];
				}
			}
		}
		

		if(!empty($due_info))
		{
			$final_result = $this->insert_due_bills($due_info);
		}
		else
		{
			$final_result = FALSE;
		}


		$this->output->set_content_type('application/json')->set_output(json_encode($final_result));
	}

	public function check_spec_occasional_due_bill()
	{
		$result = $this->standby->check_spec_monthly_due_bill();
		return $result;
	}

	public function check_payment_spec_occasional($bills_id,$resident_id)
	{
		$result = $this->standby->check_payment_spec_monthly($bills_id,$resident_id);
		return $result;
	}

	public function check_if_exist_spec_occasional($bills_id,$resident_id)
	{
		$result = $this->standby->check_if_exist_spec_monthly($bills_id,$resident_id);
		return $result;
	}

	public function check_spec_monthly_due_bill()
	{
		$result = $this->standby->check_spec_monthly_due_bill();
		return $result;
	}

	public function check_payment_spec_monthly($bills_id,$resident_id)
	{
		$result = $this->standby->check_payment_spec_monthly($bills_id,$resident_id);
		return $result;
	}

	public function check_if_exist_spec_monthly($bills_id,$resident_id)
	{
		$result = $this->standby->check_if_exist_spec_monthly($bills_id,$resident_id);
		return $result;
	}

}