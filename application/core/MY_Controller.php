<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// νομιζω οτι ισος χρειαστει να εγκαταληψουμε την ιδεα να κανουμε layout δουλιες σε extension του
// Controler να για μπορουμε να εχουμε περισσοτερη ευεληξια στους Controlers. πχ ajax calls
class MY_Controller extends CI_Controller {

	public $view_data = array();

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('logged_in'))
		{
			$this->load->library('authenticate_lib');
			$this->authenticate->logout();

			$this->load->helper('url');
			redirect('login');
			return ;
		}

		$this->load->helper('url');
		$this->load->model('user_model');

		$called_class = get_called_class();
		$this->logged_in_member = unserialize($this->session->userdata('logged_in_member'));
		
		if ($this->logged_in_member->role == 'waiter' AND $called_class == 'Store')
		{
			redirect('/waiter', 'location');
		}

		$this->view_data['logged_in_member'] = $this->logged_in_member;

		$this->view_data['css_includes'] = array();
		$this->view_data['js_includes'] = array();

		$this->include_common_assets();
		$this->generate_menu($this->view_data['logged_in_member']);
	}

	private function include_common_assets()
	{
		$this->layout_lib->add_additional_js('/assets/js/global.js');
	}

	private function generate_menu($member)
	{
		if ($this->session->userdata('logged_in') == TRUE)
		{
			$this->view_data['menu'] = array();

			$this->view_data['menu'][] = array('icon' => 'glyphicon-home', 'name' => 'Dashboard', 'link' => '/store');
			
			$this->view_data['menu'][] = array('icon' => 'glyphicon-edit', 'name' => 'Παραγγελίες', 'link' => '#');

			if ($member->role == 'admin')
			{
				$this->view_data['menu'][] = array('icon' => 'glyphicon-user', 'name' => 'Χρήστες', 'link' => '#', 'submenu' => array(
					array('name' => 'menu 1', 'link' => '#'),
					array('name' => 'menu 2', 'link' => '#'),
				));
			}
		}
	}

}