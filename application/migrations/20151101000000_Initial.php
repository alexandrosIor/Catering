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
			'caption' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),				
			'seats' => array(
				'type' => 'INT',
				'null' => TRUE,
			)
		));

		$this->dbforge->add_key('record_id',  TRUE);
		$this->dbforge->create_table('tables', TRUE, $attributes);

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
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'email' => 'waiter@catering.gr',
				'password' => 'waiter',
				'role' => 'waiter',
			)
		);
		$this->db->insert_batch('users', $dummy_records);

		/* tables */
		$dummy_records = array(
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '1',
				'seats' => '4'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '2',
				'seats' => '6'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '3',
				'seats' => '2'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '4',
				'seats' => '10'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '5',
				'seats' => '4'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '6',
				'seats' => '4'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => 'πίσω γωνία',
				'seats' => '2'
			)
		);
		$this->db->insert_batch('tables', $dummy_records);
	}

}
?>