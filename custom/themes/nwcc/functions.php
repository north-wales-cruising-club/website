<?php
/**
 * Create a shortcode to create a link to PM a user
 *
 * @return string The content to be injected
 */
function bp_private_message_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'to' => ''
    ), $atts));

    if( is_user_logged_in() ) {
        return '<a href="' . wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . $to ) . '" title="Create private message">' . $content . '</a>';
    } else {
        return '[Please <a href="' . wp_login_url() . '">log in</a> to access this link]';
    }
}
add_shortcode( 'bp_privatemessage', 'bp_private_message_shortcode' );