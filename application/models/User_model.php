<?php

class User_model extends MY_Model
{
	protected $table_name = 'users';

	public $firstname;
	public $lastname;
	public $email;
	public $password;
	public $role;
	public $store_record_ids;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

/*	public function get_member_by_email_pass($username, $password)
	{
		$member = $this->db->get_where($this->table_name, array('email' => $username, 'password' => $password))->result_array();
		if (count($member) == 1)
		{
			return $member[0];
		}

		return FALSE;
	}*/

	public function get_user_roles()
	{
		return ['waiter', 'store_user', 'store_admin'];
	}

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */