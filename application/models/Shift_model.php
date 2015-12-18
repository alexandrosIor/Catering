<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
class Shift_model extends MY_Model
{
	protected $table_name = 'shifts';

	public $user_record_id;
	public $start_date;
	public $end_date;
	public $turnover_delivered;
	public $turnover_calculated;
	public $turnover_diff;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

	public function create_new_shift()
	{
		$datatime_now = new DateTime('NOW', new DateTimeZone('UTC'));
		$this->start_date = $datatime_now->format('Y-m-d H:i:s');

		return $this->insert(['user_record_id' => $this->user_record_id, 'start_date' => $this->start_date]);
	}

	public function get_current_open_shift()
	{
		$shift = $this->get_record(['end_date' => NULL, 'user_record_id' => $this->user_record_id]);

		if ($shift)
		{
			unset($shift->table_name);
			$this->set_properties((array)$shift);
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function user($property = NULL)
	{
		$this->load->model('user_model');

		$user = $this->user_model->get_record(['record_id' => $this->user_record_id]);

		if ($property == 'name')
		{
			return $user->lastname . ' ' . $user->firstname;
		}

		return $user->$property;
	}

	public function total_orders()
	{
		$this->load->model('order_model');

		return count($this->order_model->get_records(['shift_record_id' => $this->record_id]));
	}

	public function close_shift()
	{
		$datatime_now = new DateTime('NOW', new DateTimeZone('UTC'));
		$this->end_date = $datatime_now->format('Y-m-d H:i:s');

		/*if ($this->turnover_delivered > 0)
		{
			$this->turnover_diff = bcsub($this->turnover_delivered, $this->turnover_calculated, 2);
		}*/

		$this->save();
	}

}

/* End of file Shift_model.php */
/* Location: ./application/models/Shift_model.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/