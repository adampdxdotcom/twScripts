<?php
// admin/page-view.php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the content for the "TW Scripts" admin viewer page.
 * NEW: Renders a dropdown to select a file to view.
 */
function tw_scripts_render_viewer_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'tw-scripts' ) );
    }

    // This global variable is our "single source of truth" defined in loader.php
    global $tw_scripts_files;
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'TW Scripts Viewer', 'tw-scripts' ); ?></h1>
        <p><?php esc_html_e( 'Select a file from the dropdown to view its contents. This is a read-only view.', 'tw-scripts' ); ?></p>
        
        <?php
        // Check if our global file list exists.
        if ( empty( $tw_scripts_files ) || ! is_array( $tw_scripts_files ) ) {
            echo '<p><strong>' . esc_html__( 'Error:', 'tw-scripts' ) . '</strong> ' . esc_html__( 'Could not find the list of script files.', 'tw-scripts' ) . '</p>';
            return;
        }
        ?>
        
        <!-- The Dropdown Selector -->
        <div class="tw-scripts-selector-wrap">
            <label for="tw-script-selector"><strong>Select a file to view:</strong></label>
            <select id="tw-script-selector" class="tw-scripts-selector">
                <?php
                // Loop through each file type to create <optgroup> labels
                foreach ( $tw_scripts_files as $file_type => $files ) {
                    if ( empty( $files ) ) continue;
                    ?>
                    <optgroup label="<?php echo esc_attr( strtoupper( $file_type ) ); ?> Files">
                        <?php
                        // Loop through each file to create the <option>
                        foreach ( $files as $file_name => $file_path ) {
                            $container_id = 'container-' . sanitize_key( $file_name );
                            echo '<option value="' . esc_attr( $container_id ) . '">' . esc_html( $file_name ) . '</option>';
                        }
                        ?>
                    </optgroup>
                    <?php
                }
                ?>
            </select>
        </div>

        <div id="tw-scripts-code-display">
            <?php
            // Now loop through all the files again to render the code blocks (initially hidden)
            foreach ( $tw_scripts_files as $file_type => $files ) {
                if ( empty( $files ) ) continue;

                foreach ( $files as $file_name => $file_path ) {
                    $container_id = 'container-' . sanitize_key( $file_name );
                    $code_id = 'code-' . sanitize_key( $file_name );
                    ?>
                    <div id="<?php echo esc_attr( $container_id ); ?>" class="tw-scripts-file-container" hidden>
                        <div class="tw-scripts-file-header">
                            <h3 class="tw-scripts-file-name"><?php echo esc_html( $file_name ); ?></h3>
                            <button class="button tw-scripts-copy-btn" data-target="<?php echo esc_attr( $code_id ); ?>">Copy Code</button>
                        </div>
                        <pre class="tw-scripts-code-block"><code id="<?php echo esc_attr( $code_id ); ?>"><?php
                            $file_content = file_exists( $file_path ) ? file_get_contents( $file_path ) : 'Error: File not found.';
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
