<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require __DIR__ . '/../vendor/autoload.php';
use WebSocket\Client;

class Websocket_messages_lib {

	var $ci;
	private $instance_connection;

	function __construct($store)
	{
		if ($store)
		{
			$this->ci =& get_instance();
			$options = array('headers' => array('user-agent' => 'server'));
			$this->instance_connection = new Client('ws://127.0.0.1:8087/' . $store[0]->unique_name(), $options);
		}
	}

	function webinterface_msg_update_workstation_info($data, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => 'webinterface',
				'message' => array(
					'message_type' => 'update_workstation_info',
					'message_data' => $data
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function webinterface_msg_update_dashboard_stats($data, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => 'webinterface',
				'message' => array(
					'message_type' => 'update_dashboard_stats',
					'message_data' => $data
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function webinterface_msg_toastr($data, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => 'webinterface',
				'message' => array(
					'message_type' => 'toastr',
					'message_data' => $data
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function webinterface_msg_ministats($data, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => 'webinterface',
				'message' => array(
					'message_type' => 'mini_stats',
					'message_data' => $data
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function webinterface_msg_security_violation($data, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => 'webinterface',
				'message' => array(
					'message_type' => 'security_violation',
					'message_data' => $data
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	// Messages for workstations
	function workstation_msg_shield_state($recipient, $state, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => $recipient,
				'message' => array(
					'message_type' => 'shield_state',
					'message_data' => array(
						'enabled' => $state
					)
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function workstation_msg_reboot($recipient, $timeout, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => $recipient,
				'message' => array(
					'message_type' => 'reboot',
					'message_data' => array(
						'timeout' => $timeout
					)
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function workstation_msg_shutdown($recipient, $timeout, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => $recipient,
				'message' => array(
					'message_type' => 'shutdown',
					'message_data' => array(
						'timeout' => $timeout
					)
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function workstation_msg_terminate_shield($recipient, $timeout, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => $recipient,
				'message' => array(
					'message_type' => 'terminate_shield',
					'message_data' => array(
						'timeout' => $timeout
					)
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function workstation_msg_workstation_info($recipient, $label, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => $recipient,
				'message' => array(
					'message_type' => 'workstation_info',
					'message_data' => array(
						'label' => $label
					)
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function workstation_msg_member_info($recipient, $text, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => $recipient,
				'message' => array(
					'message_type' => 'member_info',
					'message_data' => array(
						'text' => $text
					)
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function workstation_msg_charge_info($recipient, $text, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => $recipient,
				'message' => array(
					'message_type' => 'charge_info',
					'message_data' => array(
						'text' => $text
					)
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$connection->send($websocket_message->get_formated_message());
	}

	function workstation_msg_text_message($recipient, $text, $timeout, $connection = NULL)
	{
		$this->ci->load->library('websocket_message_lib');
		$websocket_message = new Websocket_message_lib(
			array(
				'sender' => 'server',
				'recipient' => $recipient,
				'message' => array(
					'message_type' => 'text_message',
					'message_data' => array(
						'text' => $text,
						'timeout' => $timeout
					)
				)
			)
		);

		if (!$connection) $connection = $this->instance_connection;
		$res = $connection->send($websocket_message->get_formated_message());
	}

	function webinterface_send_charge_info($workstation_charge_info)
	{
		// ενημερώνουμε το web interface στέλνωντας μήνυμα στο websocket
		$message_data = array(
			'ip_address' => $workstation_charge_info['ip_address'],
			'workstation_session_record_id' => $workstation_charge_info['workstation_session_record_id'],
			'reminder_text' => $workstation_charge_info['reminder_text'],
			'security_violation' => $workstation_charge_info['security_violation'],
			'member_info' => '<strong>' . $workstation_charge_info['member_info'] . '</strong>',
			'charge_info' => $workstation_charge_info['charge_info'],
			'panel_color' => $workstation_charge_info['panel_color'],
			'row_1_label' => $workstation_charge_info['row_1_label'],
			'row_1_value' => $workstation_charge_info['row_1_value'],
			'row_2_label' => $workstation_charge_info['row_2_label'],
			'row_2_value' => $workstation_charge_info['row_2_value'],
			'row_3_label' => $workstation_charge_info['row_3_label'],
			'row_3_value' => $workstation_charge_info['row_3_value'],
			'row_total_usage_label' => $workstation_charge_info['row_total_usage_label'],
			'row_total_usage_value' => $workstation_charge_info['row_total_usage_value'],
		);
		$this->webinterface_msg_update_workstation_info($message_data);
	}

	function workstation_send_charge_info($workstation_charge_info)
	{
		// στέλνουμε τα απαραιτητα μηνύματα στο τερματικό
		$this->workstation_msg_workstation_info($workstation_charge_info['ip_address'], $workstation_charge_info['label']);
		$this->workstation_msg_shield_state($workstation_charge_info['ip_address'], $workstation_charge_info['shield_state']);
		$this->workstation_msg_member_info($workstation_charge_info['ip_address'], str_replace('&nbsp;', '', $workstation_charge_info['member_info']));
		$this->workstation_msg_charge_info($workstation_charge_info['ip_address'], str_replace('&nbsp;', '', $workstation_charge_info['row_3_label']) . ' ' . str_replace('&nbsp;', '', $workstation_charge_info['row_3_value']));
		if (isset($workstation_charge_info['notification_message'])) $this->workstation_msg_text_message($workstation_charge_info['ip_address'], $workstation_charge_info['notification_message'], '00:00:50');
	}

	function webinterface_send_dashboard_stats($dashboard_stats)
	{
		$message_data = array(
			'new_members' => $dashboard_stats['new_members'],
			'visitors' => $dashboard_stats['visitors'],
			'total_time' => $dashboard_stats['total_time'],
			'total_sales' => $dashboard_stats['total_sales'],
			'visits_count' => $dashboard_stats['visits_count'],
			'visits_graph_data' => $dashboard_stats['visits_graph_data']
		);
		$this->webinterface_msg_update_dashboard_stats($message_data);
	}
}

/* End of file Websocket_messages_lib.php */
/* Location: ./application/libraries/Websocket_messages_lib.php */