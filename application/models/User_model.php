<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
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

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/