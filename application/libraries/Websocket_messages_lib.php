<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'application/vendor/autoload.php';
use WebSocket\Client;

class Websocket_messages_lib {

	var $ci;
	private $instance_connection;

	function __construct($user)
	{
		if ($user)
		{
			$this->ci =& get_instance();
			$options = array('headers' => array('user-agent' => 'server'));
			$this->instance_connection = new Client('ws://127.0.0.1:8087/' . $user['user_record_id'], $options);
		}
	}

	function waiter_send_new_order_to_store($data, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'waiter',
				'recipient' => 'store',
				'message' => array(
					'message_type' => 'waiter_new_order',
					'message_data' => $data
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function store_update_order($data, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'store',
				'recipient' => 'waiter',
				'message' => array(
					'message_type' => 'store_order_update',
					'message_data' => $data
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

}

/* End of file Websocket_messages_lib.php */
/* Location: ./application/libraries/Websocket_messages_lib.php */