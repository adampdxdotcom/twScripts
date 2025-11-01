/**
 * A simple, reliable function to extract the 4-digit year from a date string.
 * This will be called from a Pods Template.
 * Function name: pods_year_only
 */
function pods_year_only( $date_string ) {
    // If the incoming date string is empty, return nothing.
    if ( empty( $date_string ) ) {
        return '';
    }

    // Convert the date string to a timestamp, then format it to get only the year.
    // This is the safest way to handle date formatting in PHP.
    $timestamp = strtotime( $date_string );

    // If the date was invalid, strtotime returns false. Return nothing in that case.
    if ( $timestamp === false ) {
        return '';
    }

    // If successful, return the 4-digit year.
    return date( 'Y', $timestamp );
}
