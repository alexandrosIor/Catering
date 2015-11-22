<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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

		$this->load->library('websocket_dashboard_application');
		//$this->load->model('stores_model'); εδω τους σερβιτορους

		$loop = Factory::create();

		$socket = new Server($loop);
		$socket->listen('8087', '0.0.0.0');
		if ($this->debug) echo "Created websocket: ws://0.0.0.0:8087/\n";

		$routes = new RouteCollection();

		/*$stores = $this->stores_model->get_records();  σερβιτοροι που εχουν ανοικτη βαρδια να εχουν δικο τους καναλι
		foreach ($stores as $store)
		{
			$routes->add($store->unique_name(), new Route('/' . $store->unique_name(), array('_controller' => new WsServer(new Websocket_dashboard_application))));
			if ($this->debug) echo "Created route: /" . $store->unique_name() . "\n";
		}*/

		$context = new RequestContext();

		$matcher = new UrlMatcher($routes, $context);

		$server = new IoServer( new HttpServer( new Router($matcher) ), $socket, $loop);
		$server->run();
	}
}

/* End of file Shell.php */
/* Location: ./application/controllers/Shell.php */