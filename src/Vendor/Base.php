<?php
namespace Elementor\OTP\Vendor;

use WP_Error;

abstract class Base {
    
    protected static $errors;

    abstract public function send( $recipient );
    
    abstract public function verify( $recipient, $verification_code );

    public function hasErrors() {
        return self::$errors->has_errors();
    }
    
    public function clearErrors() {
        self::$errors = new WP_Error;
        return $this;
    }
    
    public function getErrorMessage() {
        $errorMessages = self::$errors->get_error_messages();
        return reset( $errorMessages );
    }

    public function __construct() {
        $this->clearErrors();
    }
    
}