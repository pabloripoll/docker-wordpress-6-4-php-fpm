<?php

namespace Plugin\Support;

/**
 * Observer
 *
 */

class Request
{
	/**
	 * The plugin
	 */
	public $plugin;

    /**
	 * Confirms ajax requests
	 */
	public function is_ajax()
	{
		return ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ? true : false;
	}

	/**
	 * Request method
	 */
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

	/**
	 * GET requests
	 */
    public function get()
    {
        return (object) filter_input_array(INPUT_GET);
    }

	/**
	 * POST requests
	 */
    public function post()
    {
        return (object) filter_input_array(INPUT_POST);
    }

	/**
	 * Function
	 *
	 */
    public function function()
	{
		if ($this->method() == 'get') {
			return $this->get()->function;
		}

		if ($this->method() == 'post') {
			return $this->post()->function;
		}

		return false;
	}

	/**
	 * View - only for post methods
	 *
	 */
	public function view()
	{
		return ! isset($this->post()->view) ? : json_decode(json_encode($this->post()->view));
	}

}
