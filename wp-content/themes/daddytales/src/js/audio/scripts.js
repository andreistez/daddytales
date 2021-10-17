( function( $ ){
    'use strict';

	$( function(){
		setAudioPath();
	} );

	/**
	 * Set song path.
	 */
	function setAudioPath(){
		if(
			! $( 'body' ).hasClass( 'single-audio' )
			|| ! $( '.audio-download .button' ).length
			|| ! $( '.wp-block-audio audio' ).length
		) return;

		var button	= $( '.audio-download .button' );
		var song	= $( '.wp-block-audio audio' ).attr( 'src' );

		if( ! song ) return;

		button.attr( 'href', song );
	}
} )( jQuery );