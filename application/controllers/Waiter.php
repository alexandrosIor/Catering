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
		//$this->layout_lib->add_additional_css('');
		//$this->layout_lib->add_additional_js('');

		$this->view_data['logged_in_member'] = unserialize($this->session->userdata('logged_in_member'));
		
		$this->layout_lib->load('waiter_layout_mobile_view', 'waiter/dashboard', $this->view_data);
	}
	
}

/* End of file Waiter.php */
/* Location: ./application/controllers/Waiter.php */