<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tables extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('user_model');
		$this->load->model('table_model');

		$this->view_data['logged_in_member'] = unserialize($this->session->userdata('logged_in_member'));
		$this->view_data['title'] = 'Τραπέζια';
		$this->view_data['tables'] = $this->table_model->get_records();

		$this->load->view('waiter_layout_mobile_view', $this->view_data);
	}

	public function table_orders($table_record_id = NULL)
	{
		$this->load->model('table_model');
		$this->load->model('order_model');

		$table = $this->table_model->get_record(['record_id' => $table_record_id]);
		$this->view_data['home'] = '/tables';
		$this->view_data['title'] = $table->caption;
		$this->view_data['table'] = $table;
		//$this->view_data['orders'] = $this->order_model->get_records(['table_record_id' => $table->record_id]);

		$this->layout_lib->load('waiter_layout_mobile_view', 'waiter/orders/orders_view', $this->view_data);
	}
	
}

/* End of file Tables.php */
/* Location: ./application/controllers/Tables.php */