jQuery( function( $ ) {

    function formSubmit( event, xhr, settings ) {

        if ( xhr.responseJSON.data && ! xhr.responseJSON.data.verify ) {
            return;
        }

        var $form = $( event.target );
        var $otpToken = $form.find( '[name="otp-token"]' );
        var $otpCode = $form.find( '[name="otp-code"]' );

        // Token
        if ( xhr.responseJSON.data.token ) {
            $otpToken.val( xhr.responseJSON.data.token );
        }

        $.featherlight( xhr.responseJSON.data.html, {
            root: '.elementor-2',
            closeIcon: '',
            otherClose: '.elementor-button',
            beforeClose: function( event ) {
                if ( ! $( event.target ).hasClass( 'elementor-button' ) ) {
                    return;
                }

                $otpCode.val( $( event.currentTarget ).find( '.otp-code' ).val() );
                $form.trigger( 'submit' );
            }
        } );

    }

    $( 'form.elementor-form' ).ajaxSuccess( formSubmit );

    $( 'form.elementor-form' ).on( 'error submit_success', function( event ) {
        var $otpCode = $( event.target ).find( '[name="otp-code"]' );
        if ( $otpCode ) {
            $otpCode.val('');
        }
    } );

    $( 'form.elementor-form' ).on( 'submit_success', function( event ) {
        var $otpToken = $( event.target ).find( '[name="otp-token"]' );
        if ( $otpToken ) {
            $otpToken.val('');
        }
    } );

    // jQuery Mask
    $( '[data-mask]' ).each( function() {
        $( this ).css( {
            'direction': 'ltr',
            'text-align': $( 'body' ).hasClass( 'rtl' ) ? 'right' : 'left'
        } ).mask( $( this ).attr( 'data-mask' ) );
    } );

} );