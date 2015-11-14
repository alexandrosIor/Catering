<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Waiter extends MY_Controller {

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

		$this->layout_lib->load('waiter_layout_mobile_view', 'waiter/tables', $this->view_data);
	}

	public function orders($table_record_id)
	{
		$this->view_data['title'] = 'Παραγγελίες';
		$this->view_data['home'] = '/waiter';
		$this->view_data['table_record_id'] = $table_record_id;

		$this->layout_lib->load('waiter_layout_mobile_view', 'waiter/orders', $this->view_data);
	}
	
}

/* End of file Waiter.php */
/* Location: ./application/controllers/Waiter.php */