<?php
namespace Elementor\OTP\Vendor;

class Twilio extends Base {

    const VIA_METHOD = 'sms';

    const COUNTRY_CODE = 972;

    const OPTION_NAME_API_KEY = 'elementor_otp_twilio_api_key';
    
    private $uuid;
    
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
    
    public function setUuid( $uuid ) {
        $this->uuid = $uuid;
        return $this;
    }
    
    public function getUuid() {
        return $this->uuid;
    }

    public function send( $phone_number ) {
        $res = $this->getClient()->phoneVerificationStart( $phone_number, self::COUNTRY_CODE, self::VIA_METHOD );

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
    
}