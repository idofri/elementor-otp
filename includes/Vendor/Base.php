<?php
namespace Elementor\OTP\Vendor;

use WP_Error;
use ReflectionClass;
use ElementorPro\Modules\Forms\Classes\Form_Record;

abstract class Base {

    protected static $errors;

    abstract public function send( $recipient );

    abstract public function submit( $field, Form_Record $record );

    abstract public function verify( $recipient, $verification_code );

    public function hasErrors() {
        return self::$errors->has_errors();
    }

    public function clearErrors() {
        self::$errors = new WP_Error;
        return $this;
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

    public function __construct() {
        $this->clearErrors();
    }

}