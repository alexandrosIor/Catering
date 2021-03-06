<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Dummy_data extends CI_Migration {

	public function up()
	{
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
				'email' => 'alex@catering.gr',
				'firstname' => 'Αλέξανδρος',
				'lastname' => 'Ιορδανίδης',
				'password' => 'catering',
				'role' => 'waiter',
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'email' => 'john@catering.gr',
				'firstname' => 'John',
				'lastname' => 'Doe',
				'password' => 'catering',
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
				'description' => 'Winter cabbage & carrot salad',
				'category_record_id' => '1',
				'price' => '3'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΧΩΡΙΑΤΙΚΗ',
				'short_description' => 'Greek salad',
				'description' => 'Greek salad',
				'category_record_id' => '1',
				'price' => '5'
			),			
			array(
				'insert_at' => $datatime_now->format('Y-m-d H:i:s'),
				'name' => 'ΧΤΥΠΗΤΗ',
				'short_description' => '',
				'description' => 'Καυτερό τυρί φέτα',
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
				'description' => 'Smoked cavalla',
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
				'description' => 'Ρετσίνα Μαλαματίνα',
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
				'name' => 'ΚΡΑΣΙ ΛΕΥΚΟ ΞΗΡΟ',
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