<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_lot_table extends CI_Migration 
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
			'phase_id' => array(
				'type' => 'SMALLINT'
			),
			'lot' => array(
				'type' => 'SMALLINT'
			),
			'block_count' => array(
				'type' => 'SMALLINT'
			)

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('lot_tbl',TRUE); 
	}

	public function down()
	{
		$this->dbforge->drop_table('lot_tbl', TRUE);
	}
}
