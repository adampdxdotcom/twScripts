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
 * Enqueues styles AND scripts specifically for the TW Scripts admin page.
 * This ensures our assets don't load on other admin pages.
 */
function tw_scripts_enqueue_admin_assets( $hook_suffix ) {
    // Determine the hook suffixes for our main page and the new settings page.
    $main_page_hook = 'toplevel_page_tw-scripts-viewer';
    $settings_page_hook = 'tw-scripts_page_tw-scripts-settings'; // The format is parent-slug_page_submenu-slug

    // Only load our assets if we are on one of our plugin's pages.
    if ( $main_page_hook !== $hook_suffix && $settings_page_hook !== $hook_suffix ) {
        return;
    }

    // Enqueue our admin-specific stylesheet (used by both pages).
    wp_enqueue_style(
        'tw-scripts-admin-styles',
        TW_SCRIPTS_URL . 'admin/admin-styles.css',
        array(),
        '1.0.1' // Bumped version
    );

    // --- NEW: Enqueue our admin-specific JavaScript, but ONLY on the viewer page ---
    if ( $main_page_hook === $hook_suffix ) {
        wp_enqueue_script(
            'tw-scripts-admin-scripts',
            TW_SCRIPTS_URL . 'admin/admin-scripts.js',
            array(), // No dependencies
            '1.0.1', // Bumped version
            true     // Load in the footer
        );
    }
}
add_action( 'admin_enqueue_scripts', 'tw_scripts_enqueue_admin_assets' );
