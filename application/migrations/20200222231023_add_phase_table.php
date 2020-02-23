<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_phase_table extends CI_Migration 
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
			'phase' => array(
				'type' => 'SMALLINT'
			),
			'lot_count' => array(
				'type' => 'SMALLINT'
			)

		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id',TRUE);
		$this->dbforge->create_table('phase_tbl',TRUE); 
	}

	public function down()
	{
		$this->dbforge->drop_table('phase_tbl', TRUE);
	}
}
