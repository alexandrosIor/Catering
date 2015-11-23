<?php

class Product_category_model extends MY_Model
{
	protected $table_name = 'product_categories';

	public $name;
	public $description;
	public $parent_record_id;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

	public function parent_name()
	{
		$parent_product_category = $this->get_record(['record_id' => $this->parent_record_id]);
		
		if ($parent_product_category)
		{
			return $parent_product_category->name;
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

	public function products()
	{
		$this->load->model('product_model');

		return $this->product_model->get_records(['category_record_id' => $this->record_id]);
	}

	public function children()
	{
		return $this->get_records(['parent_record_id' => $this->record_id]);
	}
}

/* End of file Product_category_model.php */
/* Location: ./application/models/Product_category_model.php */