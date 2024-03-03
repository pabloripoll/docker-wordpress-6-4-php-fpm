<?php

namespace Plugin\Controller;

use Plugin\Support\Request;
use Plugin\Controller\Admin\AdminViewController;

/**
 * Provides the settings and admin page
 */
class AdminController
{
	/**
	 * Bootstraps the admin requests control
	 *
	 */
	public function __construct($plugin)
	{
		$request = new Request;

		if (isset($request->post()->action)) {
			if ($request->post()->action != 'pr_custom_admin_ajax') {
				exit;
			}
			if ($request->is_ajax()) {
				if (! $request->view()) {
					return (new AdminAjaxController())->action($request);
				} else {
					return (new AdminViewController())->content($request);
				}
			}
		} else {
			$request->plugin = $plugin;

			return (new AdminViewController())->build($request);
		}
	}

}
