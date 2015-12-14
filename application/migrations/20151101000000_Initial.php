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
			'table_record_id' => array(
				'type' => 'INT',
				'null' => TRUE,
			),				
			'shift_record_id' => array(
				'type' => 'INT',
				'null' => TRUE,
			)
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
				'firstname' => 'admin',
				'lastname' => 'admin',
				'password' => 'admin',
				'role' => 'admin',
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'email' => 'waiter@catering.gr',
				'firstname' => 'waiter',
				'lastname' => 'waiter',
				'password' => 'waiter',
				'role' => 'waiter',
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'email' => 'store@catering.gr',
				'firstname' => 'store',
				'lastname' => 'store',
				'password' => 'store',
				'role' => 'store',
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
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '7',
				'seats' => '4'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '8',
				'seats' => '6'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '9',
				'seats' => '2'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '10',
				'seats' => '6'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '11',
				'seats' => '4'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '12',
				'seats' => '5'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => 'ΜΕΓΑΛΟ ΑΡΙΣΤΕΡΑ',
				'seats' => '10'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '13',
				'seats' => '4'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '14',
				'seats' => '5'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'caption' => '15',
				'seats' => '8'
			),
		);
		$this->db->insert_batch('store_tables', $dummy_records);

		/* product_categories */
		$dummy_records = array(
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Σαλάτες'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Ορεκτικά κρύα'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Ορεκτικά ζεστά'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Θαλασσινά'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Ψάρια'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Κρεατικά'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Μπύρες'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Χωρις αλκοόλ',
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Ούζα - Τσίπουρα'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Ρετσίνες'
			),
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Κρασιά χύμα'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Κρασιά λευκά εμφιαλωμένα'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'Κρασιά κόκκινα εμφιαλωμένα'
			)
		);
		$this->db->insert_batch('product_categories', $dummy_records);

		/* products */
		$dummy_records = array(
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΠΙΚΑΝΤΙΚΗ / ΠΟΛΙΤΙΚΗ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '1',
				'price' => '3'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΧΩΡΙΑΤΙΚΗ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '1',
				'price' => '5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΧΤΥΠΗΤΗ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '2',
				'price' => '3.5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΤΖΑΤΖΙΚΙ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '2',
				'price' => '3'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΣΚΟΥΜΠΡΙ ΚΑΠΝΙΣΤΟ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '3',
				'price' => '4'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΚΑΥΤΕΡΗ ΠΙΠΕΡΙΑ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '3',
				'price' => '1'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΧΤΑΠΟΔΙ ΣΤΑ ΚΑΡΒΟΥΝΑ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '4',
				'price' => '9.5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΚΑΛΑΜΑΡΙ ΤΗΓΑΝΙΤΟ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '4',
				'price' => '7'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΑΘΕΡΙΝΑ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '5',
				'price' => '6.5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΜΑΡΙΔΑ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '5',
				'price' => '6.5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΠΑΝΣΕΤΑ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '6',
				'price' => '6.5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΣΟΥΤΖΟΥΚΑΚΙΑ',
				'short_description' => '',
				'description' => '',
				'category_record_id' => '6',
				'price' => '6.5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΜΠΥΡΑ ΧΥΜΑ',
				'short_description' => '400ml',
				'description' => '',
				'category_record_id' => '7',
				'price' => '3'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'AMSTEL',
				'short_description' => '500ml',
				'description' => '',
				'category_record_id' => '7',
				'price' => '3'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΗΒΗ ΠΟΡΤΟΚΑΛΑΔΑ',
				'short_description' => '250ml',
				'description' => '',
				'category_record_id' => '8',
				'price' => '1.5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΣΟΥΡΩΤΗ',
				'short_description' => '250ml',
				'description' => '',
				'category_record_id' => '8',
				'price' => '1.5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΠΛΩΜΑΡΙΟΥ',
				'short_description' => '200ml',
				'description' => '',
				'category_record_id' => '9',
				'price' => '5.5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΤΣΑΝΤΑΛΗ',
				'short_description' => '200ml',
				'description' => '',
				'category_record_id' => '9',
				'price' => '5.5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΜΑΛΑΜΑΤΙΝΑ',
				'short_description' => '500ml',
				'description' => '',
				'category_record_id' => '10',
				'price' => '3'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΚΕΧΡΙΜΠΑΡΙ',
				'short_description' => '50ml',
				'description' => '',
				'category_record_id' => '10',
				'price' => '4'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΚΑΡΑΣΙ ΛΕΥΚΟ ΞΗΡΟ',
				'short_description' => '50ml',
				'description' => '',
				'category_record_id' => '11',
				'price' => '3'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΒΙΒΛΙΑ ΧΩΡΑ',
				'short_description' => '750ml',
				'description' => '',
				'category_record_id' => '12',
				'price' => '20'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΝΑΟΥΣΑ ΜΠΟΥΤΑΡΗ',
				'short_description' => '750ml',
				'description' => '',
				'category_record_id' => '12',
				'price' => '15'
			),
		);
		$this->db->insert_batch('products', $dummy_records);
	}

}
?>