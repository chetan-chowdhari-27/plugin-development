<?php 
/*
 * Plugin Name:       Portfolio Gallery Plugin
 * Plugin URI:        https://example.com/
 * Description:       Adds shortcode with ajax taxonomy filter to portfolio gallery
 * Version:           1.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Chetan Chowdhari
 * Author URI:        https://chowdharichetan.github.io/
 * License:           None
 * License URI:       https://example.com/
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       woocommerce-custom-fields
 * Domain Path:       /languages
 * Text Domain:        portfolio-plugin
 */


// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin directory and URL constants.
define('PORTFOLIO_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PORTFOLIO_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files.
require_once PORTFOLIO_PLUGIN_DIR . 'includes/custom-post-type.php';
require_once PORTFOLIO_PLUGIN_DIR . 'includes/settings-page.php';
require_once PORTFOLIO_PLUGIN_DIR . 'includes/ajax-filter.php';

function portfolio_plugin_enqueue_styles() {
    wp_enqueue_style('styles.css', PORTFOLIO_PLUGIN_DIR . 'includes/css/style.css');
}
add_action('wp_enqueue_scripts', 'portfolio_plugin_enqueue_styles');
