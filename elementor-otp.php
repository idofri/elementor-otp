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
        add_action( 'elementor/frontend/after_register_styles',     [ $this, 'registerStyles' ] );
        add_action( 'elementor/frontend/after_register_scripts',    [ $this, 'registerScripts' ] );
        add_action( 'wp_ajax_elementor_pro_forms_send_form',        [ $this, 'ajaxSendForm' ], 1 );
        add_action( 'wp_ajax_nopriv_elementor_pro_forms_send_form', [ $this, 'ajaxSendForm' ], 1 );
    }
    
    public function registerStyles() {
        wp_register_style(
            'featherlight',
            plugins_url( '/assets/lib/featherlight/featherlight.css', __FILE__ ),
            [],
            '1.7.13'
        );
    }

    public function registerScripts() {
        wp_register_script(
            'featherlight',
            plugins_url( '/assets/lib/featherlight/featherlight.js', __FILE__ ),
            [
                'jquery',
            ],
            '1.7.13',
            true
        );
    }

    public function loadTextDomain() {
        load_plugin_textdomain( 'elementor-otp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    public function register() {
        wp_enqueue_script( 'featherlight', THEME_URI . '/admin/assets/js/featherlight/featherlight.js', [ 'jquery' ], '1.7.12', true );
        wp_enqueue_style( 'featherlight', THEME_URI . '/admin/assets/js/featherlight/featherlight.css', [], '1.7.12' );
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
        
        wp_send_json_error( [ 
            'message' => '<script>jQuery.featherlight(jQuery(".elementor-hidden"), {root: ".elementor-form", persist: true});</script>', 
            'errors' => [] 
        ] );
    }
    
}
new ElementorOTP();