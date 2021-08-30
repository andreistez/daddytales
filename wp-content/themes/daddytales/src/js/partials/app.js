( function( $ ){
    'use strict';

	var targetElement;
	var windowWidth;

	/**
	 * Preloader.
	 */
	$( window ).on( 'load', function(){
		if( ! $( '.lds-ring' ).length ) return;

		$( '.lds-ring' ).animate( {
			opacity : '0'
		}, 500, function(){
			$( '.lds-ring' ).remove();
		} );
	} );

	$( function(){
		objectFitImages( 'img' );

		windowOnResize();

		openMobileMenu();
		closeMobileMenu();
		headerSubMenuToggle();
	} );

	/**
     * Resizing window.
     */
	function windowOnResize(){
        windowWidth = window.innerWidth;
		isMobile( windowWidth );
    }
    $( window ).on( 'resize', function(){
        windowOnResize();
    } );

	/**
	 * Function checks window width to know if this is small screen or large.
	 */
	function isMobile( windowWidth ){
		if( windowWidth < 1200 ){
			$( '.header-nav-wrapper' ).addClass( 'mobile' );
		}	else {
			$( '.header-nav-wrapper' ).removeClass( 'mobile' );
			$( '.header-nav-wrapper .sub-menu' ).removeClass( 'active visible' );
			$( '.header-nav-wrapper .menu-item-has-children' ).removeClass( 'active' );
			$( '.header-nav-wrapper .menu-item-has-children' ).css( 'margin-bottom', '0' );
		}
	}

	/**
	 * Open mobile menu by clicking on bars icon in header.
	 */
	function openMobileMenu(){
		if( ! $( '.header-nav__mobile' ).length ) return;

		$( '.header' ).on( 'click', '.header-nav__mobile', function(){
			var menuContainer = $( '#header-nav');
			// Do nothing if menu is already opened.
			if( menuContainer.hasClass( 'active visible' ) ) return;

			// Appear menu.
			menuContainer.addClass( 'active' );
			setTimeout( function(){
				menuContainer.addClass( 'visible' );
			}, 10);

			// Appear close cross.
			$( '.header-nav__close' ).addClass( 'active' );
			setTimeout( function(){
				$( '.header-nav__close' ).addClass( 'visible' );
			}, 10);

			// Disable scroll, except target element.
			targetElement = document.querySelector( '#header-nav' );
			bodyScrollLock.disableBodyScroll( targetElement, { reserveScrollBarGap: true } );
		} );
	}

	/**
	 * Header mobile menu close.
	 */
	function closeMobileMenu() {
		if (! $( '.header-nav__close' ).length ) return;

		$( '.header' ).on( 'click', '.header-nav__close', function(){
			$( '.header-nav, .header-nav__close' ).removeClass( 'visible' );
			setTimeout( function(){
				$( '.header-nav, .header-nav__close' ).removeClass( 'active' );
				bodyScrollLock.enableBodyScroll( targetElement );
			}, 350 );
		} );
	}

	/**
	 * Header mobile navigation sub-menu open/close.
	 */
	function headerSubMenuToggle(){
		if( ! $( '.menu-item-has-children' ).length || windowWidth >= 1200 ) return;

		// Click on menu item with children, NOT on link.
		$( '.header' ).on( 'click', '.header-nav .menu-item-has-children', function(){
			if( ! $( '.header-nav-wrapper' ).hasClass( 'mobile' ) ) return;

			var item = $( this );
			var subMenu = $( '> .sub-menu', item );

			// If sub-menu is closed now.
			if( ! item.hasClass( 'active' ) ){
				item.addClass( 'active' );
				subMenu.addClass( 'active' );
				setTimeout( function(){
					subMenu.addClass( 'visible' );
				}, 10 );

				var subMenuHeight = 0;

				$( '> .menu-item', subMenu ).each( function( index, elem ){
					subMenuHeight += $( this ).outerHeight( true );
				} );

				item.css( 'margin-bottom', subMenuHeight + 'px' );
			}	else {	// If sub-menu is opened now.
				item.removeClass( 'active' );
				item.css( 'margin-bottom', '0' );
				subMenu.removeClass( 'visible' );
				setTimeout( function(){
					subMenu.removeClass( 'active' );
				}, 350 );
			}
		} );
	}
} )( jQuery );