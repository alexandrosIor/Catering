<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class extends CI_Model class and is used in our Model classes for common tasks accross all application models.
 */
class MY_Model extends CI_Model {

	/** @var string Contains current model table name. This variable is set on our models that extend this class, so this class knows witch table is working on. */
	public $table_name;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * This method decides whether to insert or update given record.
	 *
	 * @param array $record Record to be saved. array key names must match database table columns
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function save($record)
	{
		if (isset($record['record_id']) AND (int)$record['record_id']>0)
		{
			$result = $this->update($record);
		}
		else
		{
			$result = $this->insert($record);
		}
		return $result;
	}

	public function save_and_get_record_id($record)
	{
		if (isset($record['record_id']) AND (int)$record['record_id']>0)
		{
			$this->update($record);
			$result = $record['record_id'];
		}
		else
		{
			$this->insert($record);
			$result = $this->db->insert_id();
		}
		return $result;
	}

	/**
	 * This method inserts a new record to the database. converting empty strings to NULL to save space on the database.
	 *
	 * @param array $record Record to be saved. array key names must match database table columns
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function insert($record)
	{
		/* set zero length values to NULL */
		$record = array_map(function($v) { return strlen($v)==0 ? NULL : $v; }, $record);

		$datetime_now = new DateTime('now', new DateTimeZone('UTC'));
		$record['insert_at'] = $datetime_now->format('Y-m-d H:i:s');
		$record['update_at'] = $datetime_now->format('Y-m-d H:i:s');

		return $this->db->insert($this->table_name, $record);
	}

	/**
	 * This method updates a new record to the database based on it's record_id. converting empty strings to NULL to save space on the database.
	 *
	 * @param array $record Record to be updated. array key names must match database table columns, and must contain record_id
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function update($record)
	{
		/* set zero length values to NULL */
		$record = array_map(function($v) { return strlen($v)==0 ? NULL : $v; }, $record);

		$datetime_now = new DateTime('now', new DateTimeZone('UTC'));
		$record['update_at'] = $datetime_now->format('Y-m-d H:i:s');

		return $this->db->update($this->table_name, $record, array('record_id'=>$record['record_id']));
	}


	/**
	 * This method deletes a record from the database based on it's record id.
	 *
	 * @param array $record Record to be deleted. This array must contain record_id.
	 *
	 * @return boolean TRUE on success, FALSE on failure.
	 */
	public function delete($record)
	{
		return $this->db->delete($this->table_name, array('record_id'=>$record['record_id']));
	}


	/**
	 * This function add's date in daleted_at field of row so we consider it as deleted.
	 * This virtual delete method keeps the row for historical purposes or not to brake application consistency
	 *
	 * @param array $record Record to be soft deleted. This array must contain record_id.
	 *
	 * @return void
	 */
	public function soft_delete($record)
	{
		$datetime_now = new DateTime('now', new DateTimeZone('UTC'));
		$record['deleted_at'] = $datetime_now->format('Y-m-d H:i:s');

		$this->db->update($this->table_name, $record, array('record_id'=>$record['record_id']));
	}

	/**
	 * This function restoring specified record in loaded model's table.
	 *
	 * @param array $record Record to be un_deleted. This array must contain record_id.
	 *
	 * @return void
	 */
	public function un_delete($record)
	{
		$record['deleted_at'] = NULL;
		$this->db->update($this->table_name, $record, array('record_id'=>$record['record_id']));
	}

	/**
	 * This function returns specified row from loaded model's table.
	 *
	 * @param int $record_id Record id from our auto increment record_id column.
	 *
	 * @return array|boolean Database row as array or FALSE if record not found.
	 */
	public function get_record($record_id)
	{
		$query = $this->db->get_where($this->table_name, array('record_id' => $record_id));
		if ($query->num_rows() == 1)
		{
			return $query->row_array();
		}
		return FALSE;
	}

	/**
	 * This function returns all records from loaded model's table
	 *
	 * @return array
	 */
	public function get_records($where = array())
	{
		$where = array_merge($where, ['deleted_at' => NULL]);
		return $this->db->get_where($this->table_name, $where)->result_array();
	}

	public function get_records_with_deleted($where = array())
	{
		return $this->db->get_where($this->table_name, $where)->result_array();
	}

	public function is_unique($record, $column)
	{
		if (isset($record['record_id']) AND (int)$record['record_id']>0)
		{
			$this->db->where('record_id !=', (int)$record['record_id']);
		}
		$this->db->where($column, $record[$column]);

		return $this->db->count_all_results($this->table_name) ? FALSE : TRUE;
	}

}