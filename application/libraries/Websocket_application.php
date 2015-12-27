<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require 'application/vendor/autoload.php';

class Websocket_application implements  MessageComponentInterface {

	protected $clients;

	public function __construct()
	{
		$this->clients = new \SplObjectStorage;
	}

	public function onOpen(ConnectionInterface $conn)
	{
		$this->clients->attach($conn);
	}

	public function onMessage(ConnectionInterface $from, $msg)
	{
		foreach ($this->clients as $client)
		{
			if ($from != $client)
			{
				$client->send($msg);
			}
		}
	}

	public function onClose(ConnectionInterface $conn)
	{
		$this->clients->detach($conn);
	}

	public function onError(ConnectionInterface $conn, \Exception $e)
	{
		$conn->close();
	}
}

/* End of file Websocket_application.php */
/* Location: ./application/libraries/Websocket_application.php */