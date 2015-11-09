<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Websocket_message_lib {

	var $ci;

	public $message_container = array();

	public $sender = '';

	public $recipient = '';

	public $message = array();

	function __construct($properties = NULL)
	{
		if ($properties)
		{
			foreach ($properties as $key=>$value)
			{
				$this->$key = $value;
			}
		}
	}

	function get_formated_message()
	{
		$this->message_container['sender'] = $this->sender;
		$this->message_container['recipient'] = $this->recipient;
		$this->message_container['message'] = $this->message;

		return json_encode($this->message_container);
	}

}


/* End of file Websocket_message_lib.php */
/* Location: ./application/libraries/Websocket_message_lib.php */