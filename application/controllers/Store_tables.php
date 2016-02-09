<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_tables extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->allow_access(['admin']);
	}

	/**
	 * This method load store tables page to manage tables units
	 *
	 * @return html content
	 */
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
		$this->layout_lib->add_additional_js('/assets/js/views/store_tables.js');

		$this->view_data['page_title'] = 'Τραπέζια';

		$this->layout_lib->load('store_layout_view', 'store/store_tables/store_tables_view', $this->view_data);
	}

	/**
	 * This method load store table data to be used in a datatable
	 *
	 * @return json object
	 */
	public function datatable_store_tables_data()
	{
		$this->load->model('store_table_model');

		$data = array();

		$store_tables = $this->store_table_model->get_all_records();

		foreach ($store_tables as $store_table)
		{
			array_push($data, [
				0 => $store_table->record_id,
				1 => '<a href="javascript:void(0);" data-column_name="caption">' . $store_table->caption . '</a>',
				2 => '<a href="javascript:void(0);" data-column_name="seats">' . $store_table->seats . '</a>',
				3 =>  ($store_table->in_use) ? '<i class="fa fa-circle text-danger fa-lg"></i>' : '<i class="fa fa-circle text-success fa-lg"></i>',
				4 => '<div class="ios-switch switch-md"><input type="checkbox" class="js-switch compact-menu-check"' . $store_table->status() . '></div>',
				5 => '<i class="fa fa-times fa-2x fa-fw text-danger delete-store-table"></i>',
			]);
		}

		
		$obj = (object) array();
		$obj->data = array_values($data);

		echo json_encode($obj);
	}

	/**
	 * This method load a modal form to add new store table
	 *
	 * @return html content
	 */
	public function store_table_modal_form()
	{
		$this->load->model('store_table_model');

		$this->view_data['modal_title'] = 'Νέo τραπέζι';

		$this->layout_lib->load('store/store_tables/store_table_modal_form', NULL, $this->view_data);
	}

	/**
	 * This updates store table info
	 *
	 */
	public function update_store_table()
	{	
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('store_table_model');

			$post = $this->input->post();
			$store_table = $this->store_table_model->get_record(['record_id' => $post['pk']]);
			$store_table->set_properties([$post['name'] => $post['value']]);
			$store_table->save();
		}
	}

	/**
	 * This method changes the status of a store table
	 *
	 */
	public function ajax_change_status()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$post = $this->input->post();

			$this->load->model('store_table_model');
			
			$store_table = $this->store_table_model->get_record(['record_id' => $post['store_table_record_id']]);
			$store_table->in_use = 0;
			
			if ($post['status'] == 'checked')
			{
				$store_table->set_properties(['in_use' => 0]);
				$store_table->un_delete();
			}
			else
			{
				$store_table->soft_delete();
			}
		}
	}

	/**
	 * This method saves new store table
	 *
	 */
	public function ajax_save_store_table()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('store_table_model');
			
			$post = $this->input->post();
			$post['in_use'] = 0;
			$store_table = new $this->store_table_model($post);
			if ($store_table->status)
			{
				unset($store_table->status);
				$store_table->save();
			}
			else
			{
				$store_table->save();
				$store_table->soft_delete();
			}
		}
	}

	/**
	 * This method deleted permanently a store table
	 *
	 * @return html content
	 */
	public function ajax_delete_store_table()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('store_table_model');

			$post = $this->input->post();

			$store_table = $this->store_table_model->get_record(['record_id' => $post['store_table_record_id']]);
			
			$store_table->delete();	
		}
	}

}

/* End of file Store_tables.php */
/* Location: ./application/controllers/Store_tables.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/