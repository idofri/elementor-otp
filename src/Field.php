<?php
namespace Elementor\OTP;

use Elementor\Controls_Manager;
use ElementorPro\Plugin;
use ElementorPro\Modules\Forms\Fields\Tel;

class Field extends Tel {
    
    public $depended_scripts = [
        'featherlight'
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

        $form->set_render_attribute( 'otp-container' . $item_index, 'class', 'elementor-hidden' );
        $form->set_render_attribute( 'otp-container' . $item_index, 'id', 'otp-container[' . $item['_id'] . ']' );
        ?><div <?php echo $form->get_render_attribute_string( 'otp-container' . $item_index ); ?>>
            <?php
            $form->set_render_attribute( 'otp' . $item_index, 'type', 'tel' );
            $form->set_render_attribute( 'otp' . $item_index, 'id', 'otp[' . $item['_id'] . ']' );
            echo '<input size="1" ' . $form->get_render_attribute_string( 'otp' . $item_index ) . '>'; 
            ?>
            <button type="submit" <?php echo $form->get_render_attribute_string( 'button' ); ?>>
                <span <?php echo $form->get_render_attribute_string( 'content-wrapper' ); ?>>
                    <span class="elementor-button-text"><?php _e( 'Verify', 'elementor-otp' ); ?></span>
                </span>
            </button>
        </div><?php
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