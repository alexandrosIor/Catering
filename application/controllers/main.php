<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{

	public function index()
	{
		$this->load->helper('url');
	
		if ($this->session->userdata('logged_in') === TRUE)
		{
			$member = $this->session->userdata('member');
			if ($member['role'] == 'admin')
			{
				//redirect('/dashboard', 'location');
			}
			elseif ($member['role'] == 'store')
			{
				//redirect('/workstations', 'location');
			}			
			elseif ($member['role'] == 'waiter')
			{
				//redirect('/workstations', 'location');
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