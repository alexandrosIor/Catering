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

		$this->view_data['product_categories'] = $this->product_category_model->get_records(['parent_record_id' => 0]);

		$this->load->view('waiter/catalogue', $this->view_data);
	}
	
}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */