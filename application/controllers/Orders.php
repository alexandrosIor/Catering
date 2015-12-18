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
				$user = $this->view_data['logged_in_user'];
				$order = new $this->order_model(['user_record_id' => $user->record_id]);
				
				$post['order_record_id'] = $order->save_and_get_record_id();
			}

			$order_product =  new $this->order_product_model($post);

			$order_product->save();

			echo $order_product->order_record_id;
		}
	}

	/**
	 * This method fetches from database all products of a specific order
	 *
	 * @return array of order_product objects
	 */
	public function ajax_order_products()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_product_model');

			$post = $this->input->post();

			$order_total_price = 0;
			if ($post['order_record_id'])
			{
				$order_products = $this->order_product_model->get_records(['order_record_id' => $post['order_record_id']]);

				foreach ($order_products as &$order_product)
				{
					$order_product->product_info();
					$order_total_price = $order_total_price + ($order_product->product_info->price * $order_product->quantity);
				}

				$this->view_data['order_total_price'] = $order_total_price;
				$this->view_data['order_products'] = $order_products;
			}

			$this->layout_lib->load('waiter/order_products_view',NULL , $this->view_data);
		}
	}

	/**
	 * This method removes a product from current order
	 *
	 */
	public function ajax_delete_order_product()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_product_model');

			$post = $this->input->post();

			$order_product = new $this->order_product_model(['record_id' => $post['order_product_record_id']]);

			$order_product->delete();
		}
	}

	/**
	 * This method saves the selected table in current order
	 *
	 */
	public function ajax_save_order_table()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('store_table_model');
			$this->load->model('order_model');

			$post = $this->input->post();

			$order_table = $this->store_table_model->get_record(['caption' => $post['order_table_caption']]);

			$order = $this->order_model->get_record(['record_id' => $post['order_record_id']]);
			$order->table_record_id = $order_table->record_id;
			$order->save();
		}
	}

	/**
	 * This method updates order product quantity
	 *
	 */
	public function ajax_update_order_product_quantity()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_product_model');

			$post = $this->input->post();

			$order_product = $this->order_product_model->get_record(['record_id' => $post['order_product_record_id']]);
			$order_product->quantity = $post['quantity'];

			$order_product->save();
		}
	}
	
}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */