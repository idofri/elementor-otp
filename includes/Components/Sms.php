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
        echo '<input ' . $form->get_render_attribute_string( $elementSms ) . '>';

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
        
        $provider = $this->getProvider( $field, $record );
        if ( ! $provider ) {
            return;
        }

        $provider->submit( $field, $record );
    }

    public function getProvider( $field, Form_Record $record ) {
        foreach ( $record->get_form_settings( 'form_fields' ) as $form_field ) {
            if ( $field['id'] !== $form_field['_id'] ) {
                continue;
            }

            $className = ucfirst( $form_field['provider'] );
            $className = "Elementor\\OTP\\Provider\\{$className}";
            $className = apply_filters( 'elementor_otp/submit/provider', $className, $field, $form_field, $record );

            if ( class_exists( $className ) ) {
                return new $className;
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
            'provider' => [
                'name' => 'provider',
                'label' => __( 'Provider', 'elementor-otp' ),
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
            'country' => [
                'name' => 'country',
                'label' => __( 'Country', 'elementor-otp' ),
                'type' => Controls_Manager::SELECT2,
                'render_type' => 'none',
                'condition' => [
                    'field_type' => $this->get_type(),
                    'provider' => 'twilio'
                ],
                'options' => json_decode( '{"1":"United States / Canada","7":"Russia","20":"Egypt","27":"South Africa","30":"Greece","31":"Netherlands","32":"Belgium","33":"France","34":"Spain","36":"Hungary","39":"Italy","40":"Romania","41":"Switzerland","43":"Austria","44":"United Kingdom","45":"Denmark","46":"Sweden","47":"Norway / Svalbard and Jan Mayen","48":"Poland","49":"Germany","51":"Peru","52":"Mexico","53":"Cuba","54":"Argentina","55":"Brazil","56":"Chile","57":"Colombia","58":"Venezuela","60":"Malaysia","61":"Australia","62":"Indonesia","63":"Philippines","64":"New Zealand","65":"Singapore","66":"Thailand","81":"Japan","82":"South Korea","84":"Vietnam","86":"China","90":"Turkey","91":"India","92":"Pakistan","93":"Afghanistan","94":"Sri Lanka","95":"Myanmar","98":"Iran","211":"South Sudan","212":"Western Sahara / Morocco","213":"Algeria","216":"Tunisia","218":"Libya","220":"Gambia","221":"Senegal","222":"Mauritania","223":"Mali","224":"Guinea","225":"Ivory Coast","226":"Burkina Faso","227":"Niger","228":"Togo","229":"Benin","230":"Mauritius","231":"Liberia","232":"Sierra Leone","233":"Ghana","234":"Nigeria","235":"Chad","236":"Central African Republic","237":"Cameroon","238":"Cape Verde","239":"Sao Tome and Principe","240":"Equatorial Guinea","241":"Gabon","242":"Republic of the Congo","243":"Democratic Republic of the Congo","244":"Angola","245":"Guinea-Bissau","246":"British Indian Ocean Territory","248":"Seychelles","249":"Sudan","250":"Rwanda","251":"Ethiopia","252":"Somalia","253":"Djibouti","254":"Kenya","255":"Tanzania","256":"Uganda","257":"Burundi","258":"Mozambique","260":"Zambia","261":"Madagascar","262":"Reunion / Mayotte","263":"Zimbabwe","264":"Namibia","265":"Malawi","266":"Lesotho","267":"Botswana","268":"Swaziland","269":"Comoros","290":"Saint Helena","291":"Eritrea","297":"Aruba","298":"Faroe Islands","299":"Greenland","350":"Gibraltar","351":"Portugal","352":"Luxembourg","353":"Ireland","354":"Iceland","355":"Albania","356":"Malta","357":"Cyprus","358":"Finland","359":"Bulgaria","370":"Lithuania","371":"Latvia","372":"Estonia","373":"Moldova","374":"Armenia","375":"Belarus","376":"Andorra","377":"Monaco","378":"San Marino","379":"Vatican","380":"Ukraine","381":"Serbia","382":"Montenegro","385":"Croatia","386":"Slovenia","387":"Bosnia and Herzegovina","389":"Macedonia","420":"Czech Republic","421":"Slovakia","423":"Liechtenstein","500":"Falkland Islands","501":"Belize","502":"Guatemala","503":"El Salvador","504":"Honduras","505":"Nicaragua","506":"Costa Rica","507":"Panama","508":"Saint Pierre and Miquelon","509":"Haiti","590":"Guadeloupe / Saint Barthelemy / Saint Martin","591":"Bolivia","592":"Guyana","593":"Ecuador","594":"French Guiana","595":"Paraguay","596":"Martinique","597":"Suriname","598":"Uruguay","599":"Bonaire, Saint Eustatius and Saba / Curacao / Sint Maarten","670":"East Timor","672":"Norfolk Island","673":"Brunei","674":"Nauru","675":"Papua New Guinea","676":"Tonga","677":"Solomon Islands","678":"Vanuatu","679":"Fiji","680":"Palau","681":"Wallis and Futuna","682":"Cook Islands","683":"Niue","685":"Samoa","686":"Kiribati","687":"New Caledonia","688":"Tuvalu","689":"French Polynesia","690":"Tokelau","691":"Micronesia","692":"Marshall Islands","850":"North Korea","852":"Hong Kong","853":"Macao","855":"Cambodia","856":"Laos","870":"Pitcairn","880":"Bangladesh","886":"Taiwan","960":"Maldives","961":"Lebanon","962":"Jordan","963":"Syria","964":"Iraq","965":"Kuwait","966":"Saudi Arabia","967":"Yemen","968":"Oman","970":"Palestinian Territory","971":"United Arab Emirates","972":"Israel","973":"Bahrain","974":"Qatar","975":"Bhutan","976":"Mongolia","977":"Nepal","992":"Tajikistan","993":"Turkmenistan","994":"Azerbaijan","995":"Georgia","996":"Kyrgyzstan","998":"Uzbekistan","358-18":"Aland Islands","1-684":"American Samoa","1-264":"Anguilla","1-268":"Antigua and Barbuda","1-242":"Bahamas","1-246":"Barbados","1-441":"Bermuda","1-284":"British Virgin Islands","1-345":"Cayman Islands","1-767":"Dominica","1-809 and 1-829":"Dominican Republic","1-473":"Grenada","1-671":"Guam","44-1481":"Guernsey"," ":"Heard Island and McDonald Islands","44-1624":"Isle of Man","1-876":"Jamaica","44-1534":"Jersey","1-664":"Montserrat","1-670":"Northern Mariana Islands","1-787 and 1-939":"Puerto Rico","1-869":"Saint Kitts and Nevis","1-758":"Saint Lucia","1-784":"Saint Vincent and the Grenadines","1-868":"Trinidad and Tobago","1-649":"Turks and Caicos Islands","1-340":"U.S. Virgin Islands"}', true ),
            ],
            'placeholder' => $placeholder
        ];

        $control_data['fields'] = $this->inject_field_controls( $control_data['fields'], $field_controls );
        $widget->update_control( 'form_fields', $control_data );
    }

}