( function( $ ){
    'use strict';

    var isAjaxOn = false;   // If true - AJAX is working.

	$( function(){
        onPaginationLinkClick();
	} );

    /**
     * Pagination.
     */
    function onPaginationLinkClick(){
        if( ! $( '.page-numbers' ).length ) return;

        $( 'body' ).on( 'click', '.page-numbers:not(.current)', function( e ){
            e.preventDefault();
            if (isAjaxOn) return;

            isAjaxOn = true;
            var section = $( '.tax-posts' );
            var searchQuery = $( '.tax-pagination-wrapper' ).attr( 'data-search-query' );
            var postType, taxonomy, term;

            // If this is search results page.
            if( searchQuery ){
                postType = taxonomy = term = null;
            }   else {
                postType = $( '.tax-pagination-wrapper' ).attr( 'data-type' );
                taxonomy = $( '.tax-pagination-wrapper' ).attr( 'data-taxonomy' );
                term = $( '.tax-pagination-wrapper' ).attr( 'data-term' );
            }

            var page, currentPageNumber, newPageNumber;

            page = $( this );
            currentPageNumber = parseInt( $.trim( $( '.page-numbers.current' ).text() ) );

            if( page.hasClass( 'prev' ) ) newPageNumber = currentPageNumber - 1;
            else if( page.hasClass( 'next' ) ) newPageNumber = currentPageNumber + 1;
            else newPageNumber = parseInt( $.trim( $( this ).text() ) );

            // Disable section with vendors previews.
            section.addClass( 'disabled' );

            // Data for AJAX request.
            var ajaxData = {
                action      : 'dt_ajax_posts_pagination',
                page        : newPageNumber,
                type        : postType,
                taxonomy    : taxonomy,
                term        : term,
                search      : searchQuery
            };

            // AJAX POST request.
            $.post( window.wp_data.ajax_url, ajaxData, function( data ){
                switch( data.success ){
                    // If ajax response is success.
                    case true:
                        section.html( data.data.posts );
                        $( '.tax-pagination-wrapper' ).html( data.data.pagination );
                        // Smoth scroll to the top of the section.
                        $( 'html, body' ).animate( {
                            scrollTop: section.offset().top - 180
                        }, 350);
                        section.removeClass( 'disabled' );

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