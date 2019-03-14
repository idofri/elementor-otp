jQuery( function( $ ) {
    
    function formSubmit( event, xhr, settings ) {
        
        if ( xhr.responseJSON.data && ! xhr.responseJSON.data.otp ) {
            return;
        }
        
        var $form = $( event.target );
        var $otpUuid = $form.find( '[name="otp-uuid"]' );
        var $otpCode = $form.find( '[name="otp-code"]' );
        
        // UUID
        if ( xhr.responseJSON.data.uuid ) {
            $otpUuid.val( xhr.responseJSON.data.uuid );
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
        $( '#otp-uuid' ).val('');
    } );
    
} );