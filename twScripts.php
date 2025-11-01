<?php
/**
 * Plugin Name:       TW Scripts
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       A custom script embedding and viewer plugin built for the Theatre West website
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Adam Michaels
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tw-scripts
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/display_year_only.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/filter_current_post_id.php.php'; // Note: You may have a typo here, ends in .php.php
require_once plugin_dir_path( __FILE__ ) . 'includes/is_board.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/leaflet_for_event.php';

/**
 * Enqueue scripts and styles for the front end.
 */
function tw_scripts_enqueue_assets() {
	
    // Enqueue the main combined stylesheet
    wp_enqueue_style(
        'tw-scripts-styles', // A single, unique handle for your stylesheet
        plugin_dir_url( __FILE__ ) . 'assets/css/style.css', // The path to your new combined file
        array(),
        '1.0.0'
    );
	
    // Enqueue the header fade script
    wp_enqueue_script(
        'tw-scripts-header-fade', // A unique handle for this script
        plugin_dir_url( __FILE__ ) . 'assets/js/header_fade.js',
        array('jquery'), // Assumes this script might need jQuery
        '1.0.0',
        true
    );
	
    // Enqueue the populate fields script
    wp_enqueue_script(
        'tw-scripts-populate-fields', // A unique handle for this script
        plugin_dir_url( __FILE__ ) . 'assets/js/populate_fields.js',
        array('jquery'), // Assumes this script might need jQuery
        '1.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'tw_scripts_enqueue_assets' );
