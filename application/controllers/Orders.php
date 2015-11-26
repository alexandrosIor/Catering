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

	public function new_order($table_record_id = NULL)
	{
		$this->load->model('product_category_model');
		$this->load->model('table_model');

		$this->layout_lib->add_additional_js('/assets/js/waiter_mobile_views/new_order.js');

		$table = $this->table_model->get_record(['record_id' => $table_record_id]);

		$this->view_data['title'] = $table->caption;
		$this->view_data['table'] = $table;
		$this->view_data['home'] = '/waiter';
		$this->view_data['categories'] = $this->product_category_model->get_records(['parent_record_id' => 0]);

		$this->layout_lib->load('waiter_layout_mobile_view', 'waiter/orders/new_order_view', $this->view_data);
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

	public function ajax_products_modal()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('product_model');
			
			$post = $this->input->post();

			$this->view_data['products'] = $this->product_model->get_records(['category_record_id' => $post['product_category_record_id']]);	

			$this->load->view('waiter/orders/products_modal', $this->view_data);
		}
	}
	
}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */