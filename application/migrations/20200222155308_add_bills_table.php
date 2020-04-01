<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_bills_table extends CI_Migration 
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
			'description' => array(
				'type' => 'TEXT'
			),
			'amount' => array(
				'type' => 'DECIMAL'
			),
			'due_date' => array(
				'type' => 'TEXT'
			),
			'notif_date' => array(
				'type' => 'TEXT'
			),
			'bill_type' => array(
				'type' => 'TEXT'
			),
			'status' => array(
				'type' => 'TEXT'
			),
			'timestamp' => array(
				'type' => 'DATETIME'
			)

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('bills_tbl',TRUE); 
	}

	public function down()
	{
		$this->dbforge->drop_table('bills_tbl', TRUE);
	}
}
