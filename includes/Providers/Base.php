<?php
namespace Elementor\OTP\Providers;

use WP_Error;
use ReflectionClass;

abstract class Base {

    private static $errors;

    private static $settings = [];

    abstract public function submit( $field );

    abstract public function send( $recipient );

    abstract public function verify( $recipient, $verification_code );

    public function hasErrors() {
        return self::$errors->has_errors();
    }

    public function getErrorCode() {
        return strtolower( ( new ReflectionClass( $this ) )->getShortName() );
    }

    public function setErrorMessage( $message ) {
        self::$errors->add( $this->getErrorCode(), __( $message, 'elementor-otp' ) );
    }

    public function getErrorMessage() {
        $errorMessages = self::$errors->get_error_messages();
        return reset( $errorMessages );
    }

    public function sendJsonError( $message, $token, $verify ) {
        wp_send_json_error( [
            'message' => $message,
            'errors'  => [],
            'data'    => [],
            'token'   => $token,
            'verify'  => $verify
        ] );
    }

    public function getSettings() {
        return self::$settings;
    }

    public function __construct( Array $settings ) {
        self::$settings = $settings;
        self::$errors = new WP_Error;
    }

}