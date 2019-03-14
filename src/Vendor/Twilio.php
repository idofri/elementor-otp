<?php
namespace Elementor\OTP\Vendor;

class Twilio extends Base {

    const VIA_METHOD = 'sms';

    const COUNTRY_CODE = 972;

    const OPTION_NAME_API_KEY = 'elementor_otp_twilio_api_key';
    
    private $uuid;
    
    public static function getApiKey() {
        return get_option( self::OPTION_NAME_API_KEY );
    }
    
    public function setUuid( $uuid ) {
        $this->uuid = $uuid;
        return $this;
    }
    
    public function getUuid() {
        return $this->uuid;
    }

    public function send( $phone_number ) {
        $authy = new Authy( $this->getApiKey() );
        $res = $authy->phoneVerificationStart( $phone_number, self::COUNTRY_CODE, self::VIA_METHOD );

        if ( $res->ok() ) {
            $this->setUuid( $res->bodyvar( 'uuid' ) );
            return;
        }

        return $this->error( $res );
    }

    public function verify( $phone_number, $verification_code ) {
        $authy = new Authy( $this->getApiKey() );
        $res = $authy->phoneVerificationCheck( $phone_number, '972', $verification_code );

        if ( $res->ok() ) {
            return true;
        }
        
        return $this->error( $res );
    }
    
    public function status( $uuid ) {
        $authy = new Authy( $this->getApiKey() );
        $res = $authy->phoneVerificationStatus( $uuid );
        
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
    
}