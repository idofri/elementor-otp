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

    protected static $components = [];

    public function getComponent( $type ) {
        return self::$components[ $type ] ?? false;
    }

    public function addComponent( $component ) {
        self::$components[ $component->get_type() ] = $component;
        return $this;
    }

    public function getComponentTypes() {
        return array_keys( self::$components );
    }

    public function __construct() {
        add_action( 'init',               [ $this, 'loadTextDomain' ] );
        add_action( 'elementor_pro/init', [ $this, 'setupHooks' ] );
    }

    public function setupHooks() {
        add_action( 'elementor_otp/init',                           [ $this, 'addComponents' ] );
        add_action( 'elementor_pro/forms/validation',               [ $this, 'otpValidation' ], 10, 2 );
        add_action( 'elementor/frontend/after_register_styles',     [ $this, 'registerStyles' ] );
        add_action( 'elementor/frontend/after_register_scripts',    [ $this, 'registerScripts' ] );

        if ( is_admin() ) {
            new Elementor\OTP\Admin();
        }

        do_action( 'elementor_otp/init' );
    }

    public function registerStyles() {
        wp_register_style( 'featherlight', plugins_url( '/assets/lib/featherlight/featherlight.min.css', __FILE__ ), [], '1.7.6' );
        wp_register_style( 'elementor-otp', plugins_url( '/assets/css/otp.css', __FILE__ ), [], $this->version );
    }

    public function registerScripts() {
        wp_register_script( 'jquery-mask', plugins_url( '/assets/js/jquery.mask.min.js', __FILE__ ), [ 'jquery' ], '1.14.15', true );
        wp_register_script( 'featherlight', plugins_url( '/assets/lib/featherlight/featherlight.min.js', __FILE__ ), [ 'jquery' ], '1.7.6', true );
        wp_register_script( 'elementor-otp', plugins_url( '/assets/js/otp.js', __FILE__ ), [ 'featherlight' ], $this->version, true );
    }

    public function loadTextDomain() {
        load_plugin_textdomain( 'elementor-otp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    public function addComponents() {
        $components = apply_filters( 'elementor_otp/components', [
            new Elementor\OTP\Components\Sms()
        ] );

        foreach ( $components as $component ) {
            $this->addComponent( $component );
            Plugin::instance()->modules_manager->get_modules( 'forms' )->add_component( $component->get_name(), $component );
        }
    }

    public function hasComponent( Form_Record $record ) {
        $fields = $record->get( 'fields' );

        foreach ( $fields as $field ) {
            if ( in_array( $field['type'], $this->getComponentTypes() ) ) {
                return $field;
            }
        }

        return false;
    }

    public function getVendor( Form_Record $record ) {
        $fields = $record->get_form_settings( 'form_fields' );

        foreach ( $fields as $field ) {
            if ( ! in_array( $field['field_type'], $this->getComponentTypes() ) ) {
                continue;
            }

            $vendor = ucfirst( $field['otp_vendor'] );
            $vendor = "Elementor\\OTP\\Vendor\\{$vendor}";
            $vendor = apply_filters( 'elementor_otp/submit/vendor', $vendor, $record );

            if ( class_exists( $vendor ) ) {
                return new $vendor;
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
        $component = $this->hasComponent( $record );
        if ( ! $component ) {
            return;
        }

        // Vendor
        $vendor = $this->getVendor( $record );
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