<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_resident_table extends CI_Migration 
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
			'first_name' => array(
				'type' => 'TEXT'
			),
			'middle_name' => array(
				'type' => 'TEXT'
			),
			'last_name' => array(
				'type' => 'TEXT'
			),
			'email' => array(
				'type' => 'TEXT'
			),
			'contact_number' => array(
				'type' => 'TEXT'
			),
			'image' => array(
				'type' => 'TEXT'
			),
			'phase_no' => array(
				'type' => 'SMALLINT'
			),
			'lot_no' => array(
				'type' => 'SMALLINT'
			),
			'block_no' => array(
				'type' => 'SMALLINT'
			), 
			'username' => array(
				'type' => 'TEXT'
			),
			'password' => array(
				'type' => 'TEXT'
			),
			'timestamp' => array(
				'type' => 'DATETIME'
			)

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('resident_tbl',TRUE); 
	}

	public function down()
	{
		$this->dbforge->drop_table('resident_tbl', TRUE);
	}
}
