<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Webinterface_socket_connections_lib {

	var $ci;
	private $connections;

	function __construct()
	{
		$this->ci =& get_instance();

		$this->ci->load->driver('cache');
	}

	function clear_all()
	{
		$this->connections = array();
		return $this->ci->cache->file->delete('webinterface_connections');
	}

	function add_connection($connection)
	{
		$this->connections[$connection->resourceId] = $connection->remoteAddress;
		return $this->ci->cache->file->save('webinterface_connections', $this->connections, 86400); // for 1 day
	}

	function remove_connection($connection)
	{
		unset($this->connections[$connection->resourceId]);
		return $this->ci->cache->file->save('webinterface_connections', $this->connections, 86400); // for 1 day
	}

	function get_connections()
	{
		return $this->ci->cache->file->get('webinterface_connections');
	}
}


/* End of file Webinterface_socket_connections_lib.php */
/* Location: ./application/libraries/Webinterface_socket_connections_lib.php */