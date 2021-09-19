( function( $ ){
    'use strict';

    var isAjaxOn = false;   // If true - AJAX is working.

	$( function(){
        login();
        logout();
        lostPassword();
        register();
        saveProfile();
        invite();
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
                        document.location.reload();
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

    /**
     * AJAX save profile changes.
     */
    function saveProfile(){
        if( ! $( '.user-fields' ).length ) return;

        $( 'body' ).on( 'submit', '.user-fields', function( e ){
            e.preventDefault();
            if( isAjaxOn ) return;
            isAjaxOn = true;
            var form = $( this );
            var note = $( '.note', form );

            // Clear and hide note field.
            if( ! note.hasClass( 'hidden' ) ){
                note.html( '' );
                note.addClass( 'hidden' );
            }

            // Disable form.
            form.addClass( 'disabled' );

            var form_data = new FormData( $( '#user-fields' )[0] );
            form_data.append( 'action', 'dt_ajax_save_profile_changes' );

            // AJAX POST request.
            $.ajax( {
                type        : 'POST',
                url         : window.wp_data.ajax_url,
                data        : form_data,
                processData : false,
                contentType : false
            } ).done( function( data ){
                form.removeClass( 'disabled' );
                note.removeClass( 'hidden' );
                note.html( data.data.msg );

                switch( data.success ){
                    case true:
                        // Reload profile page.
                        location.reload();
                        // Enable AJAX.
                        isAjaxOn = false;
                        break;

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
     * AJAX send invite to a friend -
     * sends a letter to future member E-mail.
     */
    function invite(){
        if( ! $( '.user-invite' ).length ) return;

        $( 'body' ).on( 'submit', '.user-invite', function( e ){
            e.preventDefault();
            if( isAjaxOn ) return;
            isAjaxOn = true;
            var form = $( '.user-invite' );
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
                action      : 'dt_ajax_invite_friend',	// Name of the function in theme/theme-functions/authorize/ajax-functions.php.
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
                        // Clear fields.
                        $( 'input', form ).val( '' );
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