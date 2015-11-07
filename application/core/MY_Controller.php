<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// νομιζω οτι ισος χρειαστει να εγκαταληψουμε την ιδεα να κανουμε layout δουλιες σε extension του
// Controler να για μπορουμε να εχουμε περισσοτερη ευεληξια στους Controlers. πχ ajax calls
class MY_Controller extends CI_Controller {

	public $view_data = array();

	public function __construct()
	{
		parent::__construct();

		$this->load->library('mini_stats_lib');
		$this->load->model('members_model');

		if (!$this->session->userdata('logged_in'))
		{
			$this->load->library('authenticate_lib');
			$this->authenticate_lib->logout();

			$this->load->helper('url');
			redirect('login');
			return ;
		}

		// ελεγχος αν ειναι cashier και η βάρδια που είναι ανοιχτή είναι δικιά του
		$member = $this->session->userdata('member');
		if ($member['role'] == 'cashier')
		{
			$this->load->model('cashier_sessions_model');
			$current_session = $this->cashier_sessions_model->get_current_open_session();
			if ($current_session['member_record_id'] != $member['record_id'])
			{
				$this->load->library('authenticate_lib');
				$this->authenticate_lib->logout();

				$this->load->helper('url');
				redirect('login');
				return ;
			}

			if ($sessions_with_empty_turnover = $this->cashier_sessions_model->get_sessions_with_empty_turnover())
			{
				foreach ($sessions_with_empty_turnover as $session)
				{
					$member = $this->members_model->get_member_with_photo($session['member_record_id']);
					$session['firstname'] = $member['firstname'];
					$session['lastname'] = $member['lastname'];
					$session['member_photo'] = $member['photo'];
					$session['start_date'] = new DateTime($session['start_date'], new DateTimeZone('UTC'));
					$session['start_date']->setTimezone(new DateTimeZone('Europe/Athens'));
					$session['start_date'] = $session['start_date']->format('d M H:i');

					$session['end_date'] = new DateTime($session['end_date'], new DateTimeZone('UTC'));
					$session['end_date']->setTimezone(new DateTimeZone('Europe/Athens'));
					$session['end_date'] = $session['end_date']->format('d M H:i');

					$this->view_data['messages'][] = $this->load->view('_ui_messages/empty_turnover.php', $session, TRUE);
				}
			}
		}

		$this->view_data['mini_stats'] = $this->mini_stats_lib->get_cached_mini_stats();
		$this->view_data['member'] = $this->session->userdata('member');
		$this->view_data['logged_in_member'] = $this->view_data['member'];
		$this->view_data['member']['photo'] = $this->members_model->get_member_photo($member['record_id']);

		$this->view_data['css_includes'] = array();
		$this->view_data['js_includes'] = array();

		$this->include_common_css();
		$this->include_common_js();
	}

	public function include_common_css()
	{
		$this->view_data['css_includes'][] = '/assets/css/bootstrap.min.css';
		$this->view_data['css_includes'][] = '/assets/font-awesome/css/font-awesome.css';
		$this->view_data['css_includes'][] = '/assets/css/animate.css';
		$this->view_data['css_includes'][] = '/assets/css/style.css';
	}

	public function include_css($css_file)
	{
		$this->view_data['css_includes'][] = $css_file;
	}

	public function empty_css_includes()
	{
		$this->view_data['css_includes'] = array();
	}

	public function include_common_js()
	{
		$this->view_data['js_includes'][] = '/assets/js/jquery-2.1.1.js';
		$this->view_data['js_includes'][] = '/assets/js/bootstrap.min.js';
		$this->view_data['js_includes'][] = '/assets/js/frappe.js';
		$this->layout_lib->add_additional_js('/assets/js/frappe.js');
	}

	public function include_js($js_file)
	{
		$this->view_data['js_includes'][] = $js_file;
	}

	public function empty_js_includes()
	{
		$this->view_data['js_includes'] = array();
	}

}