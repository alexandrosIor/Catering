<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}

	/**
	 * This method loads catalogue view to create a new order
	 *
	 * @return waiter catalogue view , with available product categories
	 */
	public function new_order($table_record_id = NULL)
	{
		$this->load->model('product_category_model');

		$this->view_data['product_categories'] = $this->product_category_model->get_records(['parent_record_id' => 0]);

		$this->layout_lib->load('waiter/catalogue', NULL, $this->view_data);
	}

	/**
	 * This method insert a product to order_products table and creates a new order
	 *
	 * @return order_record_id
	 */
	public function ajax_add_product_for_order()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_model');
			$this->load->model('order_product_model');

			$post = $this->input->post();

			if (! $post['order_record_id'])
			{
				$post['order_record_id'] = $this->order_model->save_and_get_record_id();
			}

			$order_product =  new $this->order_product_model($post);

			$order_product->save();

			echo $order_product->order_record_id;
		}
	}
	
}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */