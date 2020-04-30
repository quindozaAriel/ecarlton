<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_amenities_table extends CI_Migration 
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
			'quantity' => array(
				'type' => 'INT'
			),
			'available_qty' => array(
				'type' => 'INT'
			),
			'amount' => array(
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
		$this->dbforge->create_table('amenities_tbl',TRUE); 
	}

	public function down()
	{
		$this->dbforge->drop_table('amenities_tbl', TRUE);
	}
}
