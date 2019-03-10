jQuery( function( $ ) {
    
    $( 'body' ).on( 'error', function( event ) {
        
        var $form = $( event.target );
        
        // Not our form
        if ( ! $form.hasClass( 'elementor-form' ) ) {
            return;
        }
        
        // Form has errors
        if ( $form.find( '.elementor-message-danger' ).length ) {
            return;
        }
        
        var otpEnabledForm = false;
        $form.ajaxSuccess(function( event, xhr, settings ) {
            if ( xhr.responseJSON.data.otp ) {
                otpEnabledForm = true;
            }
        } );
        
        // OTP not present
        if ( otpEnabledForm ) {
            return;
        }

        var $content = $form.find( '.elementor-otp' );
        $.featherlight( $content, {
            root: $form,
            closeIcon: '',
            otherClose: '.elementor-button',
            afterClose: function( event ) {
                if ( $( event.target ).hasClass( 'elementor-button' ) ) {
                    $form.trigger( 'submit' );
                }
            }
        } );
        
    } );
    
} );