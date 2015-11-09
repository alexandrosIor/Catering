<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authenticate {

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->model('user_model');
	}

	public function login($username, $password)
	{
		if ($user = $this->ci->user_model->get_record(['email' => $username, 'password' => $password]))
		{
			$this->ci->session->set_userdata('logged_in', TRUE);
			$this->ci->session->set_userdata('logged_in_member', serialize($user));
			return TRUE;
		}
		return FALSE;
	}

	public function logout()
	{
		$this->ci->session->sess_destroy();
	}

}

/* End of file Authenticate.php */
/* Location: ./application/libraries/Authenticate.php */