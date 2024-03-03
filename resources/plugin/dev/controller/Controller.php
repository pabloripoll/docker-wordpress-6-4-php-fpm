<?php

namespace Plugin\Controller;

use Plugin\Support\Request;
use Plugin\Support\Response;

/**
 * Service the settings
 */
abstract class Controller
{
	public function request()
	{
		return new Request;
	}

	public function view($script = null, $data = null)
	{
		return (new Response)->view($script, $data);
	}

}
