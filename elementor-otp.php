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

use Elementor\Settings;
use ElementorPro\Modules\Forms\Classes\Form_Record;
use ElementorPro\Plugin;

class ElementorOTP {
    
    public $version = '1.0.0';

    protected static $_components = [];
    
    public function getComponent( $type ) {
        return self::$_components[ $type ] ?? false;
    }
    
    public function getAllComponents() {
        return self::$_components;
    }
    
    public function getComponentTypes() {
        return array_keys( $this->getAllComponents() );
    }
    
    public function addComponent( $component ) {
        self::$_components[ $component->get_type() ] = $component;
        return $this;
    }

    public function __construct() {
        add_action( 'init',               [ $this, 'loadTextDomain' ] );
        add_action( 'elementor_pro/init', [ $this, 'initHooks' ] );
    }

    public function initHooks() {
        add_action( 'elementor_pro/forms/validation',               [ $this, 'otpValidation' ], 10, 2 );
        add_action( 'elementor/frontend/after_register_styles',     [ $this, 'registerStyles' ] );
        add_action( 'elementor/frontend/after_register_scripts',    [ $this, 'registerScripts' ] );
        
        if ( is_admin() ) {
            add_action( 'elementor/admin/after_create_settings/' . Settings::PAGE_ID, [ $this, 'registerAdminFields' ] );
        }
        
        $this->addOtpComponents();
    }

    public function registerAdminFields( Settings $settings ) {
        $settings->add_section( Settings::TAB_INTEGRATIONS, 'twilio', [
            'callback' => function() {
                echo '<hr><h2>' . esc_html__( 'Twilio Verify', 'elementor-otp' ) . '</h2>';
            },
            'fields' => [
                'otp_twilio_api_key' => [
                    'label' => __( 'API Key', 'elementor-otp' ),
                    'field_args' => [
                        'type' => 'text',
                        'desc' => sprintf( __( 'To integrate with our forms you need an <a href="%s" target="_blank">API Key</a>.', 'elementor-otp' ), 'https://www.twilio.com/docs/verify/api/applications' )
                    ]
                ]
            ]
        ] );

        $settings->add_section( Settings::TAB_INTEGRATIONS, 'nexmo', [
            'callback' => function() {
                echo '<hr><h2>' . esc_html__( 'Nexmo', 'elementor-otp' ) . '</h2>';
            },
            'fields' => [
                'otp_nexmo_api_key' => [
                    'label' => __( 'API Key', 'elementor-otp' ),
                    'field_args' => [
                        'type' => 'text'
                    ]
                ],
                'otp_nexmo_api_secret' => [
                    'label' => __( 'API Secret', 'elementor-otp' ),
                    'field_args' => [
                        'type' => 'text',
                        'desc' => sprintf( __( 'To integrate with our forms you need an <a href="%s" target="_blank">API Key</a>.', 'elementor-otp' ), 'https://developer.nexmo.com/verify/overview' )
                    ]
                ]
            ]
        ] );
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

    public function addOtpComponents() {
        $smsComponent = new Elementor\OTP\Components\Sms();
        $this->addComponent( $smsComponent );
        
        Plugin::instance()
            ->modules_manager
            ->get_modules( 'forms' )
            ->add_component( $smsComponent->get_name(), $smsComponent );
    }

    public function getOtpComponent( Form_Record $record ) {
        $fields = $record->get( 'fields' );
        
        foreach ( $fields as $field ) {
            if ( in_array( $field['type'], $this->getComponentTypes() ) ) {
                return $field;
            }
        }

        return false;
    }

    public function getOtpVendor( Form_Record $record ) {
        $fields = $record->get_form_settings( 'form_fields' );

        foreach ( $fields as $field ) {
            if ( ! in_array( $field['field_type'], $this->getComponentTypes() ) ) {
                continue;
            }
            
            $className = ucfirst( $field['otp_vendor'] );
            $className = "Elementor\\OTP\\Vendor\\{$className}";
            
            if ( class_exists( $className ) ) {
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

        // Component
        $component = $this->getOtpComponent( $record );
        if ( ! $component ) {
            return;
        }

        // Vendor
        $vendor = $this->getOtpVendor( $record );
        if ( ! $vendor ) {
            return;
        }
        
        // Handle submission
        $vendor->setHtml( $this->getComponent( $component['type'] )->renderVerificationBox(
            $record->get( 'form_settings' )['id']
        ) )->submit( $component );
    }

}

new ElementorOTP();