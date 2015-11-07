<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authenticate_lib {

	var $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->model('members_model');
	}

	public function login($username, $password)
	{
		if ($member = $this->ci->members_model->get_member_by_email_pass($username, $password))
		{
			unset($member['password']);
			$this->ci->session->set_userdata('logged_in', TRUE);
			$this->ci->session->set_userdata('member', $member);
			return TRUE;
		}
		return FALSE;
	}

	public function logout()
	{
		$this->ci->session->sess_destroy();
	}

}

/* End of file Authenticate_lib.php */
/* Location: ./application/libraries/Authenticate_lib.php */