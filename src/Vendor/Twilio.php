<?php
namespace Elementor\OTP\Vendor;

use Authy\AuthyApi;

class Twilio extends Base {
    
    const VIA_METHOD = 'sms';
    
    const COUNTRY_CODE = 972;
    
    const OPTION_NAME_API_KEY = 'elementor_otp_twilio_api_key';
    
    public static function getApiKey() {
        return get_option( self::OPTION_NAME_API_KEY );
    }

    public function send( $phone_number ) {
        $authyApi = new AuthyApi( $this->getApiKey() );
        $res = $authyApi->phoneVerificationStart( $phone_number, self::COUNTRY_CODE, self::VIA_METHOD );

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