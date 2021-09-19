( function( $ ){
    'use strict';

    var isAjaxOn = false;   // If true - AJAX is working.

	$( function(){
        sendModalLetter();
	} );

    /**
     * AJAX send E-mail to Administrator from modal form.
     */
    function sendModalLetter(){
        if ( ! $('.modal-wrapper').length ) return;

        $( 'body' ).on( 'submit', '.modal', function( e ){
            e.preventDefault();
            if( isAjaxOn ) return;

            isAjaxOn = true;
            var form = $( '.modal' );
            var note = $( '.note', form );
            var formData = form.serialize();

            // Clear and hide note field.
            if ( ! note.hasClass( 'hidden' ) ) {
                note.html( '' );
                note.addClass( 'hidden' );
            }

            // Disable form.
            form.addClass( 'disabled' );

            // Data for AJAX request.
            var ajaxData = {
                action      : 'dt_ajax_get_in_touch_form_send',	// Name of the function in theme/theme-functions/theme-ajax-functions.php.
                form_data   : formData
            };

            // AJAX POST request.
            $.post( window.wp_data.ajax_url, ajaxData, function( data ){
                form.removeClass( 'disabled' );
                note.removeClass( 'hidden' );
                note.html( data.data.msg );

                switch( data.success ){
                    // If ajax response is success.
                    case true:
                        $( '.input, .textarea', form ).val( '' );
                        break;

                    // If we have errors.
                    case false:
                        // Show error in console.
                        console.error( data.data.msg );
                        // Enable AJAX.
                        isAjaxOn = false;
                        break;
                }
            } );
        } );
    }
} )( jQuery );