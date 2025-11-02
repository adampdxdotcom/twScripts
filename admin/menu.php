<?php
// admin/menu.php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds the "TW Scripts" menu item to the WordPress admin sidebar.
 */
function tw_scripts_add_admin_menu() {
    add_menu_page(
        'TW Scripts Viewer',
        'TW Scripts',
        'manage_options',
        'tw-scripts-viewer',
        'tw_scripts_render_viewer_page',
        'dashicons-media-code',
        80
    );
}
add_action( 'admin_menu', 'tw_scripts_add_admin_menu' );


/**
 * Enqueues styles AND scripts specifically for the TW Scripts admin pages.
 * This ensures our assets don't load on other admin pages.
 */
function tw_scripts_enqueue_admin_assets( $hook_suffix ) {
    // Determine the hook suffixes for our main page and the settings page.
    $main_page_hook = 'toplevel_page_tw-scripts-viewer';
    $settings_page_hook = 'tw-scripts_page_tw-scripts-settings';

    // Only load our assets if we are on one of our plugin's pages.
    if ( $main_page_hook !== $hook_suffix && $settings_page_hook !== $hook_suffix ) {
        return;
    }

    // --- Enqueue assets that are needed on BOTH the viewer and settings page ---
    wp_enqueue_style(
        'tw-scripts-admin-styles',
        TW_SCRIPTS_URL . 'admin/admin-styles.css',
        array(),
        '1.1.0' // Version bump
    );

    // --- Enqueue assets that are ONLY needed on the viewer page ---
    if ( $main_page_hook === $hook_suffix ) {
        
        // --- NEW: Enqueue the Prism.js CSS for syntax highlighting ---
        wp_enqueue_style(
            'tw-scripts-prism-styles',
            TW_SCRIPTS_URL . 'assets/vendor/prism.css',
            array('tw-scripts-admin-styles'), // Depends on our main style
            '1.1.0'
        );
        
        // --- NEW: Enqueue the Prism.js library ---
        wp_enqueue_script(
            'tw-scripts-prism-js',
            TW_SCRIPTS_URL . 'assets/vendor/prism.js',
            array(),
            '1.1.0',
            true // Load in footer
        );
        
        // Enqueue our custom admin script for dropdowns and copy buttons.
        wp_enqueue_script(
            'tw-scripts-admin-scripts',
            TW_SCRIPTS_URL . 'admin/admin-scripts.js',
            array('tw-scripts-prism-js'), // Make it depend on Prism
            '1.1.0',
            true // Load in footer
        );
    }
}
add_action( 'admin_enqueue_scripts', 'tw_scripts_enqueue_admin_assets' );
