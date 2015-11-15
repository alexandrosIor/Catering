<?php

class Product_model extends MY_Model
{
	protected $table_name = 'products';

	public $category_record_id;
	public $name;
	public $description;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

}

/* End of file Product_model.php */
/* Location: ./application/models/Product_model.php */