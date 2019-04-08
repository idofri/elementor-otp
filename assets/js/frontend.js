jQuery( function( $ ) {

    function formSubmit( event, xhr ) {

        if ( xhr.responseJSON.data && ! xhr.responseJSON.data.verify ) {
            return;
        }

        var $form = $( event.target );
        var $otpSms = $form.find( '[data-sms]' );
        var $otpCode = $form.find( '[name="otp-code"]' );
        var $otpToken = $form.find( '[name="otp-token"]' );

        // Token
        if ( xhr.responseJSON.data.token ) {
            $otpToken.val( xhr.responseJSON.data.token );
        }

        if ( 'hidden' === $otpCode.attr( 'type' ) ) {
            $otpSms.prop( 'readonly', true );
            $otpCode.attr( 'type', 'text' ).focus();
            $( '<div class="elementor-field-group"></div>' ).insertAfter( $otpSms );
        }

    }

    $( 'form.elementor-form' ).ajaxSuccess( formSubmit );

    $( 'form.elementor-form' ).on( 'error submit_success', function( event ) {
        var $otpCode = $( event.target ).find( '[name="otp-code"]' );
        if ( $otpCode ) {
            $otpCode.val('');
        }
    } );

    $( 'form.elementor-form' ).on( 'submit_success', function( event ) {
        var $otpSms = $( event.target ).find( '[data-sms]' );
        if ( $otpSms ) {
            $otpSms.prop( 'readonly', false );
        }

        var $otpCode = $( event.target ).find( '[name="otp-code"]' );
        if ( $otpCode ) {
            $otpCode.attr( 'type', 'hidden' );
        }

        var $otpToken = $( event.target ).find( '[name="otp-token"]' );
        if ( $otpToken ) {
            $otpToken.val('');
        }
    } );

    // jQuery Mask
    $( '[data-mask]' ).each( function() {
        $( this ).mask( $( this ).attr( 'data-mask' ) );
    } );

} );