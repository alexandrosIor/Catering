<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->allow_access(['admin', 'store']);
	}

	public function index()
	{
		$this->load->model('user_model');
		$this->load->model('order_model');
		$this->load->helper('my_helper');

		$this->layout_lib->add_additional_js('/assets/js/views/orders.js');

		$orders = $this->order_model->get_records(['end_date' => NULL]);
		usort($orders,function($a,$b){return $a->start_date > $b->start_date;});

		$datetime_now = new DateTime('NOW', new DateTimeZone('UTC'));
		
		foreach ($orders as $key => $order)
		{
			$order->store_table_info();
			$order->user_info();
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

		$this->view_data['page_title'] = 'Παραγγελίες';
		$this->view_data['orders'] = $orders;

		$this->layout_lib->load('store_layout_view', 'store/orders/orders_view', $this->view_data);
	}

	public function order_modal_form($order_record_id = NULL)
	{
		$this->view_data['modal_title'] = '#' . $order_record_id;
		$this->layout_lib->load('store/orders/order_modal_form', NULL, $this->view_data);
	}
	
}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/