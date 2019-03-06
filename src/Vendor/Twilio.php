<?php
namespace Elementor\OTP\Vendor;

use Authy\AuthyApi;
use WP_Error;

class Twilio extends Base {
    
    public function start( WP_Error $errors ) {
        $authyApi = new AuthyApi( 'api_key' );
        $res = $authyApi->phoneVerificationStart( 'phone', 'country', 'method' );

        if ( $res->ok() ) {
            return $res->bodyvar('uuid');
        }
        
        $errors->add( 'authy_error',  __( sprintf( '<strong>ERROR</strong>: %s',  $res->errors()->message ), 'elementor-otp' ) );
        return false;
    }
    
    public function verify() {
        $authyApi = new AuthyApi( 'api_key' );
        $res = $authyApi->phoneVerificationCheck( 'phone', 'country', 'code' );

        if ( $res->ok() ) {
            return true;
        }

        return false;
    }
    
}