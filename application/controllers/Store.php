<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('user_model');
		//$this->layout_lib->add_additional_css('');
		//$this->layout_lib->add_additional_js('');

		$this->view_data['logged_in_member'] = unserialize($this->session->userdata('logged_in_member'));
		
		$this->layout_lib->load('store_layout_view', 'store/dashboard', $this->view_data);
	}
	
}

/* End of file Store.php */
/* Location: ./application/controllers/Store.php */