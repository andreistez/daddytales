( function( $ ){
    'use strict';

    var isAjaxOn = false;   // If true - AJAX is working.

	$( function(){
        login();
        logout();
        lostPassword();
        register();
	} );

    /**
     * AJAX login.
     */
    function login(){
        if (! $('.dt-login').length) return;

        $( 'body' ).on( 'submit', '.dt-login', function( e ){
            e.preventDefault();
            if( isAjaxOn ) return;

            isAjaxOn = true;
            var form = $( '.dt-login' );
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
                action      : 'dt_ajax_login',	// Name of the function in theme/theme-functions/theme-ajax-functions.php.
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
                        setTimeout( function(){
                            window.location.href = data.data.redirect;
                            // Enable AJAX.
                            isAjaxOn = false;
                        }, 1000 );
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

    /**
     * AJAX logout.
     */
    function logout(){
        if( ! $( '.dt-logout' ).length ) return;

        $( 'body' ).on( 'click', '.dt-logout', function( e ){
            e.preventDefault();
            if( isAjaxOn ) return;
            isAjaxOn = true;
            var link = $( '.dt-logout' );
            link.text( 'Выход...' );

            // Data for AJAX request.
            var ajaxData = {
                action: 'dt_ajax_logout'	// Name of the function in theme/theme-functions/theme-ajax-functions.php.
            };

            // AJAX POST request.
            $.post( window.wp_data.ajax_url, ajaxData, function( data ){
                switch( data.success ){
                    // If ajax response is success.
                    case true:
                        link.text( data.data.msg );
                        window.location.href = data.data.redirect;
                        // Enable AJAX.
                        isAjaxOn = false;
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

    /**
     * AJAX lost password.
     */
    function lostPassword(){
        if( ! $( '.dt-lostpass' ).length ) return;

        $( 'body' ).on( 'submit', '.dt-lostpass', function( e ){
            e.preventDefault();
            if( isAjaxOn ) return;

            isAjaxOn = true;
            var form = $( '.dt-lostpass' );
            var note = $( '.note', form );
            var formData = form.serialize();

            // Clear and hide note field.
            if( ! note.hasClass( 'hidden' ) ){
                note.html( '' );
                note.addClass( 'hidden' );
            }

            // Disable form.
            form.addClass( 'disabled' );

            // Data for AJAX request.
            var ajaxData = {
                action      : 'dt_ajax_lost_password',	// Name of the function in theme/theme-functions/theme-ajax-functions.php.
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
                        // Enable AJAX.
                        isAjaxOn = false;
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

    /**
     * AJAX register.
     */
    function register(){
        if( ! $( '.dt-register' ).length ) return;

        $( 'body' ).on( 'submit', '.dt-register', function( e ){
            e.preventDefault();
            if( isAjaxOn ) return;
            isAjaxOn = true;
            var form = $( '.dt-register' );
            var note = $( '.note', form );
            // Serialize all form fields data.
            var formData = form.serialize();

            // Clear and hide note field.
            if( ! note.hasClass( 'hidden' ) ){
                note.html( '' );
                note.addClass( 'hidden' );
            }

            // Disable form.
            form.addClass( 'disabled' );
            // Data for AJAX request.
            var ajaxData = {
                action      : 'dt_ajax_register',	// Name of the function in theme/theme-functions/theme-ajax-functions.php.
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
                        // Enable AJAX.
                        isAjaxOn = false;
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