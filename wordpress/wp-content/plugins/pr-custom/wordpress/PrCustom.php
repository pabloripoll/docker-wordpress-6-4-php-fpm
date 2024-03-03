<?php

namespace Plugin\Wordpress;

use Plugin\Controller\AdminController;

/**
 * Main object that bootstraps the plugin executions
 *
 */

class PrCustom
{
	/**
	 * Plugin directory path
	 *
	 * @var string
	 */
	public $dir;

	/**
	 * Plugin file
	 *
	 * @var string
	 */
	public $file;

	/**
	 * Plugin base url
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Plugin directory name
	 *
	 * @var string
	 */
	public $slug;

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	public $version;

	/**
	 * Plugin builder response
	 *
	 */
	public function __construct($plugin = null)
	{
		if ($plugin) {
			$this->url = str_replace(basename(dirname(__FILE__)).'/', '', plugins_url('/', __FILE__));
			$this->dir = plugin_dir_path($plugin);
			$this->slug = basename(dirname(__DIR__, 1));
			$this->file = basename($plugin);
			$this->version = '1.1';
		} else {
			return null;
		}
	}

	public function admin()
	{
		if (is_admin()) {
			return new AdminController($this);
		}
	}

}
