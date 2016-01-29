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
			'firstname' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),			
			'lastname' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
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
			'short_description' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),			
			'description' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'price' => array(
				'type' => 'FLOAT',
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
			),
			'parent_record_id' => array(
				'type' => 'INT',
				'unsigned' => TRUE,
				'null' => TRUE,
				'default' => 0
			),
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
			'role' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),		
			'start_date' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			),			
			'end_date' => array(
				'type' => 'DATETIME',
				'null' => TRUE,
			),
			'turnover_delivered' => array(
				'type' => 'FLOAT',
				'null' => TRUE,
			),
			'turnover_calculated' => array(
				'type' => 'FLOAT',
				'null' => TRUE,
			),
			'turnover_diff' => array(
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
			'store_table_record_id' => array(
				'type' => 'INT',
				'null' => TRUE,
			),				
			'shift_record_id' => array(
				'type' => 'INT',
				'null' => TRUE,
			),
			'start_date' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),			
			'end_date' => array(
				'type' => 'DATETIME',
				'null' => TRUE
			),			
			'payment_status' => array(
				'type' => 'ENUM("paid","pending")',
				'default' => 'pending',
				'null' => TRUE,
			),
		));

		$this->dbforge->add_key('record_id',  TRUE);
		$this->dbforge->create_table('orders', TRUE, $attributes);

		/* TABLE: order_products */
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
			'order_record_id' => array(
				'type' => 'INT',
				'null' => TRUE,
			),				
			'product_record_id' => array(
				'type' => 'INT',
				'null' => TRUE,
			),				
			'comments' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),			
			'quantity' => array(
				'type' => 'INT',
				'null' => TRUE,
			)
		));

		$this->dbforge->add_key('record_id',  TRUE);
		$this->dbforge->create_table('order_products', TRUE, $attributes);

		/* TABLE: store_tables */
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
				'type' => 'VARCHAR',
				'constraint' => 255,
				'null' => TRUE,
			),
			'in_use' => array(
				'type' => 'BIT(1)',
			)
		));

		$this->dbforge->add_key('record_id',  TRUE);
		$this->dbforge->create_table('store_tables', TRUE, $attributes);
	}

}
?>