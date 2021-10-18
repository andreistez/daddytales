( function( $ ){
    'use strict';

	$( function(){
		slidesTaleSliderInit();
	} );

	/**
	 * Slider initialization.
	 */
	function slidesTaleSliderInit(){
		if( ! $( '.slidestales-slider' ).length || ! $().slick() ) return;

		var slider = $( '.slidestales-slider' );
		slider.slick( {
			infinite		: false,
			dots			: true,
			arrows			: true,
			autoplay		: false,
			autoplaySpeed	: 2000,
			speed			: 1000,
			cssEase			: 'linear',
			prevArrow		: '<button class="cwp-slider-nav__button cwp-slider-nav__prev"><i class="fas fa-angle-left"></i></button>',
			nextArrow		: '<button class="cwp-slider-nav__button cwp-slider-nav__next"><i class="fas fa-angle-right"></i></button>'
		} );
	}
} )( jQuery );