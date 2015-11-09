<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require __DIR__ . '/../../vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use WebSocket\Client;

class Websocket_application_lib implements MessageComponentInterface {

	var $ci;
	protected $clients;

	/* array that holds webinterface socket clients */
	protected $web_interface_clients;

	function __construct()
	{
		$this->ci =& get_instance();
		$this->clients = new \SplObjectStorage;

		$this->ci->load->model('workstations_model'); // not a good way to autoload my model! maybe autoload it in the ci config
		$this->ci->load->library('webinterface_socket_connections_lib');
		$this->ci->load->library('websocket_messages_lib');
	}

	public function onOpen(ConnectionInterface $connection)
	{
		// Store the new connection to send messages later
		$this->clients->attach($connection);

		$client_type = NULL;
		$allowed = TRUE;

		$useragent = $this->get_client_useragent($connection);
		if ($useragent === 'workstation')
		{
			$client_type = 'workstation';

			$this->verify_database_connection();
			if ($this->ci->workstations_model->is_workstation_ipaddress_allowed($connection->remoteAddress))
			{
				$this->ci->workstations_model->set_workstation_connected($connection);

				// Send connection status to web interfaces
				$web_interface_connections = (array)$this->ci->webinterface_socket_connections_lib->get_connections();
				foreach ($this->clients as $client)
				{
					if (array_key_exists($client->resourceId, $web_interface_connections))
					{
						$this->ci->websocket_messages_lib->webinterface_msg_update_workstation_info(array('ip_address'=>$connection->remoteAddress, 'connected'=>'yes'), $client);
						$this->ci->websocket_messages_lib->webinterface_msg_security_violation(array('ip_address' => $connection->remoteAddress, 'state' => FALSE), $client);
					}
				}

				$this->ci->load->library('charger_lib');
				$this->ci->charger_lib->send_initial_workstation_info($connection);
			}
			else
			{
				$allowed = FALSE;
				$connection->send('workstation is not allowed to connect');
				$connection->close();
			}
		}
		else if ($useragent == 'server')
		{
			$client_type = 'server';
		}
		else
		{
			//$client_type = $connection->remoteAddress=='127.0.0.1' ? 'server' : 'webinterface';
			//if ($connection->remoteAddress != '127.0.0.1') $this->ci->webinterface_socket_connections_lib->add_connection($connection);
			$client_type = 'webinterface';
			$this->ci->webinterface_socket_connections_lib->add_connection($connection);
		}
		echo date('Y-m-d H:i:s') . "\t" . 'Openn connection: (resourceId:' . $connection->resourceId . ', remoteAddress:' . $connection->remoteAddress . ', client_type:' . $client_type . ', allowed:' . var_export($allowed, TRUE) . ')' . "\n";
	}

	public function onClose(ConnectionInterface $connection)
	{
		// The connection is closed, remove it, as we can no longer send it messages
		$this->clients->detach($connection);

		$client_type = NULL;

		$useragent = $this->get_client_useragent($connection);
		if ($useragent === 'workstation')
		{
			$client_type = 'workstation';

			$this->verify_database_connection();
			$this->ci->workstations_model->set_workstation_disconnected($connection);

			// Send connection status to web interfaces
			$web_interface_connections = (array)$this->ci->webinterface_socket_connections_lib->get_connections();
			foreach ($this->clients as $client)
			{
				if (array_key_exists($client->resourceId, $web_interface_connections))
				{
					$this->ci->websocket_messages_lib->webinterface_msg_update_workstation_info(array('ip_address'=>$connection->remoteAddress, 'connected'=>'no'), $client);
				}
			}
		}
		else
		{
			$client_type = $connection->remoteAddress=='127.0.0.1' ? 'server' : 'webinterface';

			$this->ci->webinterface_socket_connections_lib->remove_connection($connection);
		}
		echo date('Y-m-d H:i:s') . "\t" . 'Close connection: (resourceId:' . $connection->resourceId . ', remoteAddress:' . $connection->remoteAddress . ', client_type:' . $client_type . ')' . "\n";
	}

	public function onError(ConnectionInterface $connection, \Exception $e)
	{
		echo date('Y-m-d H:i:s') . "\tAn error has occurred: " . $e->getMessage() . "\n";
		$connection->close();
	}

	public function onMessage(ConnectionInterface $sender_connection, $msg)
	{
		$routed_to = 0;

		$is_client_message_allowed = $this->is_client_message_allowed($sender_connection, $msg);
		if ($is_client_message_allowed['status'] === TRUE)
		{
			$routed_to = $this->route_message($msg);
		}
		else
		{
			$this->verify_database_connection();
			$this->ci->workstations_model->set_workstation_disconnected($sender_connection);
			$sender_connection->send($is_client_message_allowed['message']);
			$sender_connection->close();
		}

		$client_type = $this->get_client_useragent($sender_connection);
		if ($client_type !== 'workstation') $client_type = $sender_connection->remoteAddress=='127.0.0.1' ? 'server' : 'webinterface';

		echo date('Y-m-d H:i:s') . "\t" . 'Messg connection (resourceId:' . $sender_connection->resourceId . ', remoteAddress:' . $sender_connection->remoteAddress . ', client_type:' . $client_type . ', allowed:' . var_export($is_client_message_allowed['status'], TRUE) . ', routed_to:' . $routed_to . ')' . "\n";
		echo "\t\t\t" . $msg . "\n";
	}

