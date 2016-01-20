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
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('shift_model');

			$post = $this->input->post();

			$shift = new $this->shift_model(['user_record_id' => $this->logged_in_user->record_id]);
			$shift->get_current_open_shift();
			$shift->calculate_turnover();
			$shift->turnover_delivered = floatval(str_replace(',', '.', $post['turnover_delivered']));
			$shift->close_shift();

			echo json_encode($shift);
		}
	}
	
}

/* End of file Logout.php */
/* Location: ./application/controllers/Logout.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/