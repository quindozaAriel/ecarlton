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
			'date' => array(
				'type' => 'DATETIME'
			),
			'total_amount' => array(
				'type' => 'DECIMAL'
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
		$this->dbforge->create_table('reservation_tbl',TRUE); 
	}

	public function down()
	{
		$this->dbforge->drop_table('reservation_tbl', TRUE);
	}
}