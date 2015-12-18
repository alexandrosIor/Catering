<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{	
		$this->load->library('authenticate_lib');
		
		$this->authenticate_lib->logout();
	}
}

/* End of file Logout.php */
/* Location: ./application/controllers/Logout.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/