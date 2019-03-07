<?php
namespace Elementor\OTP;

use Elementor\Controls_Manager;
use ElementorPro\Plugin;
use ElementorPro\Modules\Forms\Fields\Tel;

class Component extends Tel {
    
    public $depended_scripts = [
        'featherlight',
        'elementor-otp'
    ];

    public $depended_styles = [
        'featherlight'
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
            <div class="elementor-form-fields-wrapper">
                <div class="elementor-column elementor-col-50">
                    <input size="4" type="tel" class="elementor-field elementor-size-sm">
                </div>
                <div class="elementor-column elementor-col-50">
                    <button type="button" class="elementor-button elementor-size-sm">
                        <span>
                            <span class="elementor-button-text"><?php _e( 'Verify', 'elementor-otp' ); ?></span>
                        </span>
                    </button>
                </div>
            </div>
        </div><?php
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
            'placeholder' => $placeholder
        ];
        
        $control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
        $widget->update_control( 'form_fields', $control_data );
    }
    
}