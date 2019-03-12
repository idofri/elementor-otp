jQuery( function( $ ) {
    
    function formSubmit( event, xhr, settings ) {
        
        if ( ! xhr.responseJSON.data.otp ) {
            return;
        }
        
        var $form = $( event.target );
        
        $.featherlight( $form.find( '.elementor-otp' ), {
            root: '.elementor-2',
            closeIcon: '',
            otherClose: '.elementor-button',
            afterOpen: function( event ) {
                console.log(event);
                $( event.target ).siblings( 'input' ).prop( 'required', true );
            },
            afterClose: function( event ) {
                if ( ! $( event.target ).hasClass( 'elementor-button' ) ) {
                    return;
                }
                
                var $code = $( event.target ).siblings( 'input' );
                if ( $( '#code' ).length ) {
                    $( '#code' ).val( $code.val() );
                } else {
                    $( '<input>' ).attr( {
                        type: 'hidden',
                        id: 'code',
                        name: 'code',
                        value: $code.val()
                    } ).appendTo( $form );
                }
                
                $form.trigger( 'submit' );
            }
        } );
        
    }
    
    $( 'form.elementor-form' ).ajaxSuccess( formSubmit );
    
    $( 'form.elementor-form' ).on( 'error submit_success', function( event ) {
        $( '#code' ).remove();
    } );
    
} );