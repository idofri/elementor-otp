jQuery( function( $ ) {
    
    $( 'body' ).on( 'error', function( event ) {
        
        var $form = $( event.target );
        if ( $form.find( '.elementor-message-danger' ).length ) {
            return;
        }
        
        var otpInitialized = false;

        $form.ajaxSuccess(function( event, xhr, settings ) {
            otpInitialized = true;
            // console.log(event);
            console.log(xhr.responseJSON);
            // console.log(settings);
        } );

        alert(initialized);

        // console.log($form);
        // console.log(event);

        var $content = $form.find( '.elementor-otp' );
        $.featherlight( $content, {
            root: $form,
            otherClose: '.elementor-button',
            afterClose: function() {
                $form.trigger( 'submit' );
            }
        } );
        
    } );
    
} );