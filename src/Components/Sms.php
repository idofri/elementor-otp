<?php
namespace Elementor\OTP\Components;

use ElementorPro\Plugin;
use Elementor\Controls_Manager;
use ElementorPro\Modules\Forms\Fields\Field_Base;
use ElementorPro\Modules\Forms\Classes\Form_Record;
use ElementorPro\Modules\Forms\Classes\Ajax_Handler;

class Sms extends Field_Base {

    public $depended_scripts = [
        'jquery-mask',
        'elementor-otp-frontend'
    ];

    public $depended_styles = [
        'elementor-otp-frontend'
    ];

    public function get_type() {
        return 'sms';
    }

    public function get_name() {
        return __( 'SMS Verification', 'elementor-otp' );
    }

    public function render( $item, $item_index, $form ) {
        $elementSms = 'input' . $item_index;
        $elementCode = 'code' . $item_index;
        $elementToken = 'token' . $item_index;

        // SMS
        $form->set_render_attribute( $elementSms, 'type', 'tel' );
        $form->add_render_attribute( $elementSms, 'data-sms', true );
        $form->add_render_attribute( $elementSms, 'class', 'elementor-field-textual' );
        $form->add_render_attribute( $elementSms, 'pattern', '[0-9()#&+*-=.\s]+' );
        $form->add_render_attribute( $elementSms, 'title', __( 'Only numbers and phone characters (#, -, *, etc) are accepted.', 'elementor-pro' ) );
        if ( ! empty( $item['mask'] ) ) {
            $form->set_render_attribute( $elementSms, 'data-mask', $item['mask'] );
        }
        echo '<input size="1" ' . $form->get_render_attribute_string( $elementSms ) . '>';

        // Code
        $form->add_render_attribute( $elementCode, 'type', 'hidden' );
        $form->add_render_attribute( $elementCode, 'class', $form->get_render_attributes( $elementSms, 'class' ) );
        $form->add_render_attribute( $elementCode, 'placeholder', __( 'Enter code', 'elementor-otp' ) );
        $form->add_render_attribute( $elementCode, 'name', 'otp-code' );
        echo '<input ' . $form->get_render_attribute_string( $elementCode ) . '>';

        // Token
        $form->add_render_attribute( $elementToken, 'type', 'hidden' );
        $form->add_render_attribute( $elementToken, 'name', 'otp-token' );
        echo '<input ' . $form->get_render_attribute_string( $elementToken ) . '>';

        do_action( 'elementor_otp/components/sms/render', $item, $item_index, $form, $this );
    }

    public function validation( $field, Form_Record $record, Ajax_Handler $ajax_handler ) {
        if ( empty( $field['value'] ) ) {
            return;
        }
        if ( preg_match( '/^[0-9()#&+*-=.\s]+$/', $field['value'] ) !== 1 ) {
            $ajax_handler->add_error( $field['id'], __( 'Only numbers and phone characters (#, -, *, etc) are accepted.', 'elementor-otp' ) );
            return;
        }
        
        $vendor = $this->getVendor( $field, $record );
        if ( ! $vendor ) {
            return;
        }

        return $vendor->submit( $field );
    }

    public function getVendor( $field, Form_Record $record ) {
        foreach ( $record->get_form_settings( 'form_fields' ) as $form_field ) {
            if ( $field['id'] !== $form_field['_id'] ) {
                continue;
            }

            $vendor = ucfirst( $form_field['vendor'] );
            $vendor = "Elementor\\OTP\\Vendor\\{$vendor}";
            $vendor = apply_filters( 'elementor_otp/submit/vendor', $vendor, $field, $form_field, $record );

            if ( class_exists( $vendor ) ) {
                return new $vendor;
            }
        }

        return false;
    }

    public function update_controls( $widget ) {
        $elementor = Plugin::elementor();

        $control_data = $elementor->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );

        if ( is_wp_error( $control_data ) ) {
            return;
        }

        // Placeholder
        $placeholder = $control_data['fields']['placeholder'];
        $placeholder['conditions']['terms'][0]['value'][] = $this->get_type();

        $field_controls = [
            'vendor' => [
                'name' => 'vendor',
                'label' => __( 'Vendor', 'elementor-otp' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'twilio',
                'condition' => [
                    'field_type' => $this->get_type(),
                ],
                'options' => [
                    'twilio' => __( 'Twilio', 'elementor-otp' ),
                    'nexmo' => __( 'Nexmo', 'elementor-otp' ),
                ],
                'tab' => 'content',
                'inner_tab' => 'form_fields_content_tab',
                'tabs_wrapper' => 'form_fields_tabs',
            ],
            'mask' => [
                'name' => 'mask',
                'label' => __( 'Pattern', 'elementor-otp' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => '(000) 000-0000',
                'condition' => [
                    'field_type' => $this->get_type(),
                ],
                'tab' => 'content',
                'inner_tab' => 'form_fields_content_tab',
                'tabs_wrapper' => 'form_fields_tabs',
            ],
            'placeholder' => $placeholder
        ];

        $control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
        $widget->update_control( 'form_fields', $control_data );
    }

}