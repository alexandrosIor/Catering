<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogue extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		/* nestable plugin */
		$this->layout_lib->add_additional_css('/assets/plugins/nestable/nestable.css');
		$this->layout_lib->add_additional_js('/assets/plugins/nestable/jquery.nestable.js');

		/* catalogue_view custom javascript */
		$this->layout_lib->add_additional_js('/assets/js/views/catalogue.js');

		$this->view_data['page_title'] = 'Κατάλογος';

		$this->layout_lib->load('store_layout_view', 'store/catalogue/catalogue_view', $this->view_data);
	}

	public function product_categories()
	{
		/* x-editable plugin */
		$this->layout_lib->add_additional_css('/assets/plugins/x-editable/bootstrap3-editable/css/bootstrap-editable.css');
		$this->layout_lib->add_additional_js('/assets/plugins/x-editable/bootstrap3-editable/js/bootstrap-editable.js');

		/* datatables plugin */
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables.min.css');
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables_themeroller.css');
		$this->layout_lib->add_additional_js('/assets/plugins/datatables/js/jquery.datatables.min.js');

		/* products_view custom javascript */
		$this->layout_lib->add_additional_js('/assets/js/views/product_categories.js');
		$this->view_data['page_title'] = 'Κατηγορίες';
		$this->layout_lib->load('store_layout_view', 'store/catalogue/product_categories_view', $this->view_data);
	}	

	public function products()
	{
		/* x-editable plugin */
		$this->layout_lib->add_additional_css('/assets/plugins/x-editable/bootstrap3-editable/css/bootstrap-editable.css');
		$this->layout_lib->add_additional_js('/assets/plugins/x-editable/bootstrap3-editable/js/bootstrap-editable.js');

		/* datatables plugin */
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables.min.css');
		$this->layout_lib->add_additional_css('/assets/plugins/datatables/css/jquery.datatables_themeroller.css');
		$this->layout_lib->add_additional_js('/assets/plugins/datatables/js/jquery.datatables.min.js');

		/* products_view custom javascript */
		$this->layout_lib->add_additional_js('/assets/js/views/products.js');

		$this->view_data['page_title'] = 'Προϊόντα';
		$this->layout_lib->load('store_layout_view', 'store/catalogue/products_view', $this->view_data);
	}

	public function product_modal_form()
	{
		$this->view_data['modal_title'] = 'Νέο προϊόν';
		$this->layout_lib->load('store/catalogue/product_modal_form', NULL, $this->view_data);
	}	
	
	public function product_category_modal_form()
	{
		$this->view_data['modal_title'] = 'Νέα κατηγορία';
		$this->layout_lib->load('store/catalogue/product_category_modal_form', NULL, $this->view_data);
	}
	
}

/* End of file Catalogue.php */
/* Location: ./application/controllers/Catalogue.php */