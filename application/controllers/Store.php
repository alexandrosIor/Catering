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
					$current_unpaid = $order->calculate_total_cost();
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
	
}

/* End of file Store.php */
/* Location: ./application/controllers/Store.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/