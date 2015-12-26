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

		$this->view_data['page_title'] = 'Dashboard';
		$this->view_data['logged_in_user'] = $this->logged_in_user;

		$this->layout_lib->load('store_layout_view', 'store/dashboard', $this->view_data);
	}
	
}

/* End of file Store.php */
/* Location: ./application/controllers/Store.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/