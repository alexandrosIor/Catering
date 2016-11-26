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

	/**
	 * This method load the index page of orders where a the user can see all current orders
	 *
	 * @return html content
	 */
	public function index()
	{
		//$this->load->model('user_model');
		$this->load->model('order_model');
		$this->load->helper('my_helper');

		/* datatables plugin */
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables.min.css');
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables_themeroller.css');
		$this->layout_lib->add_additional_js('/assets/plugins/datatables/js/jquery.datatables.min.js');

		$this->layout_lib->add_additional_js('/assets/js/views/orders.js');

		$orders = $this->order_model->get_records(['start_date IS NOT' => NULL, 'end_date' => NULL]);
		usort($orders,function($a,$b){return $a->record_id > $b->record_id;});

		$datetime_now = new DateTime('NOW', new DateTimeZone('UTC'));
		
		foreach ($orders as $key => $order)
		{
			$order->store_table_info();
			$order->user_info();
			$order->order_products();
			$order->calculate_total_cost();
			
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

	/**
	 * This method launches a modal with all order details
	 *
	 * @param order record id
	 * @return html content
	 */
	public function order_modal_form($order_record_id = NULL)
	{
		$this->load->model('order_product_model');

		$order_products = $this->order_product_model->get_all_records(['order_record_id' => $order_record_id]);
		$order_products_categorized = [];
		foreach ($order_products as $key => $order_product)
		{
			$order_product->product_info();
			$order_products_categorized[$order_product->product_info->category_name()][] = $order_product;
		}

		$this->view_data['modal_title'] = '#' . $order_record_id;
		$this->view_data['order_products'] = $order_products;
		$this->view_data['order_products_categorized'] = $order_products_categorized;

		$this->layout_lib->load('store/orders/order_modal_form', NULL, $this->view_data);
	}

	/**
	 * This method changes the status of an order_product by adding and removing a deteled_at date
	 *
	 */
	public function ajax_change_order_product_status()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_product_model');
			$this->load->model('order_model');
			
			$post = $this->input->post();

			$order_product = $this->order_product_model->get_record(['record_id' => $post['order_product_record_id']]);
			$order_product->product_info();
			$order = $this->order_model->get_record(['record_id' => $order_product->order_record_id]);
			$order->store_table_info();

			$this->load->library('websocket_messages_lib', ['user_record_id' => $order->user_record_id]);

			if ($order_product->deleted_at)
			{
				$order_product->un_delete();
				$order_product->message = '<i class="f7-icons sm color-danger">close</i> ' . $order->store_table_info->caption . ' | ' . $order_product->product_info->name;
			}
			else
			{
				$order_product->soft_delete();
				$order_product->message = '<i class="f7-icons sm color-success">check</i> ' . $order->store_table_info->caption . ' | ' . $order_product->product_info->name;
			}

			if ($order->all_order_products_completed())
			{
				$order_product->order_completed = TRUE;
			}

			$this->websocket_messages_lib->store_update_order($order_product);
		}
	}

	/**
	 * This creates the needed data structure for an order and then loads the data to a specific view 
	 *
	 * @return html content
	 */
	public function ajax_create_new_order_panel()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_model');
			$this->load->helper('my_helper');
			
			$post = $this->input->post();
			$order = new $this->order_model($post);
			$datetime_now = new DateTime('NOW', new DateTimeZone('UTC'));

			$order->store_table_info();
			$order->user_info();
			$order->order_products();
			$order->calculate_total_cost();
			$order->elapsed_time = 0;

			$this->view_data['order'] = $order;

			$this->layout_lib->load('store/orders/order_panel_view', NULL, $this->view_data);
		}
	}

	/**
	 * This method fetches and prepairs the unpaid orders data
	 * The data is to be shown in datatable
	 *
	 * @return json encoded object of arrays
	 */
	public function datatable_unpaid_orders_data()
	{
		$this->load->model('order_model');
		$this->load->helper('my_helper');

		$data = array();

		$orders = $this->order_model->get_all_records(['end_date IS NOT' => NULL, 'payment_status' => 'pending']);

		foreach ($orders as $order)
		{
			$order->store_table_info();
			$order->user_info();

			$diff = get_seconds_diff_from_dates($order->start_date, $order->end_date);

			array_push($data, [
				0 => $order->record_id,
				1 => $order->store_table_info->caption,
				2 => $order->user_info->lastname . ' ' .$order->user_info->firstname,
				3 => $order->time_zone_greece($order->start_date, 'H:i:s'),
				4 => $order->time_zone_greece($order->end_date, 'H:i:s'),
				5 => seconds_to_time($diff),
				6 => $order->calculate_total_cost() . ' €',
				7 => '<a href="/orders/print_order_modal_form/' . $order->record_id . '" class="view-order btn btn-success btn-block" data-toggle="modal" data-target="#myModal"><i class="fa fa-print fa-fw fa-lg"></i>Εκτύπωση</a>',
			]);
		}

		/* Create an object of arrays */
		$obj = (object) array();
		$obj->data = array_values($data);

		echo json_encode($obj);
	}

	/**
	 * This method fetches and prepairs the data for the completed orders
	 * The data is to be shown in datatable
	 *
	 * @return json encoded object of arrays
	 */
	public function datatable_completed_orders_data()
	{
		$this->load->model('order_model');
		$this->load->helper('my_helper');

		$data = array();

		$orders = $this->order_model->get_all_records(['end_date IS NOT' => NULL, 'payment_status' => 'paid']);

		foreach ($orders as $order)
		{
			$order->store_table_info();
			$order->user_info();

			$diff = get_seconds_diff_from_dates($order->start_date, $order->end_date);

			array_push($data, [
				0 => $order->record_id,
				1 => $order->store_table_info->caption,
				2 => $order->user_info->lastname . ' ' .$order->user_info->firstname,
				3 => $order->time_zone_greece($order->start_date, 'H:i:s'),
				4 => $order->time_zone_greece($order->end_date, 'H:i:s'),
				5 => seconds_to_time($diff),
				6 => $order->calculate_total_cost(),
				7 => '<a href="/orders/print_order_modal_form/' . $order->record_id . '" class="view-order btn btn-success btn-block" data-toggle="modal" data-target="#myModal"><i class="fa fa-print fa-fw fa-lg"></i>Εκτύπωση</a>',
			]);
		}

		/* Create an object of arrays */
		$obj = (object) array();
		$obj->data = array_values($data);

		echo json_encode($obj);
	}	

	/**
	 * This method fetches an order and adds all data in a table for printing
	 *
	 * @param order record id
	 * @return html content
	 */
	public function print_order_modal_form($order_record_id = NULL)
	{
		$this->load->model('order_model');

		$order = $this->order_model->get_record(['record_id' => $order_record_id]);

		$order->order_products();
		$order->store_table_info();
		$order->user_info();
		$order->calculate_total_cost();

		foreach ($order->order_products as &$product)
		{
			$product->product_info();
		}

		$this->view_data['order'] = $order;
		$this->view_data['modal_title'] = 'Εκτύπωση παραγγελίας';

		$this->layout_lib->load('store/orders/print_order_modal_form', NULL, $this->view_data);
	}

}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/