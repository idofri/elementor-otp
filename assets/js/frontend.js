jQuery( function( $ ) {

    function formSubmit( event, xhr ) {

        if ( xhr.responseJSON.data && ! xhr.responseJSON.data.verify ) {
            return;
        }

        var $form = $( event.target );
        var $otpSms = $form.find( '[data-sms]' );
        var $otpToken = $form.find( '[name="otp-token"]' );

        // Token
        if ( xhr.responseJSON.data && xhr.responseJSON.data.token ) {
            $otpToken.val( xhr.responseJSON.data.token );
            $otpSms.attr( 'placeholder', window.elementorOtpFrontendConfig.placeholder );
            $otpSms.attr( 'data-placeholder', $otpSms.attr( 'placeholder' ) );
            $otpSms.val('').focus();
        } else {
            // $otpToken.val('');
            $otpSms.attr( 'placeholder', $otpSms.attr( 'placeholder' ) );
        }

    }

    $( 'form.elementor-form' ).ajaxSuccess( formSubmit );

    $( 'form.elementor-form' ).on( 'error submit_success', function( event ) {

    } );

    $( 'form.elementor-form' ).on( 'submit_success', function( event ) {
        var $otpSms = $( event.target ).find( '[data-sms]' );
        if ( $otpSms ) {
            $otpSms.prop( 'readonly', false );
            $otpSms.siblings( '.elementor-field-group' ).remove();
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