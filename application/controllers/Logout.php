<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends MY_Controller {

	public function index()
	{	
		$this->load->library('authenticate_lib');
		
		$this->authenticate_lib->logout();
	}

	public function close_shift()
	{
		$this->load->model('shift_model');
		$this->load->library('authenticate_lib');

		$shift = new $this->shift_model(['user_record_id' => $this->logged_in_user->record_id]);

		$shift->get_current_open_shift();
		
		//αφου περαστουν ολα τα απαραιτητα data θα γινει το κλεισιμο (data: turnover delivered, turnover calculated)
		$shift->close_shift();

		$this->authenticate_lib->logout();
	}

}

/* End of file Logout.php */
/* Location: ./application/controllers/Logout.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/