<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Generates the "Elected in" or "Since" text for a board term.
 * CORRECTED VERSION - Expects a data array.
 */
function generate_board_term_title( $data ) {
    // If we didn't get a valid data array, stop.
    if ( empty( $data ) || ! is_array( $data ) ) {
        return '';
    }

    // Get the data directly from the passed array.
    $start_date_str = $data['start_date'] ?? '';

    // Use the correct relationship field name 'board_position'
    $position_data  = $data['board_position'] ?? [];

    if ( empty( $start_date_str ) || empty( $position_data ) ) {
        return '';
    }

    // Load the 'positions' Pod using the ID of the related item.
    $position_pod = pods( 'positions', $position_data['ID'] );
    
    // Check if the Pod object is valid before using it.
    if ( ! $position_pod->exists() ) {
        return '';
    }
    
    $is_board_member = $position_pod->field('is_board');

    // Safely get the year.
    try {
        $year = date( 'Y', strtotime( $start_date_str ) );
    } catch ( Exception $e ) {
        return '';
    }

    // The conditional logic (checking for 1 is correct for the raw DB value).
    if ( $is_board_member == 1 ) {
        $text = 'Elected to the Board of Directors in ' . $year . '.';
    } else {
        $text = 'Since ' . $year . '.';
    }

    // Return the final, formatted HTML.
    return '<h3 class="term-years">' . esc_html( $text ) . '</h3>';
}
