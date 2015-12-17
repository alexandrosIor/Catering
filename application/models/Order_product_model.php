<?php

class Order_product_model extends MY_Model
{
	protected $table_name = 'order_products';

	public $order_record_id;
	public $product_record_id;
	public $quantity;
	public $comments;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

	public function product_info()
	{
		$this->load->model('product_model');

		$this->product_info = $this->product_model->get_record(['record_id' => $this->product_record_id]);
	}

}

/* End of file Order_product_model.php */
/* Location: ./application/models/Order_product_model.php */