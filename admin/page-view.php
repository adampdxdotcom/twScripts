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

    // This global variable is our "single source of truth" defined in loader.php
    global $tw_scripts_files;
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'TW Scripts Viewer', 'tw-scripts' ); ?></h1>
        <p><?php esc_html_e( 'Below you can view the code for all PHP, CSS, and JavaScript files bundled with this plugin. This is a read-only view.', 'tw-scripts' ); ?></p>

        <div id="tw-scripts-code-display">
            <?php
            // Check if our global file list exists. If not, something went wrong with the loader.
            if ( empty( $tw_scripts_files ) || ! is_array( $tw_scripts_files ) ) {
                echo '<p><strong>' . esc_html__( 'Error:', 'tw-scripts' ) . '</strong> ' . esc_html__( 'Could not find the list of script files.', 'tw-scripts' ) . '</p>';
                return; // Stop rendering the rest of the page.
            }

            // Loop through each file type (php, css, js).
            foreach ( $tw_scripts_files as $file_type => $files ) {
                if ( empty( $files ) ) {
                    continue; // Skip if there are no files of this type.
                }
                ?>
                <h2 class="tw-scripts-file-type-heading"><?php echo esc_html( strtoupper( $file_type ) ); ?> Files</h2>
                <?php
                // Loop through each file in the current type.
                foreach ( $files as $file_name => $file_path ) {
                    ?>
                    <div class="tw-scripts-file-container">
                        <h3 class="tw-scripts-file-name"><?php echo esc_html( $file_name ); ?></h3>
                        <pre class="tw-scripts-code-block"><code><?php
                            // Read the contents of the file.
                            $file_content = file_exists( $file_path ) ? file_get_contents( $file_path ) : 'Error: File not found.';
                            // Safely display the contents. esc_html() is crucial for security!
                            echo esc_html( $file_content );
                        ?></code></pre>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <?php
}
