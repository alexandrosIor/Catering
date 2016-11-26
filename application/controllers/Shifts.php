<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Shifts extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->allow_access(['admin']);
	}
	
	public function index()
	{
		/* datatables plugin */
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables.min.css');
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables_themeroller.css');
		$this->layout_lib->add_additional_js('/assets/plugins/datatables/js/jquery.datatables.min.js');

		/* custom js */
		$this->layout_lib->add_additional_js('/assets/js/views/shifts.js');
		
		$this->view_data['page_title'] = 'Βάρδιες';

		$this->layout_lib->load('store_layout_view', 'store/shifts/shifts_view', $this->view_data);
	}

	/**
	 * This method load all shifts data to be used in a datatable
	 *
	 * @return json object
	 */
	public function datatable_shifts_data()
	{
		$this->load->model('shift_model');

		$data = array();

		$shifts = $this->shift_model->get_records();

		foreach ($shifts as $shift)
		{
			array_push($data, [
				0 => $shift->record_id,
				1 => $shift->time_zone_greece($shift->start_date),
				2 => $shift->time_zone_greece($shift->end_date),
				3 => $shift->user('name'),
				4 => $shift->user('role'),
				5 => count($shift->shift_orders()),
				6 => $shift->turnover_delivered,
				7 => $shift->turnover_calculated,
				8 => $shift->turnover_diff,
				9 => '<a href="/shifts/shift_details/' . $shift->record_id . '" class="view-order btn btn-success btn-block"><i class="fa fa-search fa-lg fa-fw"></i>Προβολή</a>',

			]);
		}

		$obj = (object) array();
		$obj->data = array_values($data);

		echo json_encode($obj);
	}

	/**
	 * This method load details view off a shifts
	 * 
	 * @param shift record id
	 * @return html content
	 */
	public function shift_details($shift_record_id = NULL)
	{
		$this->load->model('shift_model');

		/* datatables plugin */
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables.min.css');
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables_themeroller.css');
		$this->layout_lib->add_additional_js('/assets/plugins/datatables/js/jquery.datatables.min.js');

		/* custom js */
		$this->layout_lib->add_additional_js('/assets/js/views/shift_details.js');
		
		$shift = $this->shift_model->get_record(['record_id' => $shift_record_id]);
		$shift->shift_orders();

		$this->view_data['page_title'] = 'Παραγγελίες';
		$this->view_data['shift'] = $shift;

		$this->layout_lib->load('store_layout_view', 'store/shifts/shift_details_view', $this->view_data);
	}

	/**
	 * This method load all detailes of a shift to be used in a datatable
	 *
	 * @param shift record id
	 * @return json object
	 */
	public function datatable_shift_details_data($shift_record_id = NULL)
	{
		$this->load->model('order_model');

		$orders = $this->order_model->get_records(['shift_record_id' => $shift_record_id]);
		$data = array();

		foreach ($orders as $key => $order)
		{
			$order->store_table_info();

			//var_dump($order->store_table_info->caption);

			array_push($data, [
				0 => $key +1,
				1 => $order->store_table_info->caption,
				2 => $order->time_zone_greece($order->start_date),
				3 => $order->time_zone_greece($order->end_date),
				4 => $order->calculate_total_cost() . ' €',
				5 => '<a href="/orders/print_order_modal_form/' . $order->record_id . '" class="view-order btn btn-success btn-block" data-toggle="modal" data-target="#myModal"><i class="fa fa-search fa-lg fa-fw"></i>Προβολή</a>',
			]);
		}

		$obj = (object) array();
		$obj->data = array_values($data);

		echo json_encode($obj);
	}

}

/* End of file Shifts.php */
/* Location: ./application/controllers/Shifts.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/