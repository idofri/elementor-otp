<?php
namespace Elementor\OTP\Vendor;

use WP_Error;

abstract class Base {
    
    protected $errors;

    abstract public function send();
    
    abstract public function verify();

    public function hasErrors() {
        return $this->errors->has_errors();
    }

    public function __construct() {
        $this->errors = new WP_Error;
    }
    
}