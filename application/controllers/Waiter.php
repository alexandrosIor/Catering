<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Waiter extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->tables();
	}
	public function tables()
	{
		$this->load->model('user_model');
		$this->load->model('table_model');

		$this->view_data['logged_in_member'] = unserialize($this->session->userdata('logged_in_member'));
		$this->view_data['title'] = 'Τραπέζια';
		$this->view_data['tables'] = $this->table_model->get_records();

		$this->layout_lib->load('waiter_layout_mobile_view', 'waiter/tables_view', $this->view_data);
	}

	public function ajax_settings_modal()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$post = $this->input->post();
			$this->load->view('waiter/settings_modal', $this->view_data);
		}
	}
	
}

/* End of file Waiter.php */
/* Location: ./application/controllers/Waiter.php */