<?php

class Order_products_model extends MY_Model
{
	protected $table_name = 'order_products';

	public $order_record_id;
	public $order_data;
	public $quantity;
	public $comments;
	public $start_datetime;
	public $end_datetime;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

}

/* End of file Order_products_model.php */
/* Location: ./application/models/Order_products_model.php */