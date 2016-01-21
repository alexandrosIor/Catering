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
		$this->load->model('shift_model');
		$this->load->helper('my_helper');

		$this->layout_lib->add_additional_js('/assets/js/socket.js');
		$this->layout_lib->add_additional_js('/assets/js/waiter_mobile_views/dashboard.js');

		$user = $this->view_data['logged_in_user'];

		$shift = $this->shift_model->get_record(['user_record_id' => $user->record_id, 'end_date' => NULL]);
		$shift->shift_orders();

		$datatime_now = new DateTime('NOW', new DateTimeZone('UTC'));

		$this->view_data['total_orders'] = count($shift->orders);
		$this->view_data['unpaid_orders'] = 0;
		$this->view_data['start_date'] = substr($shift->start_date, 11);
		$this->view_data['time_worked'] = get_seconds_diff_from_dates($shift->start_date, $datatime_now->format('Y-m-d H:i:s'));

		foreach ($shift->orders as $key => $order)
		{
			if ($order->payment_status == 'unpaid' OR $order->payment_status == 'pending')
			{
				$this->view_data['unpaid_orders']++; 
			}
		}

		$this->load->view('waiter_layout_mobile_view', $this->view_data);
	}

	/**
	 * This method fetches all order of a specific user
	 *
	 */
	public function ajax_load_incomplete_orders()
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
				$order->calculate_total_cost();
				
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
	 * This method fetches all order of a specific user
	 *
	 */
	public function ajax_load_unpaid_orders()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_model');
			$this->load->helper('my_helper');
			
			$user = $this->view_data['logged_in_user'];

			$orders = $this->order_model->get_records(['end_date IS NOT' => NULL, 'payment_status' => 'pending', 'user_record_id' => $user->record_id]);
			usort($orders,function($a,$b){return $a->record_id > $b->record_id;});

			$datetime_now = new DateTime('NOW', new DateTimeZone('UTC'));
			
			foreach ($orders as $key => $order)
			{
				$order->calculate_total_cost();
				if ($order->total_price)
				{
					$order->store_table_info();
					$order->user_info = $user;
					$order->order_products();

					/* Calculate elapsed time from order start date */
					$order_start_date = new DateTime($order->start_date, new DateTimeZone('UTC'));
					$diff = $order_start_date->diff($datetime_now);
					$elapsed_days = $diff->format('%a');
					$elapsed_hours = ($elapsed_days * 24) + $diff->format('%H');
					$order->elapsed_time = time_to_seconds($diff->format($elapsed_hours . ':%I:%S'));
				}
				else
				{
					$order->payment_status = 'deleted';
					unset($order->total_price, $order->order_products);
					$order->save();
					unset($orders[$key]);
				}
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

			$order = $this->order_model->get_record(['record_id' => $post['order_record_id']]);
			$order->store_table_info();
			$order->order_products();
			$order->calculate_total_cost();

			$this->view_data['order'] = $order;
			$this->view_data['order_products'] = $order->order_products;

			$this->layout_lib->load('waiter/incomplete_order_products_view', NULL, $this->view_data);
		}
	}

	/**
	 * This method add end_date to order so it is considered served
	 *
	 */
	public function ajax_order_served()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_model');
			$this->load->model('shift_model');

			$store_shift = $this->shift_model->get_record(['role' => 'store', 'end_date' => NULL]);

			if ($store_shift)
			{
				/* Send the message to the open store shift */
				$this->load->library('websocket_messages_lib', ['user_record_id' => $store_shift->user_record_id]);
			}
			else
			{
				/* If there is no open store shift then send the message on admin socket channel*/
				$this->load->library('websocket_messages_lib', ['user_record_id' => 1]);
			}

			$post = $this->input->post();
			$datetime_now = new DateTime('NOW', new DateTimeZone('UTC'));

			$order = $this->order_model->get_record(['record_id' => $post['order_record_id']]);
			$order->end_date = $datetime_now->format('Y-m-d H:i:s');

			$order->save();
			try
			{
				$this->websocket_messages_lib->waiter_order_served($order);
			}
			catch(Exception $e)
			{
				//TODO: προς το παρον ignore...
			}
		}
	}

	/**
	 * This method changes product status to served or unserved
	 *
	 */
	public function ajax_order_product_status()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_product_model');
			$this->load->model('order_model');
			$this->load->model('shift_model');

			$store_shift = $this->shift_model->get_record(['role' => 'store', 'end_date' => NULL]);

			if ($store_shift)
			{
				/* Send the message to the open store shift */
				$this->load->library('websocket_messages_lib', ['user_record_id' => $store_shift->user_record_id]);
			}
			else
			{
				/* If there is no open store shift then send the message on admin socket channel*/
				$this->load->library('websocket_messages_lib', ['user_record_id' => 1]);
			}

			$post = $this->input->post();

			$order_product = $this->order_product_model->get_record(['record_id' => $post['order_product_record_id']]);
			$order_product->product_info();

			$order = $this->order_model->get_record(['record_id' => $order_product->order_record_id]);
			$order->user_info();
			$order->store_table_info();

			if ($post['status'] == 'served')
			{
				$order_product->soft_delete();
				$order->message = 'Τραπέζι: ' . $order->store_table_info->caption . '<br/>' . 'Σερβιρίστηκε το προϊόν: ' . $order_product->product_info->name . '<br/>Από: ' . $order->user_info->lastname . ' '  . $order->user_info->firstname;

			}
			if ($post['status'] == 'unserved')
			{
				$order_product->un_delete();
				$order->message = 'Τραπέζι: ' . $order->store_table_info->caption . '<br/>' . 'Προς υλοποίηση προϊόν: ' . $order_product->product_info->name . '<br/>Από: ' . $order->user_info->lastname . ' '  . $order->user_info->firstname;
			}

			try
			{
				$this->websocket_messages_lib->waiter_order_updated($order);
			}
			catch(Exception $e)
			{
				//TODO: προς το παρον ignore...
			}

			$order_completed = TRUE;
			$order->order_products();
			foreach ($order->order_products as $product)
			{
				if (is_null($product->deleted_at))
				{
					$order_completed = 2;
				}
			}
			
			echo $order_completed;
		}
	}

	/**
	 * This method fetches and calculates waiters shift info
	 *
	 * @return json object containing shift information
	 */
	public function ajax_shift_info()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_model');
			$this->load->model('shift_model');
			$this->load->helper('my_helper');

			$user = $this->view_data['logged_in_user'];

			$shift = $this->shift_model->get_record(['user_record_id' => $user->record_id, 'end_date' => NULL]);
			$shift->shift_orders();

			$datatime_now = new DateTime('NOW', new DateTimeZone('UTC'));

			$info['total_orders'] = count($shift->orders);
			$info['unpaid_orders'] = 0;
			$info['time_worked'] = get_seconds_diff_from_dates($shift->start_date, $datatime_now->format('Y-m-d H:i:s'));

			foreach ($shift->orders as $key => $order)
			{
				if ($order->payment_status == 'unpaid' OR $order->payment_status == 'pending')
				{
					$info['unpaid_orders']++; 
				}
			}

			echo json_encode($info);
		}
	}
	
}

/* End of file Waiter.php */
/* Location: ./application/controllers/Waiter.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/