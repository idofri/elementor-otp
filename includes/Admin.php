<?php
namespace Elementor\OTP;

use Elementor\Settings;

class Admin {

    public function __construct() {
        add_action( 'elementor/admin/after_create_settings/' . Settings::PAGE_ID, [ $this, 'registerAdminFields' ] );
    }

    public function registerAdminFields( Settings $settings ) {
        $settings->add_section( Settings::TAB_INTEGRATIONS, 'twilio', [
            'callback' => function() {
                echo '<hr><h2>' . esc_html__( 'Twilio', 'elementor-otp' ) . '</h2>';
            },
            'fields' => [
                'otp_twilio_api_key' => [
                    'label' => __( 'API Key', 'elementor-otp' ),
                    'field_args' => [
                        'type' => 'text',
                        'desc' => sprintf( __( 'To integrate with our forms you need an <a href="%s" target="_blank">API Key</a>.', 'elementor-otp' ), 'https://www.twilio.com/docs/verify/api/applications' )
                    ]
                ]
            ]
        ] );

        $settings->add_section( Settings::TAB_INTEGRATIONS, 'nexmo', [
            'callback' => function() {
                echo '<hr><h2>' . esc_html__( 'Nexmo', 'elementor-otp' ) . '</h2>';
            },
            'fields' => [
                'otp_nexmo_api_key' => [
                    'label' => __( 'API Key', 'elementor-otp' ),
                    'field_args' => [
                        'type' => 'text'
                    ]
                ],
                'otp_nexmo_api_secret' => [
                    'label' => __( 'API Secret', 'elementor-otp' ),
                    'field_args' => [
                        'type' => 'text',
                        'desc' => sprintf( __( 'To integrate with our forms you need an <a href="%s" target="_blank">API Key</a>.', 'elementor-otp' ), 'https://developer.nexmo.com/verify/overview' )
                    ]
                ]
            ]
        ] );
    }

}