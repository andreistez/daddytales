( function( $ ){
    'use strict';

	var targetElement;
	var framesArray = [];

	$( function(){
		onThumbClick();
		closeThumbPopup();

		cartoonFramesSliderInit();
		onFrameClick();
		framePopupClickPrev();
		framePopupClickNext();
	} );

	/**
	 * Clicking on cartoon thumbnail.
	 */
	function onThumbClick(){
		if( ! $( '.cartoon-info-thumb' ).length ) return;

		$( 'body' ).on( 'click', '.cartoon-info-thumb', function(){
			var thumb = $( this );
			var full = $.trim( thumb.data( 'full' ) );
			if( ! full ) return;

			// Add pop-up with full-size image in DOM.
			$( 'body' ).append(
				'<div id="modal-cartoon-thumb-wrapper" class="modal-cartoon-wrapper">' +
					'<img src="' + full + '" alt="" />' +
					'<i class="fas fa-times modal-cartoon-wrapper__close"></i>' +
				'</div>'
			);

			// Show pop-up.
			setTimeout( function(){
				$( '.modal-cartoon-wrapper' ).addClass( 'visible' );
			}, 10 );

			// Disable scroll.
			targetElement = document.querySelector( '#modal-cartoon-thumb-wrapper' );
			bodyScrollLock.disableBodyScroll( targetElement, { reserveScrollBarGap: true } );
		} );
	}

	/**
	 * Header mobile menu close.
	 */
	function closeThumbPopup() {
		$( 'body' ).on( 'click', '.modal-cartoon-wrapper, .modal-cartoon-wrapper__close', function( e ){
			e.stopPropagation();

			var modalWrapper = $( '.modal-cartoon-wrapper' );

			if( ! modalWrapper.is( e.target ) && ! $( '.modal-cartoon-wrapper__close' ).is( e.target ) ) return;

			modalWrapper.removeClass( 'visible' );
			setTimeout( function(){
				modalWrapper.remove();
				bodyScrollLock.enableBodyScroll( targetElement );
			}, 350 );
		} );
	}

	/**
     * Slider initialization.
     */
	function cartoonFramesSliderInit(){
		if( ! $( '.cartoon-frames' ).length || ! $().slick() ) return;

		var slider = $( '.cartoon-frames' );
		slider.slick({
			slidesToShow	: 1,
			slidesToScroll	: 1,
			infinite		: false,
			dots			: false,
			arrows			: true,
			autoplay		: false,
			autoplaySpeed	: 2000,
			speed			: 1000,
			cssEase			: 'linear',
			prevArrow		: '<button class="cwp-slider-nav__button cwp-slider-nav__prev"><i class="fas fa-angle-left"></i></button>',
			nextArrow		: '<button class="cwp-slider-nav__button cwp-slider-nav__next"><i class="fas fa-angle-right"></i></button>',
			mobileFirst		: true,
			responsive		: [
				{
					breakpoint: 767,
					settings: {
						slidesToShow	: 2
					}
				},
				{
					breakpoint: 991,
					settings: {
						slidesToShow	: 3
					}
				},
				{
					breakpoint: 1199,
					settings: {
						slidesToShow	: 4
					}
				}
			]
		} );
    }

	/**
	 * Clicking on cartoon frames images.
	 */
	function onFrameClick(){
		if( ! $( '.cartoon-frame__img' ).length || ! $( '.cartoon-frame__preview' ).length ) return;

		$( 'body' ).on( 'click', '.cartoon-frame__preview', function(){
			var thumb = $( this );
			var full = thumb.closest( '.cartoon-frame-inner' ).find( '.cartoon-frame__img' ).attr( 'src' );
			if( ! full ) return;

			// Add pop-up with full-size image in DOM.
			$( 'body' ).append(
				'<div id="modal-cartoon-thumb-wrapper" class="modal-cartoon-wrapper">' +
					'<img src="' + full + '" alt="" />' +
					'<div class="modal-cartoon-wrapper__buttons">' +
						'<i class="fas fa-times modal-cartoon-wrapper__close"></i>' +
						'<i class="fas fa-angle-left modal-cartoon-wrapper__left"></i>' +
						'<i class="fas fa-angle-right modal-cartoon-wrapper__right"></i>' +
					'</div>' +
				'</div>'
			);

			// Show pop-up.
			setTimeout( function(){
				$( '.modal-cartoon-wrapper' ).addClass( 'visible' );
			}, 10 );

			// Disable scroll.
			targetElement = document.querySelector( '#modal-cartoon-thumb-wrapper' );
			bodyScrollLock.disableBodyScroll( targetElement, { reserveScrollBarGap: true } );

			framesArray = $( '.cartoon-frame.slick-slide' );
		} );
	}

	/**
	 * Clicking 'previous' button on cartoon frames pop-up.
	 */
	function framePopupClickPrev(){
		if( ! $( '.cartoon-frame__img' ).length || ! $( '.cartoon-frame__preview' ).length ) return;

		$( 'body' ).on( 'click', '.modal-cartoon-wrapper__left', function(){
			var slide, slideID;
			var src = $( '.modal-cartoon-wrapper img' ).attr( 'src' );

			// Find slider element with this image.
			for( var i = 0; i < framesArray.length; i++ ){
				var frame = framesArray[i];

				// If found - exit function.
				if( $( '.cartoon-frame__img', frame ).attr( 'src' ) === src ){
					slide = frame;
					slideID = i;
					break;
				}
			}

			// If found.
			if( slide ){
				slideID--;
				slideID = ( slideID < 1 ) ? ( framesArray.length - 1 ) : slideID;
				var prevSlide = framesArray[slideID];

				var prevSrc = $( prevSlide ).find( '.cartoon-frame__img' ).attr( 'src' );
				$( '.modal-cartoon-wrapper img' ).attr( 'src', prevSrc );
			}
		} );
	}

	/**
	 * Clicking 'next' button on cartoon frames pop-up.
	 */
	function framePopupClickNext(){
		if( ! $( '.cartoon-frame__img' ).length || ! $( '.cartoon-frame__preview' ).length ) return;

		$( 'body' ).on( 'click', '.modal-cartoon-wrapper__right', function(){
			var slide, slideID;
			var src = $( '.modal-cartoon-wrapper img' ).attr( 'src' );

			// Find slider element with this image.
			for( var i = 0; i < framesArray.length; i++ ){
				var frame = framesArray[i];

				// If found - exit function.
				if( $( '.cartoon-frame__img', frame ).attr( 'src' ) === src ){
					slide = frame;
					slideID = i;
					break;
				}
			}

			// If found.
			if( slide ){
				slideID++;
				slideID = ( slideID > ( framesArray.length - 1 ) ) ? 0 : slideID;
				var nextSlide = framesArray[slideID];

				var nextSrc = $( nextSlide ).find( '.cartoon-frame__img' ).attr( 'src' );
				$( '.modal-cartoon-wrapper img' ).attr( 'src', nextSrc );
			}
		} );
	}
} )( jQuery );