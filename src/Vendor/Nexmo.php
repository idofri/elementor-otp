<?php
namespace Elementor\OTP\Vendor;

use Exception;
use Nexmo\Client;
use Nexmo\Client\Credentials\Basic;
use Nexmo\Client\Credentials\Container;
use Nexmo\Verify\Verification;

class Nexmo extends Base {

    const NEXMO_API_KEY = 'a87c8384';

    const NEXMO_API_SECRET = 'BYaew9Hzb8dhvsjj';
    
    protected static $client;

    protected static $credentials;

    protected static $request_id;
    
    public function getClient() {
        if ( is_null( self::$client ) ) {
            self::$client = new Client( new Container( $this->getCredentials() ) );
        }
        return self::$client;
    }

    public function getCredentials() {
        if ( is_null( self::$credentials ) ) {
            self::$credentials = new Basic( self::NEXMO_API_KEY, self::NEXMO_API_SECRET );
        }
        return self::$credentials;
    }
    
    public function setRequestId( $request_id ) {
        self::$request_id = $request_id;
        return $this;
    }
    
    public function getRequestId() {
        return self::$request_id;
    }

    public function send( $phone_number ) {
        try {
            $verification = new Verification( $phone_number, get_bloginfo( 'name' ) );
            $this->getClient()->verify()->start( $verification );
        } catch ( Exception $e ) {
            return $this->error( $e->getMessage() );
        }
        
        error_log( print_r( $verification, true ) );
        $this->setRequestId( $verification->getRequestId() );
    }

    public function verify( $request_id, $code ) {
        try {
            $verification = new Verification( $request_id );
            return $this->getClient()->verify()->check( $verification, $code );
        } catch ( Exception $e ) {
            return $this->error( $e->getMessage() );
        }
    }

    public function error( $message ) {
        self::$errors->add( 'nexmo', __( $message, 'elementor-otp' ) );
        return false;
    }
    
    public function submit( $component ) {
        $openVerificationBox = true;
        
        // Check verification code
        if ( ! empty( $_POST['otp-code'] ) && ! empty( $_POST['otp-token'] ) ) {
            $request_id = sanitize_text_field( $_POST['otp-token'] );
            $code = sanitize_text_field( $_POST['otp-code'] );
            $this->verify( $request_id, $code );
            if ( $this->hasErrors() ) {
                $errorMessage = $this->getErrorMessage();
            } else {
                return;
            }
        
        } elseif ( ! empty( $_POST['otp-token'] ) ) {
            
            $errorMessage = '';
            
        // Send verification code
        } else {
            $this->send( $component['value'] );
            if ( $this->hasErrors() ) {
                $openVerificationBox = false;
                $errorMessage = $this->getErrorMessage();
            } else {
                $errorMessage = __( 'Awaiting verification.', 'elementor-otp' );
            }
        }

        wp_send_json_error( [
            'message' => $errorMessage,
            'errors'  => [],
            'data'    => [],
            'html'    => $this->getHtml(),
            'token'   => $this->getRequestId(),
            'verify'  => $openVerificationBox,
        ] );
    }
    
}