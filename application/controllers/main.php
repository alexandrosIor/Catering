<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
class Main extends CI_Controller
{

	public function index()
	{
		$this->load->helper('url');
	
		if ($this->session->userdata('logged_in') === TRUE)
		{
			$this->load->model('user_model');
			$logged_in_user = unserialize($this->session->userdata('logged_in_user'));

			if ($logged_in_user->role == 'admin')
			{
				redirect('/store', 'location');
			}
			elseif ($logged_in_user->role == 'store')
			{
				redirect('/store', 'location');
			}			
			elseif ($logged_in_user->role == 'waiter')
			{
				redirect('/waiter', 'location');
			}
		}
		else
		{
			redirect('/login', 'location');
		}
	}

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/