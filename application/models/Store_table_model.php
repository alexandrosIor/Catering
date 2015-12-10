<?php

class Store_table_model extends MY_Model
{
	protected $table_name = 'store_tables';

	public $caption;
	public $seats;
	public $in_use;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

}

/* End of file Table_model.php */
/* Location: ./application/models/Table_model.php */