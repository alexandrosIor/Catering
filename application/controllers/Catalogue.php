<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Catalogue extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->allow_access(['admin']);
	}

	public function index()
	{
		$this->products();
	}

	/**
	 * This method loads product categories page
	 *
	 * @return html content
	 */
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

	/**
	 * This method loads products page
	 *
	 * @return html content
	 */
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

	/**
	 * This method loads the add new product modal form
	 *
	 * @return html content
	 */
	public function product_modal_form()
	{
		$this->load->model('product_category_model');

		$this->view_data['modal_title'] = 'Νέο προϊόν';
		$this->view_data['product_categories'] = $this->product_category_model->get_records();

		$this->layout_lib->load('store/catalogue/product_modal_form', NULL, $this->view_data);
	}	
	
	/**
	 * This method loads the add new product category modal form
	 *
	 * @return html content
	 */
	public function product_category_modal_form()
	{
		$this->load->model('product_category_model');

		$this->view_data['modal_title'] = 'Νέα κατηγορία';
		$this->view_data['product_categories'] = $this->product_category_model->get_records();

		$this->layout_lib->load('store/catalogue/product_category_modal_form', NULL, $this->view_data);
	}

	/**
	 * This method saves to database the new created product category
	 *
	 * @return html content
	 */
	public function ajax_save_product_category()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('product_category_model');
			
			$post = $this->input->post();
			
			$category = new $this->product_category_model($post);
			if ($category->status)
			{
				unset($category->status);
				$category->save();
			}
			else
			{
				$category->save();
				$category->soft_delete();
			}
		}
	}

	/**
	 * This method saves to database the new created product
	 *
	 * @return html content
	 */
	public function ajax_save_product()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('product_model');
			
			$post = $this->input->post();
			
			$product = new $this->product_model($post);
			if ($product->status)
			{
				unset($product->status);
				$product->save();
			}
			else
			{
				$product->save();
				$product->soft_delete();
			}
		}
	}

	/**
	 * This method loads all available product categories from database
	 *
	 * @return json object
	 */
	public function datatable_product_categories_data()
	{
		$this->load->model('product_category_model');

		$data = array();

		$product_categories = $this->product_category_model->get_all_records();

		foreach ($product_categories as $product_category)
		{
			array_push($data, [
				0 => $product_category->record_id,
				1 => '<a href="javascript:void(0);" data-column_name="name">' . $product_category->name . '</a>',
				2 => '<a href="javascript:void(0);" data-column_name="description">' . $product_category->description . '</a>',
				3 => '<a href="javascript:void(0);" data-column_name="parent_record_id" class="category">' . $product_category->parent_name() . '</a>',
				4 => '<div class="ios-switch switch-md"><input type="checkbox" class="js-switch compact-menu-check"' . $product_category->status() . '></div>',
				5 => '<i class="fa fa-times fa-2x fa-fw text-danger delete-product-category"></i>',
			]);
		}

		$obj = (object) array();
		$obj->data = array_values($data);

		echo json_encode($obj);
	}	

	/**
	 * This method loads all available products from database
	 *
	 * @return json object
	 */
	public function datatable_products_data()
	{
		$this->load->model('product_model');

		$data = array();

		$products = $this->product_model->get_all_records();

		foreach ($products as $product)
		{
			array_push($data, [
				0 => $product->record_id,
				1 => '<a href="javascript:void(0);" data-column_name="name">' . $product->name . '</a>',
				2 => '<a href="javascript:void(0);" data-column_name="short_description">' . $product->short_description . '</a>',
				3 => '<a href="javascript:void(0);" data-column_name="description">' . $product->description . '</a>',
				4 => '<a href="javascript:void(0);" data-column_name="category_record_id" class="category">' . $product->category_name() . '</a>',
				5 => '<a href="javascript:void(0);" data-column_name="price">' . $product->price . '</a>',
				6 => '<div class="ios-switch switch-md"><input type="checkbox" class="js-switch compact-menu-check"' . $product->status() . '></div>',
				7 => '<i class="fa fa-times fa-2x fa-fw text-danger delete-product"></i>',
			]);
		}

		$obj = (object) array();
		$obj->data = array_values($data);

		echo json_encode($obj);
	}	

	/**
	 * This method loads product categories for an editable select element
	 *
	 * @return json object
	 */
	public function editable_product_categories_data()
	{
		$this->load->model('product_category_model');

		$data = array();
		array_push($data, ['value' => 0, 'text' => ' ']);

		$product_categories = $this->product_category_model->get_records();

		foreach ($product_categories as $product_category)
		{
			array_push($data, [
				'value' => $product_category->record_id,
				'text' => $product_category->name,
			]);
		}

		echo json_encode($data);
	}

	/**
	 * This method updates edited product category
	 *
	 */
	public function update_product_category()
	{
		$this->load->model('product_category_model');

		$post = $this->input->post();
		$product_category = $this->product_category_model->get_record(['record_id' => $post['pk']]);
		$product_category->set_properties([$post['name'] => $post['value']]);
		$product_category->save();
	}	

	/**
	 * This method updates edited product
	 *
	 */
	public function update_product()
	{
		$this->load->model('product_model');

		$post = $this->input->post();
		$product = $this->product_model->get_record(['record_id' => $post['pk']]);
		$product->set_properties([$post['name'] => $post['value']]);
		
		($product->price) ? $product->price = str_replace(',', '.', $product->price) : '';

		$product->save();
	}

	/**
	 * This method updates the status of either a product or a product category
	 *
	 */
	public function ajax_change_status()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$post = $this->input->post();

			if (isset($post['product_category_record_id']))
			{
				$this->load->model('product_category_model');
				
				$item = $this->product_category_model->get_record(['record_id' => $post['product_category_record_id']]);
			}
			else
			{
				$this->load->model('product_model');
				
				$item = $this->product_model->get_record(['record_id' => $post['product_record_id']]);
			}
			
			if ($post['status'] == 'checked')
			{
				$item->un_delete();
			}
			else
			{
				$item->soft_delete();
			}
		}
	}	

	/**
	 * This method deletes permanently from database the given product category
	 *
	 */
	public function ajax_delete_product_category()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('product_category_model');

			$post = $this->input->post();

			$product_category = $this->product_category_model->get_record(['record_id' => $post['product_category_record_id']]);
			
			$product_category->delete();	
		}
	}	

	/**
	 * This method deletes permanently from database the given product
	 *
	 */
	public function ajax_delete_product()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('product_model');

			$post = $this->input->post();

			$product = $this->product_model->get_record(['record_id' => $post['product_record_id']]);
			
			$product->delete();	
		}
	}
	
}

/* End of file Catalogue.php */
/* Location: ./application/controllers/Catalogue.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/