<?php
/**
 * Plugin Name:       TW Scripts
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       A custom script embedding and viewer plugin built for the Theatre West website
 * Version:           1.1.0
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
 * This function now dynamically loads all assets found in the /site-scripts/ folder.
 */
function tw_scripts_enqueue_assets() {

    // These globals are defined and populated in loader.php
    global $tw_scripts_files;
    global $tw_scripts_options; // The saved on/off switch settings

    // --- Dynamically Enqueue CSS Files ---
    if ( ! empty( $tw_scripts_files['css'] ) ) {
        foreach ( $tw_scripts_files['css'] as $file_name => $file_path ) {
            // Check if this file is turned off in settings.
            if ( isset( $tw_scripts_options[ $file_name ] ) && 'off' === $tw_scripts_options[ $file_name ] ) {
                continue;
            }
            // Create a unique handle from the filename.
            $handle = 'tw-script-' . sanitize_key( $file_name );
            // Get the correct URL for the file.
            $file_url = str_replace( TW_SCRIPTS_PATH, TW_SCRIPTS_URL, $file_path );
            
            wp_enqueue_style( $handle, $file_url, array(), '1.1.0' );
        }
    }
	
    // --- Dynamically Enqueue JS Files ---
    if ( ! empty( $tw_scripts_files['js'] ) ) {
        foreach ( $tw_scripts_files['js'] as $file_name => $file_path ) {
            // Check if this file is turned off in settings.
            if ( isset( $tw_scripts_options[ $file_name ] ) && 'off' === $tw_scripts_options[ $file_name ] ) {
                continue;
            }
            // Create a unique handle from the filename.
            $handle = 'tw-script-' . sanitize_key( $file_name );
            // Get the correct URL for the file.
            $file_url = str_replace( TW_SCRIPTS_PATH, TW_SCRIPTS_URL, $file_path );
            
            wp_enqueue_script( $handle, $file_url, array('jquery'), '1.1.0', true );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'tw_scripts_enqueue_assets' );
