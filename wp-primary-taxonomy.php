<?php 

/**
 * Plugin Name: WP Primary Taxonomy
 * Plugin URI: https://github.com/seshuen/wp-primary-taxonomy
 * Description: Allow primary taxonomy options for post type and custom post type
 * Author: Seshagopalan Narasimhan
 * Author URI: https://github.com/seshuen
 * Version: 0.0.1
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * Include other dependency
 */
require_once('includes/helper.php');
require_once('includes/settings.php');

/**
 * Create plugin options menu
 */
function wp_primary_taxonomy_plugin_menu() {
    add_options_page( 'WP Primary Taxonomy', 'WP Primary Taxonomy', 'manage_options', 'wp_primary_taxonomy_settings', 'wp_primary_taxonomy_settings');
}
add_action('admin_menu', 'wp_primary_taxonomy_plugin_menu');

/**
 * Add options page to select which post type to have primary taxonomy options
 */
function wp_primary_taxonomy_add_option() {
    add_option('wp_primary_taxonomy_options', '');
}
register_activation_hook(__FILE__, 'wp_primary_taxonomy_add_option');