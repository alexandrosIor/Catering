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

		$this->layout_lib->add_additional_js('/assets/js/waiter_mobile_views/product_categories.js');

		$table = $this->table_model->get_record(['record_id' => $table_record_id]);

		$this->view_data['title'] = $table->caption;
		$this->view_data['table'] = $table;
		$this->view_data['home'] = '/waiter';  //rename to caller
		$this->view_data['categories'] = $this->product_category_model->get_records(['parent_record_id' => 0]);

		$this->layout_lib->load('waiter_layout_mobile_view', 'waiter/orders/product_categories_view', $this->view_data);
	}

	public function product_category_prodducts($product_category_record_id)
	{
		$this->load->model('product_category_model');
		$this->load->model('product_model');

		$this->layout_lib->add_additional_js('/assets/js/waiter_mobile_views/products.js');

		$products_category = $this->product_category_model->get_record(['record_id' => $product_category_record_id]);

		$this->view_data['title'] = $products_category->name;
		$this->view_data['home'] = '/orders/new_order'; //rename to caller
		$this->view_data['products'] = $this->product_model->get_records(['category_record_id' => $products_category->record_id]);

		$this->layout_lib->load('waiter_layout_mobile_view', 'waiter/orders/products_view', $this->view_data);
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

	public function ajax_add_product_modal()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('product_model');
			
			$post = $this->input->post();

			$this->view_data['product'] = $this->product_model->get_record(['record_id' => $post['product_record_id']]);	

			$this->load->view('waiter/orders/add_product_modal', $this->view_data);
		}
	}
	
}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */