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
			$this->load->library('authenticate');
			$this->authenticate->logout();

			$this->load->helper('url');
			redirect('login');
			return ;
		}

		$this->load->model('user_model');
		$this->logged_in_member = unserialize($this->session->userdata('logged_in_member'));
		$this->logged_in_member->build_member_acl();
		$this->view_data['logged_in_member'] = $this->logged_in_member;
		$this->view_data['selector_stores'] = $this->acl_lib->get_stores_for_selector($this->logged_in_member);

		// Set selected store
		if ($this->session->selected_store)
		{
			$this->selected_store = unserialize($this->session->selected_store);
			$this->view_data['selected_store'] = $this->selected_store;
		}
		else
		{
			$this->selected_store = NULL;
		}

		$this->view_data['css_includes'] = array();
		$this->view_data['js_includes'] = array();

		$this->include_common_assets();
		$this->generate_menu();
	}

	private function include_common_assets()
	{
		$this->layout_lib->add_additional_js('/assets/js/global.js');
	}

	private function generate_menu()
	{
		if ($this->session->userdata('logged_in') == TRUE)
		{
			$this->view_data['menu'] = array();

			$this->view_data['menu'][] = array('icon' => 'fa-flask', 'name' => 'Dashboard', 'link' => '/dashboard');
			
			if ($this->acl_lib->isAllowed($this->logged_in_member->role, 'manage_campaign'))
			{
				$this->view_data['menu'][] = array('icon' => 'fa-tags', 'name' => 'Κουπόνια', 'link' => '/coupons/campaigns');
			}
			
			$this->view_data['menu'][] = array('icon' => 'fa-area-chart', 'name' => 'Στατιστικά', 'link' => '#', 'submenu' => array(
				array('name' => 'Ταμείων', 'link' => '/statistics'),
				array('name' => 'Μελών', 'link' => '/statistics/members'),
			));

			if ($this->acl_lib->isAllowed($this->logged_in_member->role, 'manage_users'))
			{
				$this->view_data['menu'][] = array('icon' => 'fa-group', 'name' => 'Χρήστες', 'link' => '/users');
				$this->view_data['menu'][] = array('icon' => 'fa-university', 'name' => 'Καταστήματα', 'link' => '/stores');
			}

			if ($this->acl_lib->isAllowed($this->logged_in_member->role, 'manage_sms'))
			{
				$this->view_data['menu'][] = array('icon' => 'fa-send', 'name' => 'SMS', 'link' => '/sms/campaigns');
			}
		}
	}

}