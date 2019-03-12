<?php
namespace Elementor\OTP\Vendor;

use Authy\AuthyApi;

class Twilio extends Base {
    
    // @temp
    protected function getApiKey() {
        return 'WGS4CtGydhfi7P955plhsg1Ao3M2oapK';
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
        
        self::$errors->add( 'authy_error', __( $res->errors()->message, 'elementor-otp' ) );
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