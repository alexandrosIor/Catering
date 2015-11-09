<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('login_view');
	}

	public function check()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$post = $this->input->post();

			$response = array();

			if (strlen($post['username']) > 0  AND strlen($post['password']) > 0)
			{
				$this->load->library('authenticate_lib');
				if ($this->authenticate_lib->login($post['username'], $post['password']))
				{
					$member = $this->session->userdata('member');
					if ($member['role'] == 'cashier')
					{
						$this->load->model('cashier_sessions_model');
						if ($session = $this->cashier_sessions_model->get_current_open_session())
						{
							if ($session['member_record_id'] == $member['record_id'])
							{
								// είναι cashier και η ανοιχτή βάρδια είναι δική του
								$response['login_result'] = TRUE;
								$response['redirect'] = '/workstations/dashboard';
								echo json_encode($response);
								return ;
							}
							else
							{
								// είναι cashier και η ανοιχτή βάρδια δεν είναι δική του
								$this->load->model('members_model');
								$cashier = $this->members_model->get_record($session['member_record_id']);
								$this->authenticate_lib->logout();
								$response['login_result'] = FALSE;
								$response['message'] = 'Yπαρχει βαρδια ανοιχτή απο: ' . $cashier['lastname'] . ' ' . $cashier['firstname'];
								echo json_encode($response);
								return ;
							}
						}
						else
						{
							// είναι cashier και δεν υπάρχει καμία ανοιχτη βάρδια
							$response['login_result'] = TRUE;
							$response['ask_create_session'] = TRUE;
							echo json_encode($response);
							return ;
						}
					}
					else if ($member['role'] == 'admin')
					{
						// είναι admin
						$response['login_result'] = TRUE;
						$response['redirect'] = '/dashboard';
						echo json_encode($response);
						return ;
					}
					else
					{
						// δεν είναι admin ή cashier
						$this->authenticate_lib->logout();
						$response['login_result'] = FALSE;
						$response['message'] = 'δεν εχετε διακαιώματα εισόδου';
						echo json_encode($response);
						return ;
					}
				}
				else
				{
					$response['login_result'] = FALSE;
					$response['message'] = 'λανθασμενα στοιχεία εισόδου';
					echo json_encode($response);
					return ;
				}
			}
			else
			{
				$response['login_result'] = FALSE;
				$response['message'] = 'συμπληρώστε ονομα χρήστη και κωδικό';
				echo json_encode($response);
				return ;
			}
		}
	}

	public function open_new_cashier_session()
	{
		$this->load->library('mini_stats_lib');
		$this->load->model('cashier_sessions_model');

		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$member = $this->session->userdata('member');
			$current_open_session = $this->cashier_sessions_model->get_current_open_session();
			if ($member AND !$current_open_session)
			{
				if ($this->cashier_sessions_model->create_new_session($member['record_id']))
				{
					$this->mini_stats_lib->set_mini_stat('cashier', $member['lastname']." ".$member['firstname']);
					$this->mini_stats_lib->send_interface_message();
				}
			}
		}
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */