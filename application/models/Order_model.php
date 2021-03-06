<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
class Order_model extends MY_Model
{
	protected $table_name = 'orders';

	public $store_table_record_id;
	public $user_record_id;
	public $shift_record_id;
	public $start_date;
	public $end_date;
	public $payment_status;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

	public function store_table_info()
	{
		$this->load->model('store_table_model');

		$this->store_table_info = $this->store_table_model->get_record(['record_id' => $this->store_table_record_id]);
	}	

	public function order_products()
	{
		$this->load->model('order_product_model');

		$this->order_products = $this->order_product_model->get_all_records(['order_record_id' => $this->record_id]);
	}	

	public function user_info()
	{
		$this->load->model('user_model');

		$this->user_info = $this->user_model->get_record(['record_id' => $this->user_record_id]);
	}

	public function calculate_total_cost()
	{
		$this->order_products();
		$this->total_price = 0;
		foreach ($this->order_products as $order_product)
		{
			$order_product->product_info();
			$this->total_price = $this->total_price + ($order_product->product_info->price * $order_product->quantity);
		}

		return $this->total_price;
	}

	public function all_order_products_completed()
	{
		$this->order_products();
		$served = TRUE;

		foreach ($this->order_products as $order_product)
		{
			if (!$order_product->deleted_at)
			{
				$served = FALSE;
			}
		}

		return $served;
	}

	public function order_paid()
	{
		$this->payment_status = 'paid';
		
		$this->save();
	}	

	public function order_unpaid()
	{
		$this->payment_status = 'pending';
		
		$this->save();
	}
	
}

/* End of file Order_model.php */
/* Location: ./application/models/Order_model.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/