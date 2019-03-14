jQuery( function( $ ) {
    
    function formSubmit( event, xhr, settings ) {
        
        if ( xhr.responseJSON.data && ! xhr.responseJSON.data.otp ) {
            return;
        }
        
        var $form = $( event.target );
        
        // UUID
        if ( xhr.responseJSON.data.uuid ) {
            $( '#otp-uuid' ).val( xhr.responseJSON.data.uuid );
        }
        
        $.featherlight( xhr.responseJSON.data.html, {
            root: '.elementor-2',
            closeIcon: '',
            otherClose: '.elementor-button',
            beforeClose: function( event ) {
                if ( ! $( event.target ).hasClass( 'elementor-button' ) ) {
                    return;
                }
                
                var $code = $( '#verification-code' );
                $( '#otp-code' ).val( $code.val() );
                
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