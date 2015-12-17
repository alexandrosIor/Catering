<?php

class Order_model extends MY_Model
{
	protected $table_name = 'orders';

	public $table_record_id;
	public $user_record_id;
	public $shift_record_id;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}
	
}

/* End of file Order_model.php */
/* Location: ./application/models/Order_model.php */