<?php
/**
 * Plugin Name:       TW Scripts
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       A custom script embedding and viewer plugin built for the Theatre West website
 * Version:           1.0.1
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

// Define plugin constants for easy access to paths and URLs throughout the plugin.
define( 'TW_SCRIPTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'TW_SCRIPTS_URL', plugin_dir_url( __FILE__ ) );

// Include the central loader file, which handles including all other PHP files.
require_once TW_SCRIPTS_PATH . 'includes/loader.php';

/**
 * Enqueue scripts and styles for the front end of the website.
 * This function now checks the plugin's settings before enqueuing assets.
 */
function tw_scripts_enqueue_assets() {

    // Get the saved options from the database.
    $options = get_option( 'tw_scripts_options', [] );
	
    // --- Enqueue the main combined stylesheet ---
    // Check if the 'style.css' file is enabled (it's enabled by default if the setting doesn't exist).
    if ( ! isset( $options['style.css'] ) || 'off' !== $options['style.css'] ) {
        wp_enqueue_style(
            'tw-scripts-styles',
            TW_SCRIPTS_URL . 'assets/css/style.css',
            array(),
            '1.0.0'
        );
    }
	
    // --- Enqueue the header fade script ---
    if ( ! isset( $options['header_fade.js'] ) || 'off' !== $options['header_fade.js'] ) {
        wp_enqueue_script(
            'tw-scripts-header-fade',
            TW_SCRIPTS_URL . 'assets/js/header_fade.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
	
    // --- Enqueue the populate fields script ---
    if ( ! isset( $options['populate_fields.js'] ) || 'off' !== $options['populate_fields.js'] ) {
        wp_enqueue_script(
            'tw-scripts-populate-fields',
            TW_SCRIPTS_URL . 'assets/js/populate_fields.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'tw_scripts_enqueue_assets' );
