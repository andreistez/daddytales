( function( $ ){
    'use strict';

	$( function(){
		columnSliderInit();
	} );

	/**
     * Slider initialization.
     */
	function columnSliderInit(){
		if( ! $( '.latest-col-posts' ).length || ! $().slick() ) return;

		$( '.latest-col-posts' ).each( function( index, elem ){
			var slider = $( this );
			var sliderTitle = slider.parent().find( '.latest-col-title' );
			slider.slick({
				slidesToShow	: 1,
				rows			: 4,
				infinite		: false,
				dots			: false,
				arrows			: true,
				prevArrow		: '<button class="cwp-slider-nav__button cwp-slider-nav__prev"><i class="fas fa-angle-left"></i></button>',
				nextArrow		: '<button class="cwp-slider-nav__button cwp-slider-nav__next"><i class="fas fa-angle-right"></i></button>',
				appendArrows	: sliderTitle,
				autoplay		: false
			} );
		} );
    }
} )( jQuery );