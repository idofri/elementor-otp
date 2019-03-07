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

use ElementorPro\Modules\Forms\Classes\Form_Record;
use ElementorPro\Plugin;

class ElementorOTP {
    
    public $version = '1.0.0';
    
    protected static $_component;
    
    public static function getComponent() {
        if ( is_null( self::$_component ) ) {
            self::$_component = new Elementor\OTP\Component();
        }
        return self::$_component;
    }
    
    public function __construct() {
        add_action( 'init',                                         [ $this, 'loadTextDomain' ] );
        add_action( 'elementor_pro/init',                           [ $this, 'addOtpComponent' ] );
        add_action( 'elementor_pro/forms/validation',               [ $this, 'otpValidation' ], 10, 2 );
        add_action( 'elementor/frontend/after_register_styles',     [ $this, 'registerStyles' ] );
        add_action( 'elementor/frontend/after_register_scripts',    [ $this, 'registerScripts' ] );
    }
    
    public function registerStyles() {
        wp_register_style( 'featherlight', plugins_url( '/assets/lib/featherlight/featherlight.css', __FILE__ ), [], '1.7.13' );
        wp_register_style( 'elementor-otp', plugins_url( '/assets/css/otp.css', __FILE__ ), [], $this->version );
    }

    public function registerScripts() {
        wp_register_script( 'featherlight', plugins_url( '/assets/lib/featherlight/featherlight.js', __FILE__ ), [ 'jquery' ], '1.7.13', true );
        wp_register_script( 'elementor-otp', plugins_url( '/assets/js/otp.js', __FILE__ ), [ 'featherlight' ], $this->version, true );
    }

    public function loadTextDomain() {
        load_plugin_textdomain( 'elementor-otp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    public function addOtpComponent() {
        Plugin::instance()
            ->modules_manager
            ->get_modules( 'forms' )
            ->add_component( $this->getComponent()->get_name(), $this->getComponent() );
    }
    
    public function getOtpComponent( Form_Record $record ) {
        $fields = $record->get( 'fields' );
        $type = $this->getComponent()->get_type();
        
        foreach ( $fields as $field ) {
            if ( $type === $field['type'] ) {
                return $field;
            }
        }

        return false;
    }

    public function getOtpVendor( Form_Record $record ) {
        $fields = $record->get_form_settings( 'form_fields' );
        $type = $this->getComponent()->get_type();

        foreach ( $fields as $field ) {
            if ( $type === $field['field_type'] ) {
                $className = ucfirst( $field['otp_vendor'] );
                $className = 'Elementor\OTP\Vendor\' . $className;
                return new $className();
            }
        }

        return false;
    }
    
    public function otpValidation( $record, $ajax_handler ) {
        // Form has errors
        if ( ! $ajax_handler->is_success ) {
            return;
        }
        
        // No OTP component
        $component = $this->getOtpComponent( $record );
        if ( ! $component ) {
            return;
        }

        // Vendor
        $vendor = $this->getOtpVendor( $record );
        echo '<pre>';
        print_r($vendor);
        exit;

        $errorMessage = __( 'Verification code is incorrect.', 'elementor-otp' );
        wp_send_json_error( [
            'message' => $errorMessage,
            'errors'  => [],
            'data'    => []
        ] );
    }
    
}
new ElementorOTP();