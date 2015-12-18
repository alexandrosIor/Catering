<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
class Product_model extends MY_Model
{
	protected $table_name = 'products';

	public $category_record_id;
	public $name;
	public $short_description;
	public $description;
	public $price;

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

}

/* End of file Product_model.php */
/* Location: ./application/models/Product_model.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/