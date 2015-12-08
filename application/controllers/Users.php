<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		/* x-editable plugin */
		$this->layout_lib->add_additional_css('/assets/plugins/x-editable/bootstrap3-editable/css/bootstrap-editable.css');
		$this->layout_lib->add_additional_js('/assets/plugins/x-editable/bootstrap3-editable/js/bootstrap-editable.js');

		/* datatables plugin */
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables.min.css');
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables_themeroller.css');
		$this->layout_lib->add_additional_js('/assets/plugins/datatables/js/jquery.datatables.min.js');

		/* products_view custom javascript */
		$this->layout_lib->add_additional_js('/assets/js/views/users.js');

		$this->view_data['page_title'] = 'Χρήστες';

		$this->layout_lib->load('store_layout_view', 'store/users/users_view', $this->view_data);
	}	

	public function datatable_users_data()
	{
		$this->load->model('user_model');

		$data = array();

		$users = $this->user_model->get_all_records();

		foreach ($users as $user)
		{
			array_push($data, [
				0 => $user->record_id,
				1 => '<a href="javascript:void(0);" data-column_name="firstname">' . $user->firstname . '</a>',
				2 => '<a href="javascript:void(0);" data-column_name="lastname">' . $user->lastname . '</a>',
				3 => '<a href="javascript:void(0);" data-column_name="email" >' . $user->email . '</a>',
				4 => '<a href="javascript:void(0);" data-column_name="password">' . $user->password . '</a>',
				5 => '<a href="javascript:void(0);" data-column_name="role" class="role">' . $user->role . '</a>',
				6 => '<div class="ios-switch switch-md"><input type="checkbox" class="js-switch compact-menu-check"' . $user->status() . '></div>',
				7 => '<i class="fa fa-times fa-2x fa-fw text-danger delete-user"></i>',
			]);
		}

		$obj = (object) array();
		$obj->data = array_values($data);

		echo json_encode($obj);
	}	

	public function user_modal_form()
	{
		$this->load->model('user_model');

		$this->view_data['modal_title'] = 'Νέoς χρήστης';
		$this->view_data['user_roles'] = $this->user_model->get_user_roles();

		$this->layout_lib->load('store/users/user_modal_form', NULL, $this->view_data);
	}

	public function editable_user_roles_data()
	{
		$this->load->model('user_model');

		$data = array();

		$user_roles = $this->user_model->get_user_roles();

		foreach ($user_roles as $role)
		{
			array_push($data, [
				'value' => $role,
				'text' => $role,
			]);
		}

		echo json_encode($data);
	}

	public function update_user()
	{	
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('user_model');

			$post = $this->input->post();
			$user = $this->user_model->get_record(['record_id' => $post['pk']]);
			$user->set_properties([$post['name'] => $post['value']]);
			$user->save();
		}
	}

	public function ajax_change_status()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$post = $this->input->post();

				$this->load->model('user_model');
				
				$user = $this->user_model->get_record(['record_id' => $post['user_record_id']]);
			
			if ($post['status'] == 'checked')
			{
				$user->un_delete();
			}
			else
			{
				$user->soft_delete();
			}
		}
	}

	public function ajax_save_user()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('user_model');
			
			$post = $this->input->post();
			
			$user = new $this->user_model($post);
			if ($user->status)
			{
				unset($user->status);
				$user->save();
			}
			else
			{
				$user->save();
				$user->soft_delete();
			}
		}
	}

	public function ajax_delete_user()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('user_model');

			$post = $this->input->post();

			$user = $this->user_model->get_record(['record_id' => $post['user_record_id']]);
			
			$user->delete();	
		}
	}
	
}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */