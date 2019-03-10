jQuery( function( $ ) {
    
    $( 'body' ).on( 'error', function( event ) {
        
        var $form = $( event.target );
        if ( $form.find( '.elementor-message-danger' ).length ) {
            return;
        }
        
        $form.ajaxSuccess(function( event, xhr, settings ) {
            // console.log(xhr.responseJSON);
        } );
        
        var $content = $form.find( '.elementor-otp' );
        $.featherlight( $content, {
            root: $form,
            otherClose: '.elementor-button',
            afterClose: function( event ) {
                if ( $( event.target ).hasClass( 'featherlight-close' ) ) {
                    return;
                }
                $form.trigger( 'submit' );
            }
        } );
        
    } );
    
} );