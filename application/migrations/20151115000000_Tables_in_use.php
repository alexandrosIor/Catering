<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Tables_in_use extends CI_Migration {

	public function up()
	{
		/* TABLE: tables */
		$fields = array(
			'in_use' => array(
			'type' => 'BIT(1)',
			)
		);
		$this->dbforge->add_column('tables', $fields);
	}

	public function down()
	{

	}
}