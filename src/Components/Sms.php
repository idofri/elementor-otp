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

    public function renderVerificationBox( $form_id ) {
        ob_start();

        ?><form class="elementor-element elementor-element-<?= $form_id; ?> elementor-widget-form elementor-button-align-stretch elementor-hidden elementor-otp">
            <div class="elementor-field-group elementor-align-center">
                <label for="verification-code">
                    <?php _e( 'Please type the verification code sent to you.', 'elementor-otp' ); ?>
                </label>
                <input type="tel" class="elementor-field-textual elementor-size-sm elementor-align-center otp-code" placeholder="<?php esc_attr_e( 'Enter code', 'elementor-otp' ); ?>" required>
            </div>
            <div class="elementor-field-group elementor-field-type-submit elementor-column elementor-col-100">
                <button type="submit" class="elementor-button elementor-size-sm">
                    <?php _e( 'Verify', 'elementor-otp' ); ?>
                </button>
            </div>
        </form><?php

        return ob_get_clean();
    }

    public function validation( $field, Form_Record $record, Ajax_Handler $ajax_handler ) {
        if ( '' === $field['value'] ) {
            $ajax_handler->add_error( $field['id'], $ajax_handler::get_default_message( $ajax_handler::FIELD_REQUIRED, $record->get( 'form_settings' ) ) );
        }
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

        // Required
        $required = $control_data['fields']['required'];
        $required['conditions']['terms'][] = [
            'name' => 'field_type',
            'operator' => '!in',
            'value' => [ $this->get_type() ]
        ];

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
                'default' => '(000) 000-0000',
                'condition' => [
                    'field_type' => $this->get_type(),
                ],
                'tab' => 'content',
                'inner_tab' => 'form_fields_content_tab',
                'tabs_wrapper' => 'form_fields_tabs',
            ],
            'placeholder' => $placeholder,
            'required' => $required
        ];

        $control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
        $widget->update_control( 'form_fields', $control_data );
    }

}