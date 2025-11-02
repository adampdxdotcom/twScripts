<?php
// admin/page-view.php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the content for the "TW Scripts" admin viewer page.
 * FINAL: Now adds the necessary classes for Prism.js syntax highlighting.
 */
function tw_scripts_render_viewer_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'tw-scripts' ) );
    }

    global $tw_scripts_files;
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'TW Scripts Viewer', 'tw-scripts' ); ?></h1>
        <p><?php esc_html_e( 'Select a file from the dropdown to view its contents. This is a read-only view.', 'tw-scripts' ); ?></p>
        
        <?php
        if ( empty( $tw_scripts_files ) || ! is_array( $tw_scripts_files ) ) {
            echo '<p><strong>' . esc_html__( 'Error:', 'tw-scripts' ) . '</strong> ' . esc_html__( 'Could not find the list of script files.', 'tw-scripts' ) . '</p>';
            return;
        }
        ?>
        
        <div class="tw-scripts-selector-wrap">
            <label for="tw-script-selector"><strong>Select a file to view:</strong></label>
            <select id="tw-script-selector" class="tw-scripts-selector">
                <?php
                foreach ( $tw_scripts_files as $file_type => $files ) {
                    if ( empty( $files ) ) continue;
                    ?>
                    <optgroup label="<?php echo esc_attr( strtoupper( $file_type ) ); ?> Files">
                        <?php
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
            foreach ( $tw_scripts_files as $file_type => $files ) {
                if ( empty( $files ) ) continue;

                foreach ( $files as $file_name => $file_path ) {
                    $container_id = 'container-' . sanitize_key( $file_name );
                    $code_id = 'code-' . sanitize_key( $file_name );
                    
                    // --- NEW: Determine the correct language class for Prism ---
                    $language_class = $file_type;
                    // Handle special cases like 'admin-css' which should be treated as 'css'
                    if ( strpos( $language_class, 'css' ) !== false ) {
                        $language_class = 'css';
                    }
                    ?>
                    <div id="<?php echo esc_attr( $container_id ); ?>" class="tw-scripts-file-container" hidden>
                        <div class="tw-scripts-file-header">
                            <h3 class="tw-scripts-file-name"><?php echo esc_html( $file_name ); ?></h3>
                            <button class="button tw-scripts-copy-btn" data-target="<?php echo esc_attr( $code_id ); ?>">Copy Code</button>
                        </div>
                        
                        <!-- NEW: Added 'line-numbers' class to <pre> for line numbering -->
                        <pre class="tw-scripts-code-block line-numbers">
                            <!-- NEW: Added 'language-...' class to <code> for syntax highlighting -->
                            <code id="<?php echo esc_attr( $code_id ); ?>" class="language-<?php echo esc_attr( $language_class ); ?>"><?php
                                $file_content = file_exists( $file_path ) ? file_get_contents( $file_path ) : 'Error: File not found.';
                                echo esc_html( $file_content );
                            ?></code>
                        </pre>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <?php
}
