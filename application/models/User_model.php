<?php

class User_model extends MY_Model
{
	protected $table_name = 'users';

	public $firstname;
	public $lastname;
	public $email;
	public $password;
	public $role;

	function __construct($properties = [])
	{
		// Call the Model constructor
		parent::__construct($properties);
	}

	public function get_user_roles()
	{
		return ['waiter', 'store', 'admin'];
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

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */