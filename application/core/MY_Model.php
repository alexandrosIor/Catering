<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class extends CI_Model class and is used in our Model classes for common tasks accross all application models.
 */
class MY_Model extends CI_Model {

	protected $table_name = 'undefined';

	public $record_id;
	public $insert_at;
	public $update_at;
	public $deleted_at;

	public function __construct($properties = [])
	{
		parent::__construct();
		$this->set_properties($properties);
	}

	public function set_properties($properties = [])
	{
		foreach ($properties as $property => $value)
		{
			$this->$property = $value;
		}
	}

	private function nullify_empty_properties()
	{
		foreach (get_object_vars($this) as $property => $value)
		{
			if (strlen(trim($this->$property)) == 0)
			{
				$this->$property = NULL;
			}
		}
	}

	public function get_record($where = [])
	{
		if (!$where) return NULL;

		$called_class = get_called_class();

		return $this->db->get_where($this->table_name, $where)->custom_row_object(0, $called_class);
	}

	public function get_records($where = [])
	{
		$called_class = get_called_class();
		$where = array_merge($where, ['deleted_at' => NULL]);

		return $this->db->get_where($this->table_name, $where)->custom_result_object($called_class);
	}

	public function get_deleted_records($where = [])
	{
		$called_class = get_called_class();
		$where = array_merge($where, ['deleted_at IS NOT' => NULL]);

		return $this->db->get_where($this->table_name, $where)->custom_result_object($called_class);
	}

	public function get_all_records($where = [])
	{
		$called_class = get_called_class();

		return $this->db->get_where($this->table_name, $where)->custom_result_object($called_class);
	}

	public function save()
	{
		if ((int)$this->record_id > 0)
		{
			$this->update();
		}
		else
		{
			$this->insert();
		}
	}

	public function save_and_get_record_id()
	{
		if ((int)$this->record_id > 0)
		{
			$this->update();
			$result = $this->record_id;
		}
		else
		{
			$this->insert();
			$result = $this->db->insert_id();
		}
		return $result;
	}

	public function update()
	{
		$this->nullify_empty_properties();

		$called_class = get_called_class();

		$datetime_now = new DateTime('now', new DateTimeZone('UTC'));
		$this->update_at = $datetime_now->format('Y-m-d H:i:s');

		$this->db->update($this->table_name, $this, ['record_id' => $this->record_id]);
	}

	public function insert()
	{
		$this->nullify_empty_properties();

		$called_class = get_called_class();

		$datetime_now = new DateTime('now', new DateTimeZone('UTC'));
		$this->insert_at = $datetime_now->format('Y-m-d H:i:s');
		$this->update_at = $datetime_now->format('Y-m-d H:i:s');

		$this->db->insert($this->table_name, $this);

		$this->record_id = $this->db->insert_id();
	}

	public function delete()
	{
		$called_class = get_called_class();

		return $this->db->delete($this->table_name, ['record_id' => $this->record_id]);
	}

	public function soft_delete()
	{
		$called_class = get_called_class();
		$datetime_now = new DateTime('now', new DateTimeZone('UTC'));
		$this->deleted_at = $datetime_now->format('Y-m-d H:i:s');

		$this->db->update($this->table_name, $this, ['record_id' => $this->record_id]);
	}

	public function un_delete()
	{
		$called_class = get_called_class();
		$this->deleted_at = NULL;

		$this->db->update($this->table_name, $this, ['record_id' => $this->record_id]);
	}

	public function is_unique($properties = [])
	{
		if (empty($properties)) return FALSE;

		$where = [];
		foreach ($properties as $property)
		{
			$where[$property] = $this->$property;
		}

		return !(bool)$this->db->get_where($this->table_name, $where)->num_rows();
	}

	public function is_empty($properties = [])
	{
		if (empty($properties)) return TRUE;

		foreach ($properties as $property)
		{
			if (!empty($this->$property)) return FALSE;
		}

		return TRUE;
	}

	public function status()
	{
		if ($this->deleted_at)
		{
			return  ' ';
		}
		else
		{
			return 'checked';
		}
	}

	/**
	 * This function returns local timezone from UTC that database works *
	 *
	 * @return string datetime formated by default as 'Y-m-d H:i:s' or as a format given by the caller
	 */
	public function time_zone_greece($datetime = NULL, $format = NULL)
	{
		if ($datetime)
		{
			$local_date = new DateTime($datetime, new DateTimeZone('UTC'));
			$local_date = $local_date->setTimezone(new DateTimeZone('Europe/Athens'));
			
			if ($format)
			{
				return  $local_date->format($format);
			}
			else
			{
				return  $local_date->format('Y-m-d H:i:s');	
			}	
		}
	}
	
}