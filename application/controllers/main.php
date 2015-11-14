<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

	public function index()
	{
		$this->load->helper('url');
	
		if ($this->session->userdata('logged_in') === TRUE)
		{
			$this->load->model('user_model');
			$logged_in_member = unserialize($this->session->userdata('logged_in_member'));

			if ($logged_in_member->role == 'admin')
			{
				redirect('/store', 'location');
			}
			elseif ($logged_in_member->role == 'store')
			{
				redirect('/store', 'location');
			}			
			elseif ($logged_in_member->role == 'waiter')
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