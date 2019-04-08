jQuery( function( $ ) {
    elementor.hooks.addFilter( 'elementor_pro/forms/content_template/field/sms', template_sms , 10, 3 );
    function template_sms( inputField, item, i, settings ) {
        var itemClasses = _.escape( item.css_classes ),
            mask = '',
            required = '',
            placeholder = '';

        if ( item.required ) {
            required = 'required';
        }

        if ( item.placeholder ) {
            placeholder = ' placeholder="' + item.placeholder + '"';
        }

        if ( item.mask ) {
            mask = ' data-mask="' + item.mask + '"';
        }

        itemClasses = 'elementor-field-textual ' + itemClasses;

        return '<input type="' + item.field_type + '" class="elementor-field-textual elementor-field elementor-size-' + settings.input_size + ' ' + itemClasses + '" name="form_field_' + i + '" id="form_field_' + i + '" ' + mask + ' ' + required + ' ' + placeholder + ' pattern="[0-9()-]" >';
    }
} );