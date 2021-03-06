<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class extends CI_Controller class and is used in our Controller classes for common tasks accross all application Controllers.
 */
class MY_Controller extends CI_Controller {

	public $view_data = array();

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('logged_in'))
		{
			$this->load->library('authenticate_lib');
			$this->authenticate_lib->logout();

			$this->load->helper('url');
			redirect('login');
			return ;
		}

		$this->load->helper('url');
		$this->load->model('user_model');

		$called_class = get_called_class();
		$this->logged_in_user = unserialize($this->session->userdata('logged_in_user'));
		
		if ($this->logged_in_user->role == 'waiter' AND $called_class == 'Store')
		{
			redirect('/waiter', 'location');
		}

		$this->view_data['logged_in_user'] = $this->logged_in_user;

		$this->view_data['css_includes'] = array();
		$this->view_data['js_includes'] = array();

		$this->include_common_assets();
		$this->generate_menu($this->view_data['logged_in_user']);
	}

	private function include_common_assets()
	{
		$this->layout_lib->add_additional_js('/assets/js/store_global.js');
	}

	private function generate_menu($user)
	{
		if ($this->session->userdata('logged_in') == TRUE)
		{
			$this->view_data['menu'] = array();
			if ($user->role == 'waiter')
			{
				$this->view_data['menu'][] = array('icon' => 'fa fa-th-large fa-fw', 'name' => 'τραπέζια', 'link' => '/store_tables');
				$this->view_data['menu'][] = array('icon' => 'fa fa-plus fa-fw', 'name' => 'νέα παραγγελία', 'link' => '/orders/new_order/');
				$this->view_data['menu'][] = array('icon' => 'fa fa-book', 'name' => 'μενού', 'link' => '#');
				$this->view_data['menu'][] = array('icon' => 'fa fa-bell-o fa-fw', 'name' => 'ειδοποιήσεις', 'link' => '#');
			}
			else
			{
				$this->view_data['menu'][] = array('icon' => 'fa fa-home', 'name' => 'Dashboard', 'link' => '/store');
				
				$this->view_data['menu'][] = array('icon' => 'fa fa-pencil-square-o', 'name' => 'Παραγγελίες', 'link' => '/orders');

				if ($user->role == 'admin')
				{
					$this->view_data['menu'][] = array('icon' => 'fa fa-th-large', 'name' => 'Τραπέζια', 'link' => '/store_tables');
					$this->view_data['menu'][] = array('icon' => 'fa fa-list', 'name' => 'Κατάλογος', 'link' => '#', 'submenu' => array(
						array('name' => 'Κατηγορίες', 'link' => '/catalogue/product_categories'),
						array('name' => 'Προϊόντα', 'link' => '/catalogue/products'),
					));
					$this->view_data['menu'][] = array('icon' => 'fa fa-users', 'name' => 'Χρήστες', 'link' => '/users');
					$this->view_data['menu'][] = array('icon' => 'fa fa-history', 'name' => 'Βάρδιες', 'link' => '/shifts');
				}
			}
		}
	}

	public function allow_access($roles = [])
	{
		$allow_access = FALSE;
		foreach ($roles as $role) 
		{
			if ($this->logged_in_user->role == $role)
			{
				$allow_access = TRUE;
			}
		}

		if (!$allow_access)
		{
			redirect('/login', 'location');
		}
	}

}