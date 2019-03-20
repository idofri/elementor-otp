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
        'featherlight',
        'elementor-otp'
    ];

    public $depended_styles = [
        'featherlight',
        'elementor-otp'
    ];

    public function get_type() {
        return 'sms';
    }

    public function get_name() {
        return __( 'SMS Verification', 'elementor-otp' );
    }

    public function render( $item, $item_index, $form ) {
        $form->set_render_attribute( 'input' . $item_index, 'type', 'tel' );
        $form->add_render_attribute( 'input' . $item_index, 'class', 'elementor-field-textual' );
        $form->add_render_attribute( 'input' . $item_index, 'pattern', '[0-9()#&+*-=.\s]+' );
        $form->add_render_attribute( 'input' . $item_index, 'title', __( 'Only numbers and phone characters (#, -, *, etc) are accepted.', 'elementor-pro' ) );
        if ( ! empty( $item['sms_pattern'] ) ) {
            $form->set_render_attribute( 'input' . $item_index, 'data-mask', $item['sms_pattern'] );
            $form->set_render_attribute( 'input' . $item_index, 'pattern', '[0-9()#&+*-=.\s]+' );
        }
        echo '<input size="1" ' . $form->get_render_attribute_string( 'input' . $item_index ) . '>';

        $form->add_render_attribute( 'code' . $item_index, 'type', 'hidden' );
        $form->add_render_attribute( 'code' . $item_index, 'name', 'otp-code' );
        echo '<input ' . $form->get_render_attribute_string( 'code' . $item_index ) . '>';

        $form->add_render_attribute( 'token' . $item_index, 'type', 'hidden' );
        $form->add_render_attribute( 'token' . $item_index, 'name', 'otp-token' );
        echo '<input ' . $form->get_render_attribute_string( 'token' . $item_index ) . '>';

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
            'sms_vendor' => [
                'name' => 'sms_vendor',
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
            'sms_country' => [
                'label' => __( 'Country', 'elementor-otp' ),
                'type' => Controls_Manager::SELECT2,
                'options' => array(
                    93 => 'Afghanistan',
                    355 => 'Albania',
                    213 => 'Algeria',
                    1684 => 'American Samoa',
                    376 => 'Andorra',
                    244 => 'Angola',
                    1264 => 'Anguilla',
                    1685 => 'Antarctica',
                    1268 => 'Antigua and Barbuda',
                    54 => 'Argentina',
                    374 => 'Armenia',
                    297 => 'Aruba',
                    43 => 'Austria',
                    994 => 'Azerbaijan',
                    1242 => 'Bahamas',
                    973 => 'Bahrain',
                    880 => 'Bangladesh',
                    1246 => 'Barbados',
                    375 => 'Belarus',
                    32 => 'Belgium',
                    501 => 'Belize',
                    229 => 'Benin',
                    1441 => 'Bermuda',
                    975 => 'Bhutan',
                    591 => 'Bolivia',
                    387 => 'Bosnia and Herzegovina',
                    267 => 'Botswana',
                    1686 => 'Bouvet Island',
                    55 => 'Brazil',
                    246 => 'British Indian Ocean Territory',
                    1687 => 'Brunei',
                    359 => 'Bulgaria',
                    226 => 'Burkina Faso',
                    257 => 'Burundi',
                    855 => 'Cambodia',
                    237 => 'Cameroon',
                    1688 => 'Cape Verde',
                    1345 => 'Cayman Islands',
                    236 => 'Central African Republic',
                    235 => 'Chad',
                    56 => 'Chile',
                    86 => 'China',
                    61 => 'Cocos (Keeling) Islands',
                    57 => 'Colombia',
                    269 => 'Comoros',
                    242 => 'Congo',
                    682 => 'Cook Islands',
                    506 => 'Costa Rica',
                    385 => 'Croatia',
                    53 => 'Cuba',
                    357 => 'Cyprus',
                    420 => 'Czech Republic',
                    45 => 'Denmark',
                    253 => 'Djibouti',
                    1767 => 'Dominica',
                    1849 => 'Dominican Republic',
                    670 => 'East Timor',
                    593 => 'Ecuador',
                    20 => 'Egypt',
                    503 => 'El Salvador',
                    1850 => 'England',
                    240 => 'Equatorial Guinea',
                    291 => 'Eritrea',
                    372 => 'Estonia',
                    251 => 'Ethiopia',
                    298 => 'Faroe Islands',
                    1851 => 'Fiji Islands',
                    358 => 'Finland',
                    33 => 'France',
                    594 => 'French Guiana',
                    689 => 'French Polynesia',
                    1852 => 'French Southern territories',
                    241 => 'Gabon',
                    220 => 'Gambia',
                    995 => 'Georgia',
                    49 => 'Germany',
                    233 => 'Ghana',
                    350 => 'Gibraltar',
                    30 => 'Greece',
                    299 => 'Greenland',
                    1473 => 'Grenada',
                    590 => 'Guadeloupe',
                    1671 => 'Guam',
                    502 => 'Guatemala',
                    224 => 'Guinea',
                    245 => 'Guinea-Bissau',
                    592 => 'Guyana',
                    509 => 'Haiti',
                    1853 => 'Heard Island and McDonald Islands',
                    1854 => 'Holy See (Vatican City State)',
                    504 => 'Honduras',
                    852 => 'Hong Kong',
                    36 => 'Hungary',
                    354 => 'Iceland',
                    91 => 'India',
                    62 => 'Indonesia',
                    98 => 'Iran',
                    964 => 'Iraq',
                    353 => 'Ireland',
                    972 => 'Israel',
                    39 => 'Italy',
                    225 => 'Ivory Coast',
                    1876 => 'Jamaica',
                    81 => 'Japan',
                    962 => 'Jordan',
                    1877 => 'Kazakstan',
                    254 => 'Kenya',
                    686 => 'Kiribati',
                    965 => 'Kuwait',
                    996 => 'Kyrgyzstan',
                    856 => 'Laos',
                    371 => 'Latvia',
                    961 => 'Lebanon',
                    266 => 'Lesotho',
                    231 => 'Liberia',
                    1878 => 'Libyan Arab Jamahiriya',
                    423 => 'Liechtenstein',
                    370 => 'Lithuania',
                    352 => 'Luxembourg',
                    1879 => 'Macao',
                    389 => 'Macedonia',
                    261 => 'Madagascar',
                    265 => 'Malawi',
                    60 => 'Malaysia',
                    960 => 'Maldives',
                    223 => 'Mali',
                    356 => 'Malta',
                    692 => 'Marshall Islands',
                    596 => 'Martinique',
                    222 => 'Mauritania',
                    230 => 'Mauritius',
                    52 => 'Mexico',
                    691 => 'Micronesia, Federated States of',
                    373 => 'Moldova',
                    377 => 'Monaco',
                    976 => 'Mongolia',
                    1664 => 'Montserrat',
                    212 => 'Morocco',
                    258 => 'Mozambique',
                    95 => 'Myanmar',
                    264 => 'Namibia',
                    674 => 'Nauru',
                    977 => 'Nepal',
                    31 => 'Netherlands',
                    1880 => 'Netherlands Antilles',
                    687 => 'New Caledonia',
                    64 => 'New Zealand',
                    505 => 'Nicaragua',
                    227 => 'Niger',
                    234 => 'Nigeria',
                    683 => 'Niue',
                    672 => 'Norfolk Island',
                    1881 => 'North Korea',
                    1882 => 'Northern Ireland',
                    1670 => 'Northern Mariana Islands',
                    47 => 'Norway',
                    968 => 'Oman',
                    92 => 'Pakistan',
                    680 => 'Palau',
                    1883 => 'Palestine',
                    507 => 'Panama',
                    675 => 'Papua New Guinea',
                    595 => 'Paraguay',
                    51 => 'Peru',
                    63 => 'Philippines',
                    1884 => 'Pitcairn',
                    48 => 'Poland',
                    351 => 'Portugal',
                    1939 => 'Puerto Rico',
                    974 => 'Qatar',
                    262 => 'Reunion',
                    40 => 'Romania',
                    7 => 'Russian Federation',
                    250 => 'Rwanda',
                    290 => 'Saint Helena',
                    1869 => 'Saint Kitts and Nevis',
                    1758 => 'Saint Lucia',
                    508 => 'Saint Pierre and Miquelon',
                    1784 => 'Saint Vincent and the Grenadines',
                    685 => 'Samoa',
                    378 => 'San Marino',
                    239 => 'Sao Tome and Principe',
                    966 => 'Saudi Arabia',
                    1940 => 'Scotland',
                    221 => 'Senegal',
                    248 => 'Seychelles',
                    232 => 'Sierra Leone',
                    65 => 'Singapore',
                    421 => 'Slovakia',
                    386 => 'Slovenia',
                    677 => 'Solomon Islands',
                    252 => 'Somalia',
                    27 => 'South Africa',
                    500 => 'South Georgia and the South Sandwich Islands',
                    1941 => 'South Korea',
                    211 => 'South Sudan',
                    34 => 'Spain',
                    1942 => 'SriLanka',
                    249 => 'Sudan',
                    597 => 'Suriname',
                    1943 => 'Svalbard and Jan Mayen',
                    268 => 'Swaziland',
                    46 => 'Sweden',
                    41 => 'Switzerland',
                    963 => 'Syria',
                    992 => 'Tajikistan',
                    255 => 'Tanzania',
                    66 => 'Thailand',
                    1944 => 'The Democratic Republic of Congo',
                    228 => 'Togo',
                    690 => 'Tokelau',
                    676 => 'Tonga',
                    1868 => 'Trinidad and Tobago',
                    216 => 'Tunisia',
                    90 => 'Turkey',
                    993 => 'Turkmenistan',
                    1649 => 'Turks and Caicos Islands',
                    688 => 'Tuvalu',
                    256 => 'Uganda',
                    380 => 'Ukraine',
                    971 => 'United Arab Emirates',
                    44 => 'United Kingdom',
                    1 => 'United States',
                    1945 => 'United States Minor Outlying Islands',
                    598 => 'Uruguay',
                    998 => 'Uzbekistan',
                    678 => 'Vanuatu',
                    58 => 'Venezuela',
                    84 => 'Vietnam',
                    1946 => 'Virgin Islands, British',
                    1947 => 'Virgin Islands, U.S.',
                    1948 => 'Wales',
                    681 => 'Wallis and Futuna',
                    1949 => 'Western Sahara',
                    967 => 'Yemen',
                    1950 => 'Yugoslavia',
                    260 => 'Zambia',
                    263 => 'Zimbabwe',
                ),
                'select2options' => [ 'sorter' => 'function(data) {return 0;}' ],
                'render_type' => 'none',
                'condition' => [
                    'sms_vendor' => 'twilio',
                ]
            ],
            'sms_pattern' => [
                'name' => 'sms_pattern',
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