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
        'TW Scripts Viewer',        // The text for the page's <title> tag
        'TW Scripts',               // The text displayed in the menu
        'manage_options',           // The capability required to see this menu (Admins only)
        'tw-scripts-viewer',        // The unique slug for this menu page
        'tw_scripts_render_viewer_page', // The function that will render the page's content (we will create this in the next step)
        'dashicons-media-code',     // The icon to display
        80                          // The position in the menu order
    );
}
add_action( 'admin_menu', 'tw_scripts_add_admin_menu' );

function tw_scripts_enqueue_admin_assets( $hook_suffix ) {
    // The $hook_suffix for our page is 'toplevel_page_tw-scripts-viewer'.
    // This check ensures our CSS only loads on our plugin's page, not everywhere.
    if ( 'toplevel_page_tw-scripts-viewer' !== $hook_suffix ) {
        return;
    }

    // Enqueue our admin-specific stylesheet.
    wp_enqueue_style(
        'tw-scripts-admin-styles',
        TW_SCRIPTS_URL . 'admin/admin-styles.css', // Use the constant we defined
        array(),
        '1.0.0'
    );
}
add_action( 'admin_enqueue_scripts', 'tw_scripts_enqueue_admin_assets' );
