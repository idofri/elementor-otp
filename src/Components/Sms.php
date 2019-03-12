<?php
namespace Elementor\OTP\Components;

use Elementor\Controls_Manager;
use ElementorPro\Plugin;
use ElementorPro\Modules\Forms\Classes\Ajax_Handler;
use ElementorPro\Modules\Forms\Classes\Form_Record;
use ElementorPro\Modules\Forms\Fields\Tel;

class Sms extends Tel {
    
    public $depended_scripts = [
        'featherlight',
        'elementor-otp'
    ];

    public $depended_styles = [
        'featherlight',
        'elementor-otp'
    ];

    public function get_type() {
        return 'otp';
    }

    public function get_name() {
        return __( 'OTP', 'elementor-otp' );
    }
    
    public function render( $item, $item_index, $form ) {
        $form->set_render_attribute( 'input' . $item_index, 'type', 'tel' );
        parent::render( $item, $item_index, $form );

        ?><div class="elementor-hidden elementor-otp">
            <label class="elementor-align-center"><?php _e( '&nbsp;', 'elementor-otp' ); ?></label>
            <input size="6" type="tel" class="elementor-field elementor-field-textual elementor-size-sm">
            <button type="button" class="elementor-button elementor-size-sm"><?php _e( 'Verify', 'elementor-otp' ); ?></button>
        </div><?php
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
            ],
            'placeholder' => $placeholder,
            'required' => $required
        ];
        
        $control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
        $widget->update_control( 'form_fields', $control_data );
    }
    
}