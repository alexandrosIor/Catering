<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->allow_access(['admin', 'store']);
	}

	/**
	 * This method loads the index page of the application 
	 *
	 * @return html content
	 */
	public function index()
	{
		$this->load->model('user_model');
		$this->load->model('shift_model');
		$this->load->helper('my_helper');

		/* products_view custom javascript */
		$this->layout_lib->add_additional_js('/assets/js/views/dashboard.js');

		$this->view_data['page_title'] = 'Dashboard';
		$this->view_data['logged_in_user'] = $this->logged_in_user;

		$active_shifts = $this->shift_model->get_records(['end_date' => NULL]);

		$current_paid = 0;
		$current_unpaid = 0;

		foreach ($active_shifts as &$shift)
		{
			$shift->shift_orders();

			$datatime_now = new DateTime('NOW', new DateTimeZone('UTC'));

			$shift->total_orders = count($shift->orders);
			$shift->unpaid_orders = 0;
			$shift->start_date = substr($shift->start_date, 11);
			$shift->time_worked = get_seconds_diff_from_dates($shift->start_date, $datatime_now->format('Y-m-d H:i:s'));

			foreach ($shift->orders as $key => $order)
			{
				if ($order->payment_status == 'unpaid' OR $order->payment_status == 'pending')
				{
					$shift->unpaid_orders++;
					$current_unpaid += $order->calculate_total_cost();
				}
				else
				{
					$current_paid += $order->calculate_total_cost();
				}
			}
			$shift->completed_orders = $shift->total_orders - $shift->unpaid_orders;
		}

		$this->view_data['active_shifts'] = $active_shifts;
		$this->view_data['current_paid'] = $current_paid;
		$this->view_data['current_unpaid'] = $current_unpaid;
		$this->view_data['current_total'] = $current_unpaid + $current_paid;

		$this->layout_lib->load('store_layout_view', 'store/dashboard', $this->view_data);
	}

	/**
	 * This method sends notification messages to users through websocket
	 *
	 */
	public function ajax_send_notification()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{	
			$post = $this->input->post();

			$this->load->library('websocket_messages_lib', ['user_record_id' => $post['user_record_id']]);

			try
			{
				$this->websocket_messages_lib->store_notify_waiter((object)$post);
			}
			catch(Exception $e)
			{
				//TODO: προς το παρον ignore...
			}	
		}
	}

	/**
	 * This method load all categories and there products as objects
	 * 
	 * @return html content with all fetched data
	 */
	public function ajax_load_catalogue()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{	
			$this->load->model('product_category_model');
			$this->load->model('store_table_model');
			$this->load->model('shift_model');
			$this->load->model('user_model');

			$categories = $this->product_category_model->get_records();
			$store_tables = $this->store_table_model->get_records();
			$waiter_shifts = $this->shift_model->get_records(['end_date' => NULL, 'role' => 'waiter']);
			$waiters = array();

			foreach ($waiter_shifts as $key => $shift)
			{
				$waiter = $this->user_model->get_record(['record_id' => $shift->user_record_id]);
				array_push($waiters, $waiter);
			}

			foreach ($categories as $key => $category)
			{
				$category->products = $category->products();
			}
			
			$this->view_data['categories'] = $categories;
			$this->view_data['store_tables'] = $store_tables;
			$this->view_data['active_waiters'] = $waiters;

			$this->layout_lib->load('store/new_order_view', NULL, $this->view_data);
		}
	}

	/**
	 * This method completes new order by adding the proper data to orders and order_products tables
	 * 
	 */
	public function ajax_complete_order()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{	
			$this->load->model('order_model');
			$this->load->model('order_product_model');
			$this->load->model('shift_model');

			$post = $this->input->post();
			
			$shift = $this->shift_model->get_record(['user_record_id' => $post['user_record_id'], 'end_date' => NULL]);

			$order = $this->order_model->get_record(['store_table_record_id' => $post['store_table_record_id'], 'payment_status' => 'pending']);

			if (!$order)
			{
				$order = new $this->order_model(['user_record_id' => $post['user_record_id'], 
													'store_table_record_id' => $post['store_table_record_id'], 
													'shift_record_id' => $shift->record_id,
													'payment_status' => 'pending'
												]);

				$datetime_now = new DateTime('NOW', new DateTimeZone('UTC'));
				$order->start_date = $datetime_now->format('Y-m-d H:i:s');

				$order->save();

				$order->store_table_info();
				$order->message = 'Σας προστέθηκε παραγγελία. <br>Tραπέζι: ' . $order->store_table_info->caption . '<br>Απο: ';
			}
			else
			{
				if ($order->end_date)
				{
					$order->end_date = NULL;
					$order->save();
				}
				$order->store_table_info();
				$order->message = 'Προστέθηκαν προϊόντα σε παραγγελία. <br>Tραπέζι: ' . $order->store_table_info->caption . '<br>Απο: ';
			}

			foreach ($post['order_product'] as $key => $values)
			{
				$values['order_record_id'] = $order->record_id;
				$order_product = new $this->order_product_model($values);
				$order_product->save();
			}

			$this->load->library('websocket_messages_lib', ['user_record_id' => $order->user_record_id]);
			$order->store_table_info();
			$logged_in_user = $this->view_data['logged_in_user'];
			$order->notification_sender = $logged_in_user->lastname . ' ' . $logged_in_user->firstname;
			$order->store_order = 1;

			try
			{
				$this->websocket_messages_lib->store_notify_waiter($order);
			}
			catch(Exception $e)
			{
				//TODO: προς το παρον ignore...
			}
		}
	}
	
}

/* End of file Store.php */
/* Location: ./application/controllers/Store.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/