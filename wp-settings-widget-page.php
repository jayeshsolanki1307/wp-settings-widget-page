<?php
/**
 * Plugin Name: WP Settings & Widget Page
 * Description: A cutom plugin to create a settings page and a widget.
 * Version: 1.0
 * Author: Jayehs Solanki
 * Text Domain: wpswp
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if( !defined('ABSPATH')){
    exit; // Exit if access directly
}

// constant variable for plugin include directory.
define('PLUGIN_INC_DIR', plugin_dir_path( __FILE__ ) . 'includes/');

// Include setting and widget file.
require_once PLUGIN_INC_DIR . 'class-settings-page.php';
require_once PLUGIN_INC_DIR . 'class-widget-page.php';

/**
 * Initialize plugin class.
 */
function wp_settings_widget_page_init(){
    new WPSWP_Settings_Page();
    new WPSWP_Widget_Page();
}
add_action( 'plugins_loaded', 'wp_settings_widget_page_init' );