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

        return $this->setErrorMessage( $res->bodyvar( 'message' ) );
    }

    public function verify( $phone_number, $verification_code ) {
        $res = $this->getClient()->phoneVerificationCheck( $phone_number, self::COUNTRY_CODE, $verification_code );

        if ( $res->ok() ) {
            return true;
        }

        return $this->setErrorMessage( $res->bodyvar( 'message' ) );
    }

    public function submit( $field, $record ) {
        $verify = true;
        $message = __( 'Awaiting verification.', 'elementor-otp' );

        // Check verification code
        if ( ! empty( $_POST['otp-code'] ) ) {
            $code = sanitize_text_field( $_POST['otp-code'] );
            $this->verify( $field['value'], $code );
            if ( $this->hasErrors() ) {
                $message = $this->getErrorMessage();
            } else {
                return;
            }

        // Send verification code
        } else {
            $this->send( $field['value'] );
            if ( $this->hasErrors() ) {
                $verify = false;
                $message = $this->getErrorMessage();
            }
        }

        $this->sendJsonError( $message, $this->getUuid(), $verify );
    }

}