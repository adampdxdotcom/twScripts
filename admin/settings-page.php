<?php
// admin/settings-page.php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add a "Settings" submenu page under the main "TW Scripts" menu.
 */
function tw_scripts_add_settings_submenu_page() {
    add_submenu_page(
        'tw-scripts-viewer',           // Parent menu slug
        'TW Scripts Settings',         // Page title
        'Settings',                    // Menu title
        'manage_options',              // Capability
        'tw-scripts-settings',         // Menu slug
        'tw_scripts_render_settings_page' // Function to display the page
    );
}
add_action( 'admin_menu', 'tw_scripts_add_settings_submenu_page' );

/**
 * Register the settings, sections, and fields for our settings page.
 */
function tw_scripts_register_settings() {
    // Register the master option that will store all our switch states in an array.
    register_setting(
        'tw_scripts_settings_group', // A name for the group of settings.
        'tw_scripts_options'         // The name of the option saved in the database.
    );

    // Create a section for the switches.
    add_settings_section(
        'tw_scripts_main_section',            // A unique ID for the section.
        'Enable / Disable Scripts',           // The title of the section.
        'tw_scripts_main_section_callback', // A function to render introductory text (optional).
        'tw-scripts-settings'                 // The page slug where this section should appear.
    );
    
    // Dynamically create a settings field for every file in our global list.
    global $tw_scripts_files;
    if ( ! empty( $tw_scripts_files ) && is_array( $tw_scripts_files ) ) {
        foreach ( $tw_scripts_files as $type => $files ) {
            foreach ( $files as $file_name => $file_path ) {
                add_settings_field(
                    'toggle_' . sanitize_key( $file_name ), // A unique ID for the field.
                    $file_name,                             // The label for the field.
                    'tw_scripts_render_toggle_field',       // The function that will render the checkbox.
                    'tw-scripts-settings',                  // The page slug.
                    'tw_scripts_main_section',              // The section ID.
                    ['key' => $file_name]                   // Pass the filename to the render function.
                );
            }
        }
    }
}
add_action( 'admin_init', 'tw_scripts_register_settings' );

/**
 * Render the introductory text for the settings section.
 */
function tw_scripts_main_section_callback() {
    echo '<p>Use these switches to turn individual plugin components on or off. Disabled files will not be loaded.</p>';
}

/**
 * Render the HTML for a single on/off checkbox field.
 */
function tw_scripts_render_toggle_field( $args ) {
    // Get all our saved options from the database.
    $options = get_option( 'tw_scripts_options' );
    $key = $args['key'];

    // Check the state. A script is 'on' if its key is NOT set to 'off'.
    // This makes 'on' the default state for any new scripts.
    $is_checked = ( ! isset( $options[ $key ] ) || $options[ $key ] !== 'off' );
    
    // The value when checked is 'on', and we use a hidden field for the 'off' state.
    ?>
    <label for="<?php echo esc_attr( $key ); ?>">
        <input type="hidden" name="tw_scripts_options[<?php echo esc_attr( $key ); ?>]" value="off">
        <input type="checkbox" name="tw_scripts_options[<?php echo esc_attr( $key ); ?>]" value="on" <?php checked( $is_checked, true ); ?>>
        Enabled
    </label>
    <?php
}

/**
 * Render the full settings page with the form.
 */
function tw_scripts_render_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // Output security fields for the registered setting group.
            settings_fields( 'tw_scripts_settings_group' );
            // Output the sections and fields for this page.
            do_settings_sections( 'tw-scripts-settings' );
            // Output the save changes button.
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}
