<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Parent_category extends CI_Migration {

	public function up()
	{
		/* TABLE: product_categories */
		$fields = array(
			'parent_record_id' => array(
			'type' => 'INT',
			)
		);
		$this->dbforge->add_column('product_categories', $fields);
	}

	public function down()
	{

	}
}