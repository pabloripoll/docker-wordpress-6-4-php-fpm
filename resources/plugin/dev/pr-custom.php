<?php

/*

Plugin Name: PR Custom
Plugin URI: https://github.com/pabloripoll/wordpress-custom-plugin-starter
Description: Wordpress generic plugin tool as a starting point to build a fancy Wordpress admin support.
Version: 1.1
Author: Pablo Ripoll
Author URI: https://github.com/pabloripoll

License: GPLv2

*/

if (! defined('ABSPATH')) exit; // exit if this plugin was accessed directly

/**
 * Plugin Class Autoloader
 *
 */

require_once plugin_dir_path(__FILE__).'autoloader.php';

Autoloader::instance();

use Plugin\Wordpress\PrCustom;
use Plugin\Config\DatabaseConfig;

/**
 * Plugin hooks functions
 *
 */
function activatePlugin() {
    (new DatabaseConfig)->migrate();
}

function uninstallPlugin() {
    (new DatabaseConfig)->rollback();
}

function pluginAjaxRequest() {
    // function with null process to grab wordpress ajax calls into this plugin
}

/**
 * Wordpress Hooks
 *
 */

// WordPress hooks
register_activation_hook(__FILE__, 'activatePlugin');
register_uninstall_hook(__FILE__, 'uninstallPlugin');

// Wordpress ajax hooks
add_action('wp_ajax_pr_custom_admin_ajax', 'pluginAjaxRequest');


/**
 * Plugin execution
 *
 */

$plugin = new PrCustom(__FILE__); // pasar a arriba y así tomar los hooks con $plugin ???

return $plugin->admin();
