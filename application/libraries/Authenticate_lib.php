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
			$this->ci->session->set_userdata('logged_in_user', serialize($user));

			if ($user->role == 'admin')
			{
				return $location = '/store';
			}		
			elseif ($user->role == 'waiter' OR $user->role == 'store')
			{
				$this->ci->load->model('shift_model');
				
				$shift = new $this->ci->shift_model;
				$shift->user_record_id = $user->record_id;

				($user->role == 'waiter') ? $location = '/waiter' : $location = '/store';
				
				if ($shift->get_current_open_shift())
				{
					return $location;
				}
				else
				{
					$shift->create_new_shift();

					return $location;
				}
			}
		}
		return FALSE;
	}

	public function logout()
	{
		$this->ci->load->helper('url');
		
		$this->ci->session->sess_destroy();

		redirect('/login', 'location');
	}

}

/* End of file Authenticate_lib.php */
/* Location: ./application/libraries/Authenticate_lib.php */