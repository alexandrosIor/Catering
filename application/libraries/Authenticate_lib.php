<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authenticate_lib {

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->model('user_model');
	}

	public function login($username, $password)
	{
		if ($user = $this->ci->user_model->get_record(['email' => $username, 'password' => $password, 'deleted_at' => NULL]))
		{
			$this->ci->session->set_userdata('logged_in', TRUE);
			$this->ci->session->set_userdata('logged_in_member', serialize($user));

			if ($user->role == 'admin')
			{
				$location = '/store';
			}
			elseif ($user->role == 'store')
			{
				$location = '/store';
			}			
			elseif ($user->role == 'waiter')
			{
				$location = '/waiter';
			}

			return $location;
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