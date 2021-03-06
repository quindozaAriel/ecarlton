<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_reservation_table extends CI_Migration 
{
public function up()
	{
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'resident_id' => array(
				'type' => 'INT'
			),
			'amenities_id' => array(
				'type' => 'INT'
			),
			'date_from' => array(
				'type' => 'DATE'
			),
			'date_to' => array(
				'type' => 'DATE'
			),
			'quantity' => array(
				'type' => 'DECIMAL'
			),
			'payment_id' => array(
				'type' => 'INT'
			),
			'total_amount' => array(
				'type' => 'DECIMAL'
			),
			'status' => array(
				'type' => 'TEXT'
			),
			'src_id' => array(
				'type' => 'TEXT'
			),
			'src_status' => array(
				'type' => 'TEXT'
			),
			'approved_date' => array(
				'type' => 'DATETIME'
			),
			'payment_date' => array(
				'type' => 'DATETIME'
			),
			'payment_type' => array(
				'type' => 'TEXT'
			),
			'reason' => array(
				'type' => 'TEXT'
			),
			'timestamp' => array(
				'type' => 'DATETIME'
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('reservation_tbl',TRUE); 
	}

	public function down()
	{
		$this->dbforge->drop_table('reservation_tbl', TRUE);
	}
}
