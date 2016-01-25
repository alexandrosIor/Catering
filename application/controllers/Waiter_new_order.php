<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Waiter_new_order extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->allow_access(['waiter']);
	}

	/**
	 * This method loads catalogue view to create a new order
	 * @param table_record_id integer
	 * @return waiter catalogue view , with available product categories
	 */
	public function index($table_record_id = NULL)
	{
		$this->load->model('product_category_model');

		$this->view_data['product_categories'] = $this->product_category_model->get_records(['parent_record_id' => 0]);

		$this->layout_lib->load('waiter/catalogue', NULL, $this->view_data);
	}

	/**
	 * This method insert a product to order_products table and creates a new order
	 * if product already exist in current order then just update the quantity
	 *
	 * @return order_record_id
	 */
	public function ajax_add_product_for_order()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('shift_model');
			$this->load->model('order_model');
			$this->load->model('order_product_model');

			$post = $this->input->post();


			if (! $post['order_record_id'])
			{
				$user = $this->view_data['logged_in_user'];
				$shift = $this->shift_model->get_record(['user_record_id' => $user->record_id, 'end_date' => NULL]);
				$order = new $this->order_model(['user_record_id' => $user->record_id, 'shift_record_id' => $shift->record_id]);
				
				$post['order_record_id'] = $order->save_and_get_record_id();
			}

			$order_product = $this->order_product_model->get_record(['product_record_id' => $post['product_record_id'],'order_record_id' => $post['order_record_id']]);
			
			if ($order_product)
			{
				$order_product->quantity += $post['quantity'];
			}
			else
			{
				$order_product =  new $this->order_product_model($post);
			}

			$order_product->save();

			echo $order_product->order_record_id;
		}
	}

	/**
	 * This method fetches from database all products of a specific order
	 *
	 * @return array of order_product objects
	 */
	public function ajax_order_products()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_product_model');
			$this->load->model('order_model');

			$post = $this->input->post();

			$order_total_price = 0;
			if ($post['order_record_id'])
			{
				$order = $this->order_model->get_record(['record_id' => $post['order_record_id']]);
				$order->store_table_info();
				$order->order_products();

				foreach ($order->order_products as &$order_product)
				{
					$order_product->product_info();
					$order_total_price = $order_total_price + ($order_product->product_info->price * $order_product->quantity);
				}

				$this->view_data['table'] = $order->store_table_info;
				$this->view_data['order_total_price'] = $order_total_price;
				$this->view_data['order_products'] = $order->order_products;
			}

			$this->layout_lib->load('waiter/order_products_view',NULL , $this->view_data);
		}
	}

	/**
	 * This method removes a product from current order
	 */
	public function ajax_delete_order_product()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_product_model');
			$this->load->model('order_model');
			$this->load->model('shift_model');

			$store_shift = $this->shift_model->get_record(['role' => 'store', 'end_date' => NULL]);

			if ($store_shift)
			{
				/* Send the message to the open store shift */
				$this->load->library('websocket_messages_lib', ['user_record_id' => $store_shift->user_record_id]);
			}
			else
			{
				/* If there is no open store shift then send the message on admin socket channel*/
				$this->load->library('websocket_messages_lib', ['user_record_id' => 1]);
			}

			$post = $this->input->post();

			$order_product = $this->order_product_model->get_record(['record_id' => $post['order_product_record_id']]);
			$order_product->product_info();
			$order = $this->order_model->get_record(['record_id' => $order_product->order_record_id]);
			$order->store_table_info();
			$order->user_info();
			$order->message = 'Τραπέζι: ' . $order->store_table_info->caption . '<br/>' . 'Αφαιρέθηκε το προϊόν: ' . $order_product->product_info->name . '<br/> Από: ' . $order->user_info->lastname . ' ' . $order->user_info->firstname;
			$order_product->delete();

			if ($order->start_date)
			{
				try
				{
					$this->websocket_messages_lib->waiter_order_updated($order);

					if ($order->all_order_products_completed())
					{
						$datetime_now = new DateTime('NOW', new DateTimeZone('UTC'));
						$order->end_date = $datetime_now->format('Y-m-d H:i:s');
						$order->message = 'Τραπέζι: ' . $order->store_table_info->caption . '<br/>' . 'Η παραγγελία ολοκληρώθηκε';

						$this->websocket_messages_lib->waiter_order_served($order);
						$this->websocket_messages_lib->waiter_order_updated($order);

						unset($order->message, $order->order_products, $order->store_table_info, $order->user_info);

						$order->save();
					}
				}
				catch(Exception $e)
				{
					//TODO: προς το παρον ignore...
				}
			}
		}
	}

	/**
	 * This method saves the selected table in current order
	 */
	public function ajax_save_order_table()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('store_table_model');
			$this->load->model('order_model');

			$post = $this->input->post();

			$order_table = $this->store_table_model->get_record(['caption' => $post['order_table_caption']]);

			$order = $this->order_model->get_record(['record_id' => $post['order_record_id']]);
			$order->store_table_record_id = $order_table->record_id;
			$order->save();
		}
	}

	/**
	 * This method updates order product info
	 */
	public function ajax_update_order_product()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_product_model');
			$this->load->model('order_model');
			$this->load->model('shift_model');

			$store_shift = $this->shift_model->get_record(['role' => 'store', 'end_date' => NULL]);

			if ($store_shift)
			{
				/* Send the message to the open store shift */
				$this->load->library('websocket_messages_lib', ['user_record_id' => $store_shift->user_record_id]);
			}
			else
			{
				/* If there is no open store shift then send the message on admin socket channel*/
				$this->load->library('websocket_messages_lib', ['user_record_id' => 1]);
			}

			$post = $this->input->post();

			$order_product = $this->order_product_model->get_record(['record_id' => $post['order_product_record_id']]);
			$order = $this->order_model->get_record(['record_id' => $order_product->order_record_id]);
			$order->store_table_info();
			$order->user_info();

			if ($order->start_date)
			{
				if ($post['quantity'])
				{
					$order_product->product_info();
					$order->message = 'Τραπέζι: ' . $order->store_table_info->caption . '<br/>' . 'Προϊόν: ' . $order_product->product_info->name . '<br/> <strong>Ενημερώθηκε η ποσότητα</strong> <br/> Παλιά ποσότητα: ' . $order_product->quantity . '<br/> Νέα ποσότητα: ' . $post['quantity'];
				}
				if ($post['comments'])
				{
					$order_product->product_info();
					$order->message = 'Τραπέζι: ' . $order->store_table_info->caption . '<br/>' . 'Προϊόν: ' . $order_product->product_info->name . '<br/> <strong>Ενημερώθηκαν τα σχόλια: </strong> <br/>' . $post['comments'];
				}

				try
				{
					$order->calculate_total_cost();
					$this->websocket_messages_lib->waiter_order_updated($order);
				}
				catch(Exception $e)
				{
					//TODO: προς το παρον ignore...
				}
			}
			
			unset($post['order_product_record_id'], $order_product->product_info);
			$order_product->set_properties($post);

			$order_product->save();
		}
	}	

	/**
	 * This method completes order by setting start date and payment status
	 */
	public function ajax_complete_order()
	{
		if ($this->input->is_ajax_request() AND $this->input->method() == 'post')
		{
			$this->load->model('order_model'); 
			$this->load->model('shift_model');

			$store_shift = $this->shift_model->get_record(['role' => 'store', 'end_date' => NULL]);

			if ($store_shift)
			{
				/* Send the message to the open store shift */
				$this->load->library('websocket_messages_lib', ['user_record_id' => $store_shift->user_record_id]);
			}
			else
			{
				/* If there is no open store shift then send the message on admin socket channel*/
				$this->load->library('websocket_messages_lib', ['user_record_id' => 1]);
			}

			$post = $this->input->post();

			$order = $this->order_model->get_record(['record_id' => $post['order_record_id']]);

			$open_order = $this->order_model->get_record(['store_table_record_id' => $order->store_table_record_id, 'payment_status' => 'pending']);

			if($open_order)
			{
				$order->order_products();

				foreach ($order->order_products as $key => $product)
				{
					$product->order_record_id = $open_order->record_id;
					$product->save();	
				}

				if ($open_order->end_date)
				{
					$open_order->end_date = NULL;
				}
				$open_order->save();

				try
				{
					$open_order->store_table_info();
					$open_order->user_info();
					$open_order->calculate_total_cost();
					$open_order->message = 'Tραπεζι: ' . $open_order->store_table_info->caption . '<br/>Προστέθηκαν προϊόντα<br/>Από: ' . $open_order->user_info->lastname . ' ' . $order->user_info->firstname;
					$this->websocket_messages_lib->waiter_order_updated($open_order);
				}
				catch(Exception $e)
				{
					//TODO: προς το παρον ignore...
				}
				$order->delete();
			}
			else
			{
				$datetime_now = new DateTime('NOW', new DateTimeZone('UTC'));
				$order->set_properties(['start_date' => $datetime_now->format('Y-m-d H:i:s'), 'payment_status' => 'pending']);
				$order->save();

				try
				{
					$order->store_table_info();
					$order->user_info();
					$order->message = 'Τραπέζι: ' . $order->store_table_info->caption . '<br/>Από: ' . $order->user_info->lastname . ' ' . $order->user_info->firstname;
					$this->websocket_messages_lib->waiter_send_new_order_to_store($order);
				}
				catch(Exception $e)
				{
					//TODO: προς το παρον ignore...
				}
			}	
		}
	}

	/**
	 * This method fetches store tables from database
	 *
	 * @return an a json object containing tables captions
	 */
	public function ajax_get_tables_for_waiter()
	{
		$this->load->model('store_table_model');

		$tables = $this->store_table_model->get_records();
		$data = array();

		foreach ($tables as $table)
		{
			array_push($data, $table->caption);
		}
		
		$obj = (object) array();
		$obj = array_values($data);

		echo json_encode($obj);
	}
	
}

/* End of file Orders.php */
/* Location: ./application/controllers/Orders.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/