<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
class Store_table_model extends MY_Model
{
	protected $table_name = 'store_tables';

	public $caption;
	public $seats;
	public $in_use;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

}

/* End of file Table_model.php */
/* Location: ./application/models/Table_model.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/