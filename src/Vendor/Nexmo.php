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
    
    protected static $html;
    
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
    
    public function setHtml( $html ) {
        self::$html = $html;
        return $this;
    }
    
    public function getHtml() {
        return self::$html;
    }

    public function send( $phone_number ) {
        try {
            $verification = new Verification( $phone_number, get_bloginfo( 'name' ) );
            $this->getClient()->verify()->start( $verification );
        } catch ( Exception $e ) {
            return $this->error( $e->getMessage() );
        }
        
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
    
    public function handleSubmit( $component ) {
        $openVerificationBox = true;
        
        // Check verification code
        if ( ! empty( $_POST['otp-code'] ) && ! empty( $_POST['otp-uuid'] ) ) {
            $request_id = sanitize_text_field( $_POST['otp-uuid'] );
            $code = sanitize_text_field( $_POST['otp-code'] );
            $this->verify( $request_id, $code );
            if ( $this->hasErrors() ) {
                $errorMessage = $this->getErrorMessage();
            } else {
                return;
            }
        
        } elseif ( ! empty( $_POST['otp-uuid'] ) ) {
            
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
            'uuid'    => $this->getRequestId(),
            'otp'     => $openVerificationBox,
        ] );
    }
    
}