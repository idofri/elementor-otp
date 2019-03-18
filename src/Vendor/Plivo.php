<?php
namespace Elementor\OTP\Vendor;

use Plivo\RestClient;
use PlivoRestException;

class Plivo extends Base {

    const OPTION_NAME_AUTH_ID = 'elementor_otp_plivo_auth_id';

    const OPTION_NAME_AUTH_TOKEN = 'elementor_otp_plivo_auth_token';

    protected static $client;

    public function getClient() {
        if ( is_null( self::$client ) ) {
            self::$client = new RestClient( self::getAuthId(), self::getAuthToken() );
        }
        return self::$client;
    }

    public static function getAuthId() {
        return get_option( self::OPTION_NAME_AUTH_ID );
    }

    public static function getAuthToken() {
        return get_option( self::OPTION_NAME_AUTH_TOKEN );
    }

    public function send( $phone_number ) {
        try {
            $apiResponse = $this->getClient()->messages->create(
                '12345',
                [ $phone_number ],
                'Hello, world!'
            );
        } catch ( PlivoRestException $e ) {
            return $this->error( $e->getMessage() );
        }

        $result = json_decode( $apiResponse );
        if ( ! empty( $result->error ) ) {
            return $this->error( $result->error );
        }

        return true;
    }

    public function verify( $request_id, $code ) {

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
            // 'token'   => $this->getRequestId(),
            'verify'  => $openVerificationBox,
        ] );
    }

}