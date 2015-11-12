<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Initial extends CI_Migration {

	public function up()
	{
		$attributes = array('ENGINE'=>'MyISAM');
		/* TABLE: users */
		$this->dbforge->add_field(array(
			'record_id' => array(
				'type' => 'INT',
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
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),			
			'role' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			)

		));
		$this->dbforge->add_key('record_id', TRUE);
		$this->dbforge->create_table('users', TRUE, $attributes);

		/* TABLE: products */
		$this->dbforge->add_field(array(
			'record_id' => array(
				'type' => 'INT',
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
			'category_record_id' => array(
				'type' => 'INT',
				'null' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),			
			'description' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			)
		));

		$this->dbforge->add_key('record_id', TRUE);
		$this->dbforge->create_table('products', TRUE, $attributes);

		/* TABLE: product_categories */
		$this->dbforge->add_field(array(
			'record_id' => array(
				'type' => 'INT',
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
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),			
			'description' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			)
		));

		$this->dbforge->add_key('record_id', TRUE);
		$this->dbforge->create_table('product_categories', TRUE, $attributes);

		/* TABLE: shifts */
		$this->dbforge->add_field(array(
			'record_id' => array(
				'type' => 'INT',
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
			'user_record_id' => array(
				'type' => 'INT',
				'null' => TRUE,
			),			
			'start_datetime' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			),			
			'end_datetime' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			),
			'total_sales' => array(
				'type' => 'FLOAT',
				'null' => TRUE,
			)
		));

		$this->dbforge->add_key('record_id', TRUE);
		$this->dbforge->create_table('shifts', TRUE, $attributes);

		/* TABLE: orders */
		$this->dbforge->add_field(array(
			'record_id' => array(
				'type' => 'INT',
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
			'user_record_id' => array(
				'type' => 'INT',
				'null' => TRUE,
			),				
			'shift_record_id' => array(
				'type' => 'INT',
				'null' => TRUE,
			),				
			'order_data' => array(
				'type' => 'LONGBLOB',
				'null' => TRUE,
			),			
			'start_datetime' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			),			
			'end_datetime' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			)
		));

		$this->dbforge->add_key('record_id',  TRUE);
		$this->dbforge->create_table('orders', TRUE, $attributes);

		$this->insert_common_records();
	}

	private function insert_common_records()
	{
		$datatime_now = new DateTime('NOW', new DateTimeZone('UTC'));
		/* users */
		$dummy_records = array(
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'email' => 'admin@catering.gr',
				'password' => 'admin',
				'role' => 'admin',
			)
		);
		$this->db->insert_batch('users', $dummy_records);
	}

}
?>