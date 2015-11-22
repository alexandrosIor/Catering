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

	public function category_name()
	{
		$this->load->model('product_category_model');

		$product_category = $this->product_category_model->get_record(['record_id' => $this->category_record_id]);
		
		if ($product_category)
		{
			return $product_category->name;
		}
		else
		{
			return ' ';
		}
	}

	public function status()
	{
		if ($this->deleted_at)
		{
			return  ' ';
		}
		else
		{
			return 'checked';
		}
	}

}

/* End of file Product_model.php */
/* Location: ./application/models/Product_model.php */