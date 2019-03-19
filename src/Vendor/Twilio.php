<?php
namespace Elementor\OTP\Vendor;

class Twilio extends Base {

    const COUNTRY_CODE = 972;

    const OPTION_NAME_API_KEY = 'elementor_otp_twilio_api_key';

    protected static $via = 'sms';

    protected static $uuid;

    protected static $client;

    public function getClient() {
        if ( is_null( self::$client ) ) {
            self::$client = new Authy( $this->getApiKey() );
        }
        return self::$client;
    }

    public static function getApiKey() {
        return get_option( self::OPTION_NAME_API_KEY );
    }

    public function setViaMethod( $via) {
        self::$via = $via;
        return $this;
    }

    public function getViaMethod() {
        return self::$via;
    }

    public function setUuid( $uuid ) {
        self::$uuid = $uuid;
        return $this;
    }

    public function getUuid() {
        return self::$uuid;
    }

    public function send( $phone_number ) {
        $res = $this->getClient()->phoneVerificationStart( $phone_number, self::COUNTRY_CODE, $this->getViaMethod() );

        if ( $res->ok() ) {
            $this->setUuid( $res->bodyvar( 'uuid' ) );
            return;
        }

        return $this->error( $res );
    }

    public function verify( $phone_number, $verification_code ) {
        $res = $this->getClient()->phoneVerificationCheck( $phone_number, '972', $verification_code );

        if ( $res->ok() ) {
            return true;
        }

        return $this->error( $res );
    }

    public function status( $uuid ) {
        $res = $this->getClient()->phoneVerificationStatus( $uuid );

        if ( $res->ok() ) {
            return $res;
        }

        return $this->error( $res );
    }

    public function error( $res ) {
        $errorCode = $res->bodyvar( 'error_code' );
        $errorMessage = $res->bodyvar( 'message' );
        self::$errors->add( $errorCode, __( $errorMessage, 'elementor-otp' ) );
        return false;
    }

    public function submit( $component ) {
        $openVerificationBox = true;

        // Check verification code
        if ( ! empty( $_POST['otp-code'] ) ) {
            $code = sanitize_text_field( $_POST['otp-code'] );
            $this->verify( $component['value'], $code );
            if ( $this->hasErrors() ) {
                $errorMessage = $this->getErrorMessage();
            } else {
                return;
            }

        // Start verification using UUID
        } elseif ( ! empty( $_POST['otp-token'] ) ) {
            $uuid = sanitize_text_field( $_POST['otp-token'] );
            $this->status( $uuid );
            if ( $this->hasErrors() ) {
                $errorMessage = $this->getErrorMessage();

                // Invalid UUID - resend verification code
                $this->clearErrors()->send( $component['value'], 972 );
                if ( $this->hasErrors() ) {
                    $openVerificationBox = false;
                    $errorMessage = $this->getErrorMessage();
                }
            }

        // Send verification code
        } else {
            $this->send( $component['value'], 972 );
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
            'token'   => $this->getUuid(),
            'verify'  => $openVerificationBox,
        ] );
    }

}