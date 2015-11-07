<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function time_to_seconds($time)
{
	if (substr_count($time, ':') !== 2) return 0;

	list($hours, $minutes, $seconds) = explode(':', $time);
	$total_seconds = ((int)$hours * 3600) + ((int)$minutes * 60) + $seconds;

	return $total_seconds;
}

function seconds_to_time($seconds)
{
	if (!is_integer($seconds)) return NULL;

	$hours = floor($seconds / 3600);
	$minutes = floor(($seconds / 60) % 60);
	$seconds = $seconds % 60;

	$hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
	$minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
	$seconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);

	return $hours . ':' . $minutes . ':' . $seconds;
}

function seconds_to_human($seconds)
{
	$units2 = array(
		array('plural'=>'ευδομάδες', 'noon'=>'ευδομάδα', 'divisor'=>7*24*3600),
		array('plural'=>'ημέρες', 'noon'=>'ημέρα', 'divisor'=>24*3600),
		array('plural'=>'ώρες', 'noon'=>'ώρα', 'divisor'=>3600),
		array('plural'=>'λεπτά', 'noon'=>'λεπτό', 'divisor'=>60),
		array('plural'=>'δευτερόλεπτα', 'noon'=>'δευτερόλεπτο', 'divisor'=>1),
	);

	if ( $seconds == 0 ) return "0 δευτερόλεπτα";

	$string = "";

	foreach ( $units2 as $unit )
	{
		if ( $quot = intval($seconds / $unit['divisor']) )
		{
			$string .= $quot . ' ';
			$string .= (abs($quot) > 1 ? $unit['plural'] : $unit['noon']) . " και ";
			$seconds -= $quot * $unit['divisor'];
		}
	}

	return mb_substr($string, 0, -5);
}

function get_seconds_diff_from_dates($from, $to)
{
	$datetime_from = new DateTime($from, new DateTimeZone('UTC'));
	$datetime_to = new DateTime($to, new DateTimeZone('UTC'));

	$diff = $datetime_from->diff($datetime_to);
	return ($diff->format('%a') * 86400) + ($diff->format('%h') * 3600) + ($diff->format('%i') * 60) + $diff->format('%s');
}

function get_seconds_diff_from_datetimes($datetime_from, $datetime_to)
{
	$diff = $datetime_from->diff($datetime_to);
	return ($diff->format('%a') * 86400) + ($diff->format('%h') * 3600) + ($diff->format('%i') * 60) + $diff->format('%s');
}

function is_time_between($time, $from_time, $to_time)
{
	$time = str_replace(':', '', $time);
	$from_time = str_replace(':', '', $from_time);
	$to_time = str_replace(':', '', $to_time);

	if ($from_time > $to_time) // το from βρήσκετε σε διαφορετική μέρα, πρεπει να ελεγξουμε βάση του 00:00
	{
		if ($from_time <= $time AND $time <= '235959')
		{
			return TRUE;
		}
		else if ($to_time >= $time AND $time >= '000000')
		{
			return TRUE;
		}
	}
	else // το from και το to βρήσκοντε στο ίδιο 24αωρο, ελεγχουμε αν το time είναι ανάμεσα
	{
		if ($from_time <= $time AND $to_time >= $time)
		{
			return TRUE;
		}
	}
	return FALSE;
}

function round_up($value, $precision)
{
	$pow = pow ( 10, $precision );
	return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow;
}

function add_alpabetic_keyboard_shortcuts($items)
{
	$keyboard_shortcuts = array('q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p');

	foreach ($items as $key => $item)
	{
		$items[$key]['keyboard_shortcut'] = NULL;
		if (count($keyboard_shortcuts) > 0)
		{
			$keyboard_shortcut = array_shift($keyboard_shortcuts);
			$items[$key]['keyboard_shortcut'] = $keyboard_shortcut;
		}
	}

	return $items;
}

function ping($host, $timeout = array('sec' => 0, 'usec' => 500000))
{
	$package = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";
	$socket  = socket_create(AF_INET, SOCK_RAW, 1);
	socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, $timeout);
	socket_connect($socket, $host, NULL);

	$ts = microtime(TRUE);
	socket_send($socket, $package, strlen($package), 0);
	if (socket_read($socket, 255))
	{
		$result = microtime(TRUE) - $ts;
	}
	else
	{
		$result = FALSE;
		socket_close($socket);
	}

	return $result;
}

?>