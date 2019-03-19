<?php
namespace Elementor\OTP\Vendor;

use Exception;
use Nexmo\Client;
use Nexmo\Verify\Verification;
use Nexmo\Client\Credentials\Basic;
use Nexmo\Client\Credentials\Container;

class Nexmo extends Base {

    const OPTION_NAME_API_KEY = 'elementor_otp_nexmo_api_key';

    const OPTION_NAME_API_SECRET = 'elementor_otp_nexmo_api_secret';

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
            self::$credentials = new Basic( self::getApiKey(), self::getApiSecret() );
        }
        return self::$credentials;
    }

    public static function getApiKey() {
        return get_option( self::OPTION_NAME_API_KEY );
    }

    public static function getApiSecret() {
        return get_option( self::OPTION_NAME_API_SECRET );
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

            $errorMessage = __( 'Awaiting verification.', 'elementor-otp' );

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