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
        $( '#otp-code' ).val('');
    } );
    
    $( 'form.elementor-form' ).on( 'submit_success', function( event ) {
        $( '#otp-token' ).val('');
    } );
    
} );