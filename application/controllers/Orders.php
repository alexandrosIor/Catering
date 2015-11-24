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

	public function new_order()
	{
		$this->load->model('table_model');

		$this->view_data['home'] = '/waiter';
		$this->view_data['store_tables'] = $this->table_model->get_records();

		$this->layout_lib->load('waiter_layout_mobile_view', 'waiter/orders/new_order_view', $this->view_data);
	}

	public function table_orders($table_record_id = NULL)
	{
		$this->view_data['title'] = $table_record_id;
		$this->view_data['home'] = '/waiter';

		$this->view_data['table_record_id'] = $table_record_id;
		$this->view_data['order_record_id'] = 10;

		$this->layout_lib->load('waiter_layout_mobile_view', 'waiter/orders/orders_view', $this->view_data);
	}

	public function ajax_order_details()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$post = $this->input->post();
			$this->load->view('waiter/orders/order_modal_form', $this->view_data);
		}
	}

	public function ajax_popover_table_select()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'get')
		{
			$this->load->model('table_model');

			$this->view_data['store_tables'] = $this->table_model->get_records();
			$this->load->view('waiter/orders/popover_table_select', $this->view_data);
		}
	}
	
}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */