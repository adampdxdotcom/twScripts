<?php
// includes/loader.php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dynamically find and load all site scripts, and manually load the plugin framework.
 */
global $tw_scripts_files;
$tw_scripts_files = []; // Initialize as an empty array.

// --- 1. AUTOMATICALLY SCAN FOR SITE SCRIPTS ---
$site_scripts_path = TW_SCRIPTS_PATH . 'site-scripts/';
$script_types = [
    'php' => '*.php',
    'css' => '*.css',
    'js'  => '*.js',
];

foreach ( $script_types as $type => $extension ) {
    $files = glob( $site_scripts_path . $type . '/' . $extension );
    if ( ! empty( $files ) ) {
        foreach ( $files as $file_path ) {
            $file_name = basename( $file_path );
            // Add the found file to our global list for the viewer.
            $tw_scripts_files[ $type ][ $file_name ] = $file_path;
        }
    }
}


// --- 2. MANUALLY LOAD THE PLUGIN FRAMEWORK ---
// These are the files that run the plugin itself. They are not shown in the viewer.
$framework_files = [
    TW_SCRIPTS_PATH . 'admin/menu.php',
    TW_SCRIPTS_PATH . 'admin/page-view.php',
    TW_SCRIPTS_PATH . 'admin/settings-page.php',
];

foreach ( $framework_files as $file_path ) {
    // Only load admin files if we are in the admin area.
    if ( strpos( $file_path, '/admin/' ) !== false && ! is_admin() ) {
        continue;
    }

    if ( file_exists( $file_path ) ) {
        require_once $file_path;
    }
}


// --- 3. LOAD THE SITE SCRIPTS (PHP ONLY) ---
// Get the saved options from the database.
$tw_scripts_options = get_option( 'tw_scripts_options', [] );

if ( ! empty( $tw_scripts_files['php'] ) ) {
    foreach ( $tw_scripts_files['php'] as $file_name => $file_path ) {
        // Check if the script is disabled via the settings page.
        if ( isset( $tw_scripts_options[ $file_name ] ) && 'off' === $tw_scripts_options[ $file_name ] ) {
            continue; // Skip this file.
        }
        
        if ( file_exists( $file_path ) ) {
            require_once $file_path;
        }
    }
}
