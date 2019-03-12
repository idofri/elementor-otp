jQuery( function( $ ) {
    
    function formSubmit( event, xhr, settings ) {
        
        if ( ! xhr.responseJSON.data.otp ) {
            return;
        }
        
        var $form = $( event.target );
        var $content = $form.find( '.elementor-otp' );
        
        $.featherlight( $content, {
            root: $form,
            closeIcon: '',
            otherClose: '.elementor-button',
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
    
    // $( 'document' ).ajaxSuccess( formSubmit );
    $( 'form.elementor-form' ).ajaxSuccess( formSubmit );
    
    $( 'form.elementor-form' ).on( 'error', function( event ) {
        $( '#code' ).remove();
    } );
    
} );