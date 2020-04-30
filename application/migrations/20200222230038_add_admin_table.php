<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_admin_table extends CI_Migration 
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
			'username' => array(
				'type' => 'TEXT'
			),
			'password' => array(
				'type' => 'TEXT'
			),
			'image' => array(
				'type' => 'TEXT'
			),
			'timestamp' => array(
				'type' => 'DATETIME'
			)

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('admin_tbl',TRUE); 
	}

	public function down()
	{
		$this->dbforge->drop_table('admin_tbl', TRUE);
	}
}
