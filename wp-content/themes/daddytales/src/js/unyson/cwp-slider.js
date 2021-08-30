( function( $ ){
    'use strict';

	$( function(){
		cwpSliderInit();
	} );

	/**
     * Slider initialization.
     */
	function cwpSliderInit(){
		if( ! $( '.cwp-slider' ).length || ! $().slick() ) return;

		$( '.cwp-slider' ).each( function( index, elem ){
			var slider = $( this );
			slider.slick({
				slidesToShow	: 1,
				slidesToScroll	: 1,
				infinite		: true,
				dots			: false,
				arrows			: true,
				autoplay		: true,
				autoplaySpeed	: 2000,
				speed			: 1000,
				cssEase			: 'linear',
				prevArrow		: '<button class="cwp-slider-nav__button cwp-slider-nav__prev"><i class="fas fa-angle-left"></i></button>',
				nextArrow		: '<button class="cwp-slider-nav__button cwp-slider-nav__next"><i class="fas fa-angle-right"></i></button>',
				mobileFirst		: true,
				responsive		: [
					{
						breakpoint: 479,
						settings: {
							slidesToShow	: 2
						}
					},
					{
						breakpoint: 767,
						settings: {
							slidesToShow	: 3
						}
					},
					{
						breakpoint: 991,
						settings: {
							slidesToShow	: 4
						}
					},
					{
						breakpoint: 1199,
						settings: {
							slidesToShow	: 5
						}
					},
					{
						breakpoint: 1365,
						settings: {
							slidesToShow	: 6
						}
					},
					{
						breakpoint: 1599,
						settings: {
							slidesToShow	: 7
						}
					},
					{
						breakpoint: 1899,
						settings: {
							slidesToShow	: 8
						}
					}
				]
			} );
		} );
    }
} )( jQuery );