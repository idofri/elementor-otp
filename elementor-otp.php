<?php
/**
 * Plugin Name: Elementor OTP
 * Description: 
 * Version:     1.0.0
 * Author:      Ido Friedlander
 * Author URI:  https://github.com/idofri
 * Text Domain: elementor-otp
 */

define( 'ELEMENTOR_OTP_FILE', __FILE__ );
define( 'ELEMENTOR_OTP_PHP_VERSION', '5.6' );
define( 'ELEMENTOR_OTP_PLUGIN_BASE', plugin_basename( ELEMENTOR_OTP_FILE ) );

if ( ! version_compare( PHP_VERSION, ELEMENTOR_OTP_PHP_VERSION, '>=' ) ) {
    add_action( 'admin_notices', 'elementor_otp_fail_php_version' );
} else {
    require __DIR__ . '/vendor/autoload.php';
    Elementor\OTP\Plugin::instance();
}

function elementor_otp_load_plugin_textdomain() {
    load_plugin_textdomain( 'elementor-otp', false, dirname( ELEMENTOR_OTP_PLUGIN_BASE ) . '/languages' );
}
add_action( 'init', 'elementor_otp_load_plugin_textdomain' );

function elementor_otp_fail_php_version() {
    /* translators: %s: PHP version */
    $message = sprintf( esc_html__( 'Elementor OTP requires PHP version %s+, plugin is currently NOT RUNNING.', 'elementor-otp' ), ELEMENTOR_OTP_PHP_VERSION );
    $htmlMessage = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
    echo wp_kses_post( $htmlMessage );
}