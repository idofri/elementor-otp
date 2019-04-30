jQuery( function( $ ) {

    function formSubmit( event, xhr ) {
        if ( xhr.responseJSON.data && ! xhr.responseJSON.data.verify ) {
            return;
        }

        var $form = $( event.target );
        var $code = $form.find( '[name="otp-code"]' );
        var $token = $form.find( '[name="otp-token"]' );

        // Token
        if ( xhr.responseJSON.data.token ) {
            $token.val( xhr.responseJSON.data.token );
        }

        $.featherlight( $code.closest( '.elementor-widget-form' ), {
            closeIcon: '',
            otherClose: '.elementor-button',
            beforeContent: function( event ) {
                console.log(event);
            },
            beforeClose: function( event ) {
                if ( ! $( event.target ).hasClass( 'elementor-button' ) ) {
                    return;
                }

                $code.val( $( event.currentTarget ).find( '[name="otp-code"]' ).val() );
                $form.trigger( 'submit' );
            }
        } );
    }

    $( 'form.elementor-form' ).ajaxSuccess( formSubmit );

    $( 'form.elementor-form' ).on( 'error submit_success', function( event ) {
        var $code = $( event.target ).find( '[name="otp-code"]' );
        if ( $code ) {
            $code.val('');
        }
    } );

    $( 'form.elementor-form' ).on( 'submit_success', function( event ) {
        var $token = $( event.target ).find( '[name="otp-token"]' );
        if ( $token ) {
            $token.val('');
        }
    } );

    // jQuery Mask
    $( '[data-mask]' ).each( function() {
        $( this ).mask( $( this ).attr( 'data-mask' ) );
    } );

} );