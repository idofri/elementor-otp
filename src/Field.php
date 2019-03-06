<?php
namespace Elementor\OTP;

use Elementor\Controls_Manager;
use ElementorPro\Plugin;
use ElementorPro\Modules\Forms\Fields\Tel;

class Field extends Tel {
    
    public function get_type() {
        return 'otp';
    }

    public function get_name() {
        return __( 'OTP', 'elementor-otp' );
    }
    
    public function update_controls( $widget ) {
        $elementor = Plugin::elementor();

        $control_data = $elementor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );

        if ( is_wp_error( $control_data ) ) {
            return;
        }
        
        $field_controls = [
            'otp_vendor' => [
                'name' => 'otp_vendor',
                'label' => __( 'Vendor', 'elementor-otp' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'twilio',
                'condition' => [
                    'field_type' => $this->get_type(),
                ],
                'options' => [
                    'twilio' => __( 'Twilio', 'elementor-otp' )
                ],
                'tab' => 'content',
                'inner_tab' => 'form_fields_content_tab',
                'tabs_wrapper' => 'form_fields_tabs',
            ]
        ];

        $control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
        $widget->update_control( 'form_fields', $control_data );
    }
    
}