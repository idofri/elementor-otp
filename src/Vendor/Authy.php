<?php
namespace Elementor\OTP\Vendor;

use Authy\AuthyApi;
use Authy\AuthyResponse;

class Authy extends AuthyApi {
    
    public function phoneVerificationStatus( $uuid )
    {
        $resp = $this->rest->get("protected/json/phones/verification/status", array_merge(
            $this->default_options,
            [
                'query' => [
                    'uuid' => $uuid
                ]
            ]
        ));

        return new AuthyResponse($resp);
    }
    
}