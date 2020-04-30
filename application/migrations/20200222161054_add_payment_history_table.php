<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_payment_history_table extends CI_Migration 
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
			'payment_amount' => array(
				'type' => 'DECIMAL'
			),
			'payment_datetime' => array(
				'type' => 'DATETIME'
			)

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('payment_history_tbl',TRUE); 
	}

	public function down()
	{
		$this->dbforge->drop_table('payment_history_tbl', TRUE);
	}
}
