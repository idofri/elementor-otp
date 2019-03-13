<?php
namespace Elementor\OTP\Vendor;

use Authy\AuthyApi;

class Twilio extends Base {
    
    const OPTION_NAME_API_KEY = 'elementor_otp_twilio_api_key';
    
    public static function getApiKey() {
        return get_option( self::OPTION_NAME_API_KEY );
    }

    public function send( $phone_number, $country_code, $via = 'sms', $code_length = 4, $locale = null ) {
        $authyApi = new AuthyApi( $this->getApiKey() );
        $res = $authyApi->phoneVerificationStart( $phone_number, $country_code, $via, $code_length, $locale );

        if ( $res->ok() ) {
            return true;
        }
        
        $errorCode = $res->bodyvar( 'error_code' );
        $errorMessage = $res->bodyvar( 'message' );
        self::$errors->add( $errorCode, __( $errorMessage, 'elementor-otp' ) );
        return false;
    }
    
    public function verify( $phone_number, $verification_code ) {
        $authyApi = new AuthyApi( $this->getApiKey() );
        $res = $authyApi->phoneVerificationCheck( $phone_number, '972', $verification_code );

        if ( $res->ok() ) {
            return true;
        }

        self::$errors->add( 'authy_error', __( $res->errors()->message, 'elementor-otp' ) );
        return false;
    }
    
}