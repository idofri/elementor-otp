<?php
namespace Elementor\OTP\Vendor;

use Authy\AuthyApi;

class Twilio extends Base {
    
    // @temp
    protected function getApiKey() {
        return '3L7FkoZm55N5Zi25iDbifOHt8odAlQNt';
    }

    public function send( $phone_number ) {
        $authyApi = new AuthyApi( $this->getApiKey() );
        $res = $authyApi->phoneVerificationStart( 
            $phone_number,
            '972',
            'sms',
            '4',
            'he'
        );

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