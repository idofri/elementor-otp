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
use ElementorPro\Modules\Forms\Classes\Form_Record;

class ElementorOTP {

    public $version = '1.0.0';

    protected static $components = [];

    public function addComponent( $component ) {
        self::$components[ $component->get_type() ] = $component;
        return $this;
    }

    public function __construct() {
        add_action( 'init',               [ $this, 'loadTextDomain' ] );
        add_action( 'elementor_pro/init', [ $this, 'setupHooks' ] );
    }

    public function setupHooks() {
        add_action( 'elementor_otp/init',                        [ $this, 'addComponents' ] );
        add_action( 'elementor/editor/after_enqueue_scripts',    [ $this, 'editorEnqueueScripts' ] );
        add_action( 'elementor/frontend/after_register_styles',  [ $this, 'frontRegisterStyles' ] );
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'frontRegisterScripts' ] );

        if ( is_admin() ) {
            new Elementor\OTP\Admin();
        }

        do_action( 'elementor_otp/init' );
    }

    public function frontRegisterStyles() {
        wp_register_style(
            'elementor-otp-frontend',
            plugins_url( '/assets/css/frontend.css', __FILE__ ),
            [],
            $this->version
        );
    }

    public function frontRegisterScripts() {
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        wp_register_script(
            'jquery-mask',
            plugins_url( '/assets/js/jquery.mask.min.js', __FILE__ ),
            [ 'jquery' ],
            '1.14.15',
            true
        );

        wp_register_script(
            'elementor-otp-frontend',
            plugins_url( '/assets/js/frontend' . $suffix . '.js', __FILE__ ),
            [ 'jquery', 'jquery-mask' ],
            $this->version,
            true
        );
    }

    public function editorEnqueueScripts() {
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_script(
            'jquery-mask',
            plugins_url( '/assets/js/jquery.mask.min.js', __FILE__ ),
            [ 'jquery' ],
            '1.14.15',
            true
        );

        wp_enqueue_script(
            'elementor-otp-editor',
            plugins_url( '/assets/js/editor' . $suffix . '.js', __FILE__ ),
            [ 'elementor-pro' ],
            $this->version,
            true
        );
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

}

new ElementorOTP();