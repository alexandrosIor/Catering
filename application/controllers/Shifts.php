<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Shifts extends MY_Controller {

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
				5 => $shift->total_orders(),
				6 => $shift->turnover_delivered,
				7 => $shift->turnover_calculated,
				8 => $shift->turnover_diff,
				9 => '<i class="fa fa-edit fa-2x fa-fw shift-details"></i>',
			]);
		}

		$obj = (object) array();
		$obj->data = array_values($data);

		echo json_encode($obj);
	}

	public function close_shift()
	{
		$this->load->model('shift_model');
		$this->load->library('authenticate_lib');

		$shift = new $this->shift_model(['user_record_id' => $this->logged_in_user->record_id]);

		$shift->get_current_open_shift();
		//αφου περαστουν ολα τα απαραιτητα data θα γινει το κλεισιμο (data: turnover delivered, turnover calculated)
		$shift->close_shift();

		$this->authenticate_lib->logout();
	}

}

/* End of file Shifts.php */
/* Location: ./application/controllers/Shifts.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/