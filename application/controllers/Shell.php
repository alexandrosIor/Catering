<?php
/**
 * @package	Catering
 * @author	Alexandros Iordanidis
 */
defined('BASEPATH') OR exit('No direct script access allowed');

use React\EventLoop\Factory;
use React\Socket\Server;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\Http\Router;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

class Shell extends CI_Controller {

	public function index()
	{

	}

	public function socket_server()
	{
		if (!is_cli())
		{
			echo "This controller must run from command line interface only.\n";
			return ;
		}
		echo __DIR__;

		$this->load->library('websocket_application');
		$this->load->model('user_model');

		$loop = Factory::create();

		$socket = new Server($loop);
		$socket->listen('8087', '0.0.0.0');
		echo "Created websocket: ws://0.0.0.0:8087/\n";

		$routes = new RouteCollection();

		$users = $this->user_model->get_records();

		foreach ($users as $user)
		{
			$routes->add($user->record_id, new Route('/' . $user->record_id, array('_controller' => new WsServer(new Websocket_application))));
			echo "Created route: /" . $user->record_id . "\n";
		}

		$context = new RequestContext();

		$matcher = new UrlMatcher($routes, $context);

		$server = new IoServer( new HttpServer( new Router($matcher) ), $socket, $loop);
		$server->run();
	}

}

/* End of file Shell.php */
/* Location: ./application/controllers/Shell.php */
/* Author: Alexandros Iordanidis website: alexiordanidis.com email: contact@alexiordanidis.com*/