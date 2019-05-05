<?php
namespace Elementor\OTP;

class Plugin {

    public $version = '1.0.0';

    public static $instance = null;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
            do_action( 'elementor_otp/loaded' );
        }
        return self::$instance;
    }

    public function __construct() {
        add_action( 'elementor_pro/init', [ $this, 'init' ] );
    }

    public function init() {
        add_action( 'elementor_otp/init',                        [ $this, 'addfieldTypeSms' ] );
        add_action( 'elementor/editor/after_enqueue_scripts',    [ $this, 'editorEnqueueScripts' ] );
        add_action( 'elementor/frontend/after_register_styles',  [ $this, 'frontRegisterStyles' ] );
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'frontRegisterScripts' ] );

        if ( is_admin() ) {
            new Admin();
        }

        do_action( 'elementor_otp/init' );
    }

    public function frontRegisterStyles() {
        wp_register_style(
            'elementor-otp-frontend',
            plugins_url( '/assets/css/frontend.css', ELEMENTOR_OTP_FILE ),
            [],
            $this->version
        );
    }

    public function frontRegisterScripts() {
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        wp_register_script(
            'jquery-mask',
            plugins_url( '/assets/js/jquery.mask.min.js', ELEMENTOR_OTP_FILE ),
            [ 'jquery' ],
            '1.14.15',
            true
        );

        wp_register_script(
            'elementor-otp-frontend',
            plugins_url( '/assets/js/frontend' . $suffix . '.js', ELEMENTOR_OTP_FILE ),
            [ 'jquery', 'jquery-mask' ],
            $this->version,
            true
        );

        wp_localize_script( 'elementor-otp-frontend', 'elementorOtpFrontendConfig', [
            'placeholder' => __( 'Please type the verification code sent to you', 'elementor-otp' )
        ] );
    }

    public function editorEnqueueScripts() {
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        wp_enqueue_script(
            'jquery-mask',
            plugins_url( '/assets/js/jquery.mask.min.js', ELEMENTOR_OTP_FILE ),
            [ 'jquery' ],
            '1.14.15',
            true
        );

        wp_enqueue_script(
            'elementor-otp-editor',
            plugins_url( '/assets/js/editor' . $suffix . '.js', ELEMENTOR_OTP_FILE ),
            [ 'elementor-pro' ],
            $this->version,
            true
        );
    }

    public function addfieldTypeSms() {
        $fieldTypeSms = new Fields\Sms();
        \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_field_type( $fieldTypeSms->get_name(), $fieldTypeSms );
    }

}