<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This is the "single source of truth" for all plugin files.
 * It defines a global variable that the plugin can use for both loading and viewing files.
 */
global $tw_scripts_files;
$tw_scripts_files = [
    'php' => [
        // --- Core Functionality (Loaded Everywhere) ---
        'display_year_only.php'          => TW_SCRIPTS_PATH . 'includes/display_year_only.php',
        'filter_current_post_id.php.php' => TW_SCRIPTS_PATH . 'includes/filter_current_post_id.php.php', // Note: Check for .php.php typo
        'is_board.php'                   => TW_SCRIPTS_PATH . 'includes/is_board.php',
        'leaflet_for_event.php'          => TW_SCRIPTS_PATH . 'includes/leaflet_for_event.php',
        
        // --- Admin Functionality (Loaded in Admin Only) ---
        'admin/menu.php'                 => TW_SCRIPTS_PATH . 'admin/menu.php',
        'admin/page-view.php'            => TW_SCRIPTS_PATH . 'admin/page-view.php',
    ],
    'css' => [
        'style.css' => TW_SCRIPTS_PATH . 'assets/css/style.css',
    ],
    'js' => [
        'header_fade.js'     => TW_SCRIPTS_PATH . 'assets/js/header_fade.js',
        'populate_fields.js' => TW_SCRIPTS_PATH . 'assets/js/populate_fields.js',
    ],
    'admin-css' => [
        'admin-styles.css' => TW_SCRIPTS_PATH . 'admin/admin-styles.css',
    ],
];

/**
 * Automatically load all the necessary PHP files.
 * Admin-specific files are only loaded when in the WordPress admin area.
 */
if ( ! empty( $tw_scripts_files['php'] ) ) {
    foreach ( $tw_scripts_files['php'] as $file_name => $file_path ) {
        // Only load admin files if we are in the admin area.
        if ( strpos( $file_name, 'admin/' ) === 0 && ! is_admin() ) {
            continue;
        }
        
        if ( file_exists( $file_path ) ) {
            require_once $file_path;
        }
    }
}
