<?php

class Table_model extends MY_Model
{
	protected $table_name = 'tables';

	public $caption;
	public $seats;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

}

/* End of file Table_model.php */
/* Location: ./application/models/Table_model.php */