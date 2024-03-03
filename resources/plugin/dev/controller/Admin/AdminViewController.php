<?php

namespace Plugin\Controller\Admin;

use Plugin\Controller\Controller;
use Plugin\Controller\Admin\View\SectionViewController;

/**
 * Plugin html views
 *
 */

class AdminViewController extends Controller
{
    /**
	 * Plugin properties to build
	 *
	 */
	protected $plugin;

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
	 * Builds plugin page
     *
	 */
    public function router($request)
    {
        wp_enqueue_style('font-awesome-4.6.3');
		wp_enqueue_style('bootstrap-5.0.2');
		wp_enqueue_style('pr-custom-default');
		wp_enqueue_script('bootstrap-bundle-5.0.2');
		wp_enqueue_script('pr-custom-default');

		$data = new \stdClass;
        $data->nonce = wp_create_nonce("pr_custom_like_nonce");
		$data->plugin = $this->plugin;

		echo $this->view('admin.template', $data);
    }


    /**
	 * Builds plugin content
     *
	 */
    public function build($request)
    {
        $this->plugin = $request->plugin;

		add_action('init', [$this, 'assets']);

		add_action('admin_menu', [$this, 'admin_menu']);
    }

    /**
	 * WP UI scripts - called from $this->build()
     *
	 */
	public function assets()
	{
		$assets = $this->plugin->url.'view/assets';
		wp_register_style('font-awesome-4.6.3', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
		wp_register_style('bootstrap-5.0.2', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css');
		wp_register_style('pr-custom-default', $assets.'/css/pr-custom-default.css');
		// (handle, source, registered script handles this script depends on, version, true = in footer, false (or blank) = in <head>)
		wp_register_script('bootstrap-bundle-5.0.2', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', ['jquery'], '5.0.2', true);
		wp_register_script('pr-custom-default', $assets.'/js/pr-custom-default.js', ['jquery'], 'custom-'.date('His'), true);
	}

	/**
	 * WP menu - called from $this->build()
     *
	 */
	public function admin_menu()
	{
		$slug = $this->plugin->slug;

		add_menu_page(
			'PR Custom', // string $page_title
			'PR Custom', // string $menu_title
			'manage_options', // string $capability
			$slug, // string $menu_slug
			null, // callable $function - if has submenu leave it nulled
			'dashicons-rest-api', // string $menu_icon
			6 // menu position
		);

		// if has plugin menu has submenu

		// mandatory to overlap repeated menu page
		add_submenu_page(
			$slug, // string $parent_slug,
			'PR Custom Index', // string $page_title,
			'Index', // string $menu_title,
			'manage_options', // string $capability,
			$slug, // string $menu_slug,
			[$this, 'router'], // callable $function = ''
		);

		add_submenu_page(
			$slug,
			'PR Custom - Settings',
			'Settings',
			'manage_options',
			$slug.'-settings',
			[$this, 'router'],
		);
	}

}
