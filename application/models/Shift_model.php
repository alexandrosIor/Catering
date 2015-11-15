<?php

class Shift_model extends MY_Model
{
	protected $table_name = 'shifts';

	public $user_record_id;
	public $start_datetime;
	public $end_datetime;
	public $total_sales;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

}

/* End of file Shift_model.php */
/* Location: ./application/models/Shift_model.php */