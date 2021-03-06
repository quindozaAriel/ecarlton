<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_add_resident_bills_table extends CI_Migration
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
      'description' => array(
        'type' => 'text'
      ),
      'amount' => array(
        'type' => 'DECIMAL'
      ),
      'type' => array(
        'type' => 'TEXT'
      ),
      'due_date' => array(
        'type' => 'text'
      ),
      'status' => array(
        'type' => 'TEXT'
      ),
      'timestamp' => array(
        'type' => 'DATETIME'
      )

    );
    $this->dbforge->add_field($fields);
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table('resident_bills_tbl', TRUE);
  }

  public function down()
  {
    $this->dbforge->drop_table('bills_tbl', TRUE);
  }
}
