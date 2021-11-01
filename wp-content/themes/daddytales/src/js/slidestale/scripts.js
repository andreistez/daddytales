( function( $ ){
    'use strict';

	var targetElement;
	var windowHeight;

	$( function(){
		slidesTaleSliderInit();
		openPopup();
		closePopup();
	} );

	/**
     * Resizing window.
     */
	function windowOnResize(){
        windowHeight = $( window ).height();
		checkPopupSlides( windowHeight );
    }
    $( window ).on( 'resize', function(){
        windowOnResize();
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

	/**
	 * Open popup slider with the same images
	 * as original slider.
	 */
	function openPopup(){
		if( ! $( '.slidestales-slide__img' ).length ) return;

		$( 'body' ).on( 'click', '.slidestales-slide__img', function(){
			// Popup already exists.
			if( $( '#popup-slider-wrapper' ).length ) return;

			var slides			= [];
			windowHeight		= $( window ).height();

			// Fill popup slides array with cloned original images.
			$( '.slidestales-slide' ).each( function( index, elem ){
				var clonedSlide = $( this ).clone();
				clonedSlide.removeAttr( 'id class aria-describedby tabindex role style aria-hidden data-slick-index' );
				clonedSlide.addClass( 'slidestales-slide' );
				slides.push( clonedSlide );
			} );

			$( 'body' ).append(
				'<div id="popup-slider-wrapper" class="popup-slider-wrapper">' +
					'<div class="popup-slider"></div>' +
					'<div class="popup-slider__close">' +
						'<i class="fas fa-times"></i>' +
					'</div>' +
				'</div>'
			);

			for( var i = 0; i < slides.length; i++ ){
				$( '.popup-slider' ).append( slides[i] );
				var image = $( '.popup-slider .slidestales-slide:nth-child(' + ( i + 1 ) + ') .slidestales-slide__img' );
				fixSlideImageHeight( image );
			}

			// Disable scroll, except target element.
			targetElement = document.querySelector( '#popup-slider-wrapper' );
			bodyScrollLock.disableBodyScroll( targetElement, { reserveScrollBarGap: true } );
		} );
	}

	/**
	 * Close popup slider.
	 */
	function closePopup(){
		$( 'body' ).on( 'click', '.popup-slider-wrapper, .popup-slider__close', function( e ){
			e.stopPropagation();

			if(
				! $( '.popup-slider-wrapper' ).is( e.target )
				&& ! $( '.popup-slider' ).is( e.target )
				&& ! $( '.popup-slider__close' ).is( e.target )
				&& ! $( '.popup-slider__close i' ).is( e.target )
			) return;

			$( '.popup-slider-wrapper' ).remove();
			bodyScrollLock.enableBodyScroll( targetElement );
		} );
	}

	/**
	 * Check popup slides for correct sizes.
	 *
	 * @param {int} windowHeight - window.height().
	 */
	function checkPopupSlides( windowHeight ){
		if( ! $( '.popup-slider' ).length ) return;

		$( '.popup-slider .slidestales-slide' ).each( function( index, elem ){
			var slide		= $( this );
			var image		= $( '.slidestales-slide__img', slide );
			fixSlideImageHeight( image );
		} );
	}

	/**
	 * Fix image height if it is larger than window.
	 *
	 * @param {jQuery} image - <img /> jQuery element.
	 */
	function fixSlideImageHeight( image ){
		// Set default size.
		image.css( {
			'width'		: '100%',
			'height'	: 'auto',
			'max-height': 'none'
		} );
		console.log( image );
		var imageHeight	= image.css( 'height' ).replace( 'px', '' );

		if( imageHeight > windowHeight - 100 ){
			image.css( {
				'max-height': ( windowHeight - 100 ) + 'px',
				'width'		: 'auto'
			} );
		}
	}
} )( jQuery );