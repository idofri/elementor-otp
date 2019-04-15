<?php
/**
 * Plugin Name: Elementor OTP
 * Description: 
 * Version:     1.0.0
 * Author:      Ido Friedlander
 * Author URI:  https://github.com/idofri
 * Text Domain: elementor-otp
 */

if ( ! version_compare( PHP_VERSION, '5.6', '>=' ) ) {
    add_action( 'admin_notices', 'elementor_otp_fail_php_version' );
} else {
    
}

function elementor_otp_fail_php_version() {
    /* translators: %s: PHP version */
    $message = sprintf( esc_html__( 'Elementor OTP requires PHP version %s+, plugin is currently NOT RUNNING.', 'elementor-otp' ), '5.6' );
    $html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
    echo wp_kses_post( $html_message );
}