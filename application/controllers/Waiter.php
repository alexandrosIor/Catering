<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Waiter extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->helper('url');
		redirect('tables');
		//Θα υπάρξει αργότερα κάποιο είδος dashboard για τους σερβιτόρους
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