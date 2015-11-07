<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Αυτο είναι το πρωην Template το μετονομασα και προσθεσα της js και css functions
// Αν θές μπορουμε την foreach να την μεταφερουμε απευθειας στο layout και να μην κανει echo απο εδω μεσα.
class Layout_lib {

	var $ci;

	/** @var array επιπροσθετα αρχεια css που θα συμπερληφθουν στο <head> του layout */
	private $additional_css = array();

	/** @var array επιπροσθετα αρχεια javascript που θα συμπερληφθουν στο τελος του layout */
	private $additional_js = array();

	function __construct()
	{
		$this->ci =& get_instance();
	}

	function load($layout_view, $body_view = null, $data = null)
	{
		if ( ! is_null( $body_view ) )
		{
			$body = $this->ci->load->view($body_view, $data, TRUE);

			if ( is_null($data) )
			{
				$data = array('body' => $body);
			}
			else if ( is_array($data) )
			{
				$data['body'] = $body;
			}
			else if ( is_object($data) )
			{
				$data->body = $body;
			}
		}

		$this->ci->load->view($layout_view, $data);
	}

	function add_additional_css($css_path)
	{
		$this->additional_css[] = $css_path;
	}

	function print_additional_css()
	{
		echo '<!-- START OF print_additional_css -->' . "\n";
		foreach ($this->additional_css as $additional_css_path)
		{
			echo '<link href="' . $additional_css_path . '" rel="stylesheet">' . "\n";
		}
		echo '<!-- END OF print_additional_css -->' . "\n";
	}

	function add_additional_js($js_path)
	{
		$this->additional_js[] = $js_path;
	}

	function print_additional_js()
	{
		echo '<!-- START OF print_additional_js -->' . "\n";
		foreach ($this->additional_js as $additional_js_path)
		{
			echo '<script src="' . $additional_js_path . '"></script>' . "\n";
		}
		echo '<!-- END OF print_additional_js -->' . "\n";
	}
}


/* End of file Layout_lib.php */
/* Location: ./application/libraries/Layout_lib.php */