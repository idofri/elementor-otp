jQuery( function( $ ) {
    
    $( 'body' ).on( 'error', function( event ) {
        var $form = $( event.target );
        var $flBox = $form.find( '.elementor-otp' );
        var $verify = $flBox.find( 'button' );
        $.featherlight( $flBox, {
            afterClose: function() {
                $form.trigger( 'submit' );
            }
        } );
        
        $( document ).on( 'click', '.elementor-button', function() {
            var current = $.featherlight.current();
            current.close();
        } );
    });
    
} );