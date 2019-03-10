<?php
namespace Elementor\OTP\Vendor;

use Authy\AuthyApi;

class Twilio extends Base {
    
    // @temp
    protected function getApiKey() {
        return 'RL77DnnPWt1btKD8KXRI3SIlrIoCPPzW';
    }

    public function send( $phone_number ) {
        $authyApi = new AuthyApi( $this->getApiKey() );
        $res = $authyApi->phoneVerificationStart( 
            $phone_number,
            $options['country_code'],
            $options['via'],
            $options['code_length'],
            $options['locale']
        );

        if ( $res->ok() ) {
            return $res->bodyvar('uuid');
        }
        
        $this->errors->add( 'authy_error',
            __( sprintf( '<strong>ERROR</strong>: %s', $res->errors()->message ), 'elementor-otp' )
        );
        return false;
    }
    
    public function verify( $phone_number, $verification_code ) {
        $authyApi = new AuthyApi( $this->getApiKey() );
        $res = $authyApi->phoneVerificationCheck( $phone_number, $country_code, $verification_code );

        if ( $res->ok() ) {
            return true;
        }

        $this->errors->add( 'authy_error',
            __( sprintf( '<strong>ERROR</strong>: %s', $res->errors()->message ), 'elementor-otp' )
        );
        return false;
    }
    
}