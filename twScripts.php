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
 * Text Domain:       tw-calendar
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/display_year_only.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/filter_current_post_id.php.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/is_board.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/leaflet_for_event.php';

/** Enqueue scripts and styles. */
function tw_calendar_enqueue_assets() {
	
    // Enqueue the main stylesheet
    wp_enqueue_style(
        'tw-calendar-styles', // A unique name (handle) for our stylesheet
        plugin_dir_url( __FILE__ ) . 'assets/css/global-and-layout.css', // The full URL to the stylesheet
        array(), // An array of stylesheet handles this style depends on
        '1.0.0'  // The version of your stylesheet
    );

    wp_enqueue_style(
        'tw-calendar-styles', // A unique name (handle) for our stylesheet
        plugin_dir_url( __FILE__ ) . 'assets/css/navigation.css', // The full URL to the stylesheet
        array(), // An array of stylesheet handles this style depends on
        '1.0.0'  // The version of your stylesheet
    );

    wp_enqueue_style(
        'tw-calendar-styles', // A unique name (handle) for our stylesheet
        plugin_dir_url( __FILE__ ) . 'assets/css/pages.css', // The full URL to the stylesheet
        array(), // An array of stylesheet handles this style depends on
        '1.0.0'  // The version of your stylesheet
    );

    wp_enqueue_style(
        'tw-calendar-styles', // A unique name (handle) for our stylesheet
        plugin_dir_url( __FILE__ ) . 'assets/css/responsive.css', // The full URL to the stylesheet
        array(), // An array of stylesheet handles this style depends on
        '1.0.0'  // The version of your stylesheet
    );
	
    // Enqueue the scroller script
    wp_enqueue_script(
        'tw-calendar-scroller', // A unique name (handle) for our script
        plugin_dir_url( __FILE__ ) . 'assets/js/header_fade.js', // The full URL to the script
        array(), // An array of script handles this script depends on (e.g., 'jquery')
        '1.0.0', // The version of your script
        true     // Load the script in the footer
    );
	
	    // Enqueue the modal window script
    wp_enqueue_script(
        'tw-calendar-modal-window', // A unique name (handle) for our script
        plugin_dir_url( __FILE__ ) . 'assets/js/populate_fields.js', // The full URL to the script
        array(), // An array of script handles this script depends on (e.g., 'jquery')
        '1.0.0', // The version of your script
        true     // Load the script in the footer
    );
}
add_action( 'wp_enqueue_scripts', 'tw_calendar_enqueue_assets' );
