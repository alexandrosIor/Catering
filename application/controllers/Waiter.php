<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Waiter extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->allow_access(['waiter']);
	}

	/**
	 * This method loads waiter mobile layout index page
	 *
	 */
	public function index()
	{
		$this->load->model('order_model');
		$this->load->helper('my_helper');

		$this->layout_lib->add_additional_js('/assets/js/socket.js');
		$this->layout_lib->add_additional_js('/assets/js/waiter_mobile_views/dashboard.js');

		$this->load->view('waiter_layout_mobile_view', $this->view_data);
	}

	/**
	 * This method fetches all order of a specific user
	 *
	 */
	public function ajax_load_orders()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_model');
			$this->load->helper('my_helper');
			
			$user = $this->view_data['logged_in_user'];

			$orders = $this->order_model->get_records(['start_date IS NOT' => NULL, 'end_date' => NULL, 'user_record_id' => $user->record_id]);
			usort($orders,function($a,$b){return $a->record_id > $b->record_id;});

			$datetime_now = new DateTime('NOW', new DateTimeZone('UTC'));
			
			foreach ($orders as $key => $order)
			{
				$order->store_table_info();
				$order->user_info = $user;
				$order->order_products();
				$order->total_price = 0;

				/* Calculate order total price */
				foreach ($order->order_products as $order_product)
				{
					$order_product->product_info();
					$order->total_price = $order->total_price + ($order_product->product_info->price * $order_product->quantity);
				}
				
				/* Calculate elapsed time from order start date */
				$order_start_date = new DateTime($order->start_date, new DateTimeZone('UTC'));
				$diff = $order_start_date->diff($datetime_now);
				$elapsed_days = $diff->format('%a');
				$elapsed_hours = ($elapsed_days * 24) + $diff->format('%H');
				$order->elapsed_time = time_to_seconds($diff->format($elapsed_hours . ':%I:%S'));
			}

			$this->view_data['orders'] = $orders;

			$this->layout_lib->load('waiter/order_chip_view', NULL, $this->view_data);
		}
	}

	/**
	 * This method fetches a specific order from database
	 *
	 */
	public function ajax_get_order()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_model');

			$post = $this->input->post();
			$order_total_price = 0;

			$order = $this->order_model->get_record(['record_id' => $post['order_record_id']]);
			$order->store_table_info();
			$order->order_products();

			foreach ($order->order_products as &$order_product)
			{
				$order_product->product_info();
				$order_total_price = $order_total_price + ($order_product->product_info->price * $order_product->quantity);
			}

			$this->view_data['table'] = $order->store_table_info;
			$this->view_data['order_total_price'] = $order_total_price;
			$this->view_data['order_products'] = $order->order_products;

			$this->layout_lib->load('waiter/incomplete_order_products_view',NULL , $this->view_data);
		}
	}
	
}

/* End of file Waiter.php */
/* Location: ./application/controllers/Waiter.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/