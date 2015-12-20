<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Waiter extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->allow_access(['waiter']);
	}

	public function index()
	{
		$this->load->view('waiter_layout_mobile_view', $this->view_data);
	}
	
}

/* End of file Waiter.php */
/* Location: ./application/controllers/Waiter.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/