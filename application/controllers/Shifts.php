<?php

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

	}

}

/* End of file Shifts.php */
/* Location: ./application/controllers/Shifts.php */