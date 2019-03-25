jQuery( function( $ ) {

    elementor.hooks.addFilter( 'elementor_pro/forms/content_template/field/sms', function(inputField, item, i, settings) {
        var itemClasses = _.escape(item.css_classes),
            mask = '',
            required = '',
            placeholder = '';

        if (item.required) {
            required = 'required';
        }

        if (item.placeholder) {
            placeholder = ' placeholder="' + item.placeholder + '"';
        }

        if (item.mask) {
            mask = ' data-mask="' + item.mask + '"';
        }

        itemClasses = 'elementor-field-textual ' + itemClasses;

        return '<input type="' + item.field_type + '" class="elementor-field-textual elementor-field elementor-size-' + settings.input_size + ' ' + itemClasses + '" name="form_field_' + i + '" id="form_field_' + i + '" ' + mask + ' ' + required + ' ' + placeholder + ' pattern="[0-9()-]" >';
    } , 10, 4 );

    $( 'body' ).on( 'input', '[data-setting="mask"]', function( e ) {

        console.log(e);
        // $( this ).css( {
        //     'direction': 'ltr',
        //     'text-align': $( 'body' ).hasClass( 'rtl' ) ? 'right' : 'left'
        // } ).mask( $( this ).attr( 'data-mask' ) );
    } );

} );