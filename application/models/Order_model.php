<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
class Order_model extends MY_Model
{
	protected $table_name = 'orders';

	public $store_table_record_id;
	public $user_record_id;
	public $shift_record_id;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

	public function store_table_info()
	{
		$this->load->model('store_table_model');

		$this->store_table_info = $this->store_table_model->get_record(['record_id' => $this->store_table_record_id]);
	}
	
}

/* End of file Order_model.php */
/* Location: ./application/models/Order_model.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/