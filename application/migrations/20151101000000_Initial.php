<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Initial extends CI_Migration {

	public function up()
	{
		$attributes = array('ENGINE'=>'MyISAM');
		/* TABLE: members */
		$this->dbforge->add_field(array(
			'record_id' => array(
				'type' => 'BIGINT',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'deleted_at' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'insert_at' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'update_at' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),
			'member_group_id' => array(
				'type' => 'BIGINT',
				'unsigned' => TRUE,
			),
			'member_id' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),
			'lastname' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),
			'firstname' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),
		));
		$this->dbforge->add_key('record_id', TRUE);
		$this->dbforge->create_table('members', TRUE, $attributes);
	}

}

?>