( function( $ ){
    'use strict';

	$( function(){
		setSongPath();
	} );

	/**
	 * Set song path.
	 */
	function setSongPath(){
		if(
			! $( 'body' ).hasClass( 'single-song' )
			|| ! $( '.song-download .button' ).length
			|| ! $( '.wp-block-audio audio' ).length
		) return;

		var button	= $( '.song-download .button' );
		var song	= $( '.wp-block-audio audio' ).attr( 'src' );

		if( ! song ) return;

		button.attr( 'href', song );
	}
} )( jQuery );