	private function is_client_message_allowed(ConnectionInterface $from, $message)
	{
		// check if we got a valid json string
		$decoded_message = @json_decode($message, TRUE);
		if ($decoded_message === FALSE)
		{
			$result['status'] = FALSE;
			$result['message'] = 'we talk json in here bro!';
			return $result;
		}
		else
		{
			// check if message sender is in our allowed list.
			$allowed_custom_senders = array('webinterface', 'server', 'workstation');
			if (isset($decoded_message['sender']) AND in_array($decoded_message['sender'], $allowed_custom_senders))
			{
				$result['status'] = TRUE;
				$result['message'] = $decoded_message['sender'] . ' is whitelisted';
				return $result;
			}
		}

		$result['status'] = FALSE;
		$result['message'] = 'who is this?';
		return $result;
	}

	private function get_client_useragent($connection)
	{
		//$headers = $connection->WebSocket->request->getHeaders(); // for future use!
		if (!$useragent = $connection->WebSocket->request->getHeader('user-agent'))
		{
			// unfortunately this is how .net webrequest sends useragent! in camel case!
			// TODO: check if .net client shield sends user-agent also!
			$useragent = $connection->WebSocket->request->getHeader('UserAgent');
		}

		if (is_object($useragent))
		{
			$useragent = $useragent->toArray();
			if (is_array($useragent) AND array_key_exists(0, $useragent)) $useragent = $useragent[0];
		}
		return $useragent;
	}

	private function verify_database_connection()
	{
		$this->ci->db->reconnect();
		if ($this->ci->db->conn_id === FALSE)
		{
			echo date('Y-m-d H:i:s') . "\tthis->ci->db->conn_id is FALSE after mysql ping!, re-loading database()\n";
			$this->ci->load->database();
		}
	}

	private function route_message($message)
	{
		$message_decoded = json_decode($message, TRUE);

		$routed_to = array();

		if ($message_decoded['recipient'] == 'webinterface')
		{
			$web_interface_connections = (array)$this->ci->webinterface_socket_connections_lib->get_connections();
			foreach ($this->clients as $client)
			{
				if (array_key_exists($client->resourceId, $web_interface_connections))
				{
					$client->send($message);
					$routed_to[] = $client->remoteAddress;
				}
			}
		}
		else
		{
			foreach ($this->clients as $client)
			{
				if ($client->remoteAddress == $message_decoded['recipient'])
				{
					$client->send($message);
					$routed_to[] = $client->remoteAddress;
				}
			}
		}
		return implode(',', $routed_to);
	}

	private function send_all_workstation_messages($connection)
	{
		// Shield Enable
		$message = array(
			'message_type' => 'shield_state',
			'message_data' => array('enabled'=>TRUE)
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Shield Disable
		$message = array(
			'message_type' => 'shield_state',
			'message_data' => array('enabled'=>FALSE)
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Reboot Now
		$message = array(
			'message_type' => 'reboot',
			'message_data' => array('timeout'=>'00:00:00')
		);
		$message_container = array();
		$message_container['sender'] = 'webinterface';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Reboot in 5 min
		$message = array(
			'message_type' => 'reboot',
			'message_data' => array('timeout'=>'01:00:00')
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Shutdown Now
		$message = array(
			'message_type' => 'shutdown',
			'message_data' => array('timeout'=>'00:00:00')
		);
		$message_container = array();
		$message_container['sender'] = 'webinterface';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Shutdown in 5 min
		$message = array(
			'message_type' => 'shutdown',
			'message_data' => array('timeout'=>'01:00:00')
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Terminate Shield Now
		$message = array(
			'message_type' => 'terminate_shield',
			'message_data' => array('timeout'=>'00:00:00')
		);
		$message_container = array();
		$message_container['sender'] = 'webinterface';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Terminate Shield in 5 min
		$message = array(
			'message_type' => 'terminate_shield',
			'message_data' => array('timeout'=>'01:00:00')
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Send Workstation Info
		$message = array(
			'message_type' => 'workstation_info',
			'message_data' => array('label'=>'PC023')
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Send Member Info
		$message = array(
			'message_type' => 'member_info',
			'message_data' => array('text'=>'Χρηστόδουλος Ξήρος')
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Send Charge Info (ελευθερη χρέωση)
		$message = array(
			'message_type' => 'charge_info',
			'message_data' => array('text'=>'Χρέωση: 2.10 €')
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Send Charge Info (προπληρωμενη χρέωση)
		$message = array(
			'message_type' => 'charge_info',
			'message_data' => array('text'=>'Υπόλοιπο: 03:12')
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Send Charge Info (προπληρωμενη χρέωση με POS)
		$message = array(
			'message_type' => 'charge_info',
			'message_data' => array('text'=>'Υπόλοιπο: 03:12 + 0.20 €')
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));

		// Send Text Message
		$message = array(
			'message_type' => 'text_message',
			'message_data' => array('text'=>'η χρεωση σου λήγει σε 5 λεπτα!', 'timeout'=>'00:00:55')
		);
		$message_container = array();
		$message_container['sender'] = 'server';
		$message_container['recipient'] = $connection->remoteAddress;
		$message_container['message'] = $message;
		$connection->send(json_encode($message_container));
	}
}

/* End of file Websocket_application_lib.php */
/* Location: ./application/libraries/Websocket_application_lib.php */