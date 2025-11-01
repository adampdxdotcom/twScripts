<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

add_filter( 'render_block', function( $block_content, $block ) {
    // Only act on Shortcode block and when token present
    if ( isset( $block['blockName'] ) && $block['blockName'] === 'core/shortcode'
         && strpos( $block_content, '%CURRENT_POST_ID%' ) !== false ) {

        // get_the_ID() is set to the Query Loop item while inner blocks render
        $loop_id = get_the_ID();
        if ( $loop_id ) {
            $block_content = str_replace( '%CURRENT_POST_ID%', intval( $loop_id ), $block_content );
        }
    }
    return $block_content;
}, 10, 2 );
