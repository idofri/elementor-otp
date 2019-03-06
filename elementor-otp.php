<?php
/**
 * Plugin Name: Elementor OTP
 * Description: 
 * Version:     1.0.0
 * Author:      Ido Friedlander
 * Author URI:  https://github.com/idofri
 * Text Domain: elementor-otp
 */

require __DIR__ . '/vendor/autoload.php';

use ElementorPro\Plugin;

class ElementorOTP {
    
    public function __construct() {
        add_action( 'init',                                         [ $this, 'loadTextDomain' ] );
        add_action( 'elementor_pro/init',                           [ $this, 'init' ] );
        add_action( 'wp_ajax_elementor_pro_forms_send_form',        [ $this, 'ajaxSendForm' ], 1 );
        add_action( 'wp_ajax_nopriv_elementor_pro_forms_send_form', [ $this, 'ajaxSendForm' ], 1 );
    }
    
    public function loadTextDomain() {
        load_plugin_textdomain( 'elementor-otp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    public function init() {
        $otp = new Elementor\OTP\Field();
        Plugin::instance()->modules_manager->get_modules( 'forms' )->add_component( $otp->get_name(), $otp );
    }
    
    public function ajaxSendForm() {
        sleep(3);
        
        echo '<pre>';
        print_r($_POST);
        exit;
        
        wp_send_json_error( [ 'message' => '<script>alert()</script>', 'errors' => [] ] );
    }
    
}
new ElementorOTP();