<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_due_bills_table extends CI_Migration 
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
			'bills_id' => array(
				'type' => 'INT'
			),
			'payment_id' => array(
				'type' => 'INT'
			),
			'due_amount' => array(
				'type' => 'DECIMAL'
			),
			'due_date' => array(
				'type' => 'DATE'
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
		$this->dbforge->create_table('due_bills_tbl',TRUE); 
	}

	public function down()
	{
		$this->dbforge->drop_table('due_bills_tbl', TRUE);
	}
}
