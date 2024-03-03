<?php

namespace Plugin\Controller\Admin;

use Plugin\Route\ExampleRoute;
use Plugin\Route\SettingRoute;
use Plugin\Controller\Controller;
use Plugin\Controller\Admin\View\SectionViewController;

/**
 * Plugin html views
 *
 */

class AdminViewController extends Controller
{
	/**
	 * Plugin request to build
	 *
	 */
	protected $request;

    /**
	 * Builds plugin content dynamically via ajax requests
     *
	 */
    public function content($request)
    {
        $section = $request->view()->section;

        echo (new SectionViewController)->$section($request);

		exit;
    }

	/**
	 * Builds plugin pages routes
     *
	 */
	protected function routes($page = null)
	{
		$slug = $this->request->plugin->slug;

		$route = [
			$slug => (new ExampleRoute)->example(),
			$slug.'-setting' => (new SettingRoute)->setting()
		];

		return ! $page ? $route : $route[$page];
	}

	/**
	 * Builds plugin pages statically
     *
	 */
    public function template()
    {
        wp_enqueue_style('font-awesome-4.6.3');
		wp_enqueue_style('bootstrap-5.0.2');
		wp_enqueue_style('pr-custom-default');
		wp_enqueue_script('bootstrap-bundle-5.0.2');
		wp_enqueue_script('pr-custom-default');

		$data = new \stdClass;

        $data->nonce = wp_create_nonce("pr_custom_like_nonce");
		$data->plugin = $this->request->plugin;

		$data->route = $this->routes($this->request->get()->page);

		echo $this->view('admin.template', $data);
    }


    /**
	 * Builds plugin static pages
     *
	 */
    public function build($request)
    {
		$this->request = $request;

		add_action('init', [$this, 'assets']);

		add_action('admin_menu', [$this, 'menu']);
    }

    /**
	 * WP ui scripts register
     *
	 */
	public function assets()
	{
		$assets = $this->request->plugin->url.'view/assets';
		wp_register_style('font-awesome-4.6.3', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
		wp_register_style('bootstrap-5.0.2', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
		wp_register_style('pr-custom-default', $assets.'/css/pr-custom-default.css');
		// (handle, source, registered script handles this script depends on, version, true = in footer, false (or blank) = in <head>)
		wp_register_script('bootstrap-bundle-5.0.2', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', ['jquery'], '5.0.2', true);
		wp_register_script('pr-custom-default', $assets.'/js/pr-custom-default.js', ['jquery'], 'custom-'.date('His'), true);
	}

	/**
	 * WP menu register
     *
	 */
	public function menu()
	{
		$slug = $this->request->plugin->slug;

		add_menu_page(
			null, // string $page_title (if has submenu leave it nulled)
			'PR Custom', // string $menu_title
			'manage_options', // string $capability
			$slug, // string $menu_slug
			null, // callable $function (if has submenu leave it nulled)
			'dashicons-rest-api', // string $menu_icon
			6 // menu position
		);

		// if has plugin menu has submenu
		foreach ($this->routes() as $sub_slug => $route) {
			add_submenu_page(
				$slug,
				'PR Custom - '.$route['title'],
				$route['menu'],
				'manage_options',
				$sub_slug,
				[$this, 'template'],
			);
		}
	}

}
