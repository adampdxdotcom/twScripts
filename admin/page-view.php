<?php
// admin/page-view.php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the content for the "TW Scripts" admin viewer page.
 */
function tw_scripts_render_viewer_page() {
    // Check user capabilities (ensure only admins can see this page).
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'tw-scripts' ) );
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'TW Scripts Viewer', 'tw-scripts' ); ?></h1>
        <p><?php esc_html_e( 'Below you can view the code for all PHP, CSS, and JavaScript files bundled with this plugin. This is a read-only view.', 'tw-scripts' ); ?></p>

        <div id="tw-scripts-code-display">
            <?php // The actual code display logic will go here in the next step ?>
            <p>Loading script files...</p>
        </div>
    </div>
    <?php
}
