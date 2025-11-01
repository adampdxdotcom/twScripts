add_shortcode( 'leaflet_for_event', function( $atts ) {
    global $post;
    $id = $post ? $post->ID : 0;
    if ( ! $id ) return '';

    if ( function_exists('pods') ) {
        $pod = pods( 'event', $id );
        $address = $pod && $pod->exists() ? $pod->field( 'address' ) : '';
    } else {
        $address = '';
    }
    if ( empty( $address ) ) return '';

    // Settings
    $zoom = 18;        // one level closer
    $height = '350px'; // adjust if needed

    // Build map + marker
    $map_html = do_shortcode(
        '[leaflet-map address="' . esc_attr( $address ) . '" zoom=' . intval( $zoom ) .
        ' height=' . esc_attr( $height ) . ' scrollwheel=yes zoomcontrol=yes]' .
        '[leaflet-marker address="' . esc_attr( $address ) . '"]' . esc_html( $address ) . '[/leaflet-marker]'
    );

    // Google Maps link
    $google_url = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $address );

    return $map_html . '<p style="margin-top:8px;"><a href="' . esc_url( $google_url ) . 
           '" target="_blank" rel="noopener">Open in Google Maps</a></p>';
} );
