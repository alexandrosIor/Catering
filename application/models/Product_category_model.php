<?php

class Product_category_model extends MY_Model
{
	protected $table_name = 'product_categories';

	public $name;
	public $description;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

}

/* End of file Product_category_model.php */
/* Location: ./application/models/Product_category_model.php */