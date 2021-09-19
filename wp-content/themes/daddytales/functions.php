<?php
/**
 * @package WordPress
 * @subpackage daddytales
 */

function inclusion_enqueue() {
	$ver_num = mt_rand();
	wp_enqueue_style( 'main', get_template_directory_uri() . '/static/css/main.min.css', [], $ver_num, 'all' );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/static/js/main.min.js', ['jquery'], $ver_num, true );

	// Comments on single posts.
	if(
		( is_singular( 'post' ) || is_singular( 'cartoon' ) )
		&& comments_open() && get_option( 'thread_comments' )
	) wp_enqueue_script( 'comment-reply' );
}
add_action( 'wp_enqueue_scripts', 'inclusion_enqueue' );

add_theme_support( 'post-thumbnails' );

// Register menu
register_nav_menus(
	[
		'header_menu'	=> 'Header Menu',
		'footer_menu'	=> 'Footer Menu'
	]
);

/**
 * Dequeue plugins styles.
 */
function dt_custom_dequeue() {
	wp_dequeue_style( 'fw-ext-builder-frontend-grid' );
	wp_deregister_style( 'fw-ext-builder-frontend-grid' );
	wp_dequeue_style( 'fw-ext-forms-default-styles' );
	wp_deregister_style( 'fw-ext-forms-default-styles' );
	wp_dequeue_style( 'fw-shortcode-section' );
	wp_deregister_style( 'fw-shortcode-section' );
	wp_dequeue_style( 'wp-block-library' );
	wp_deregister_style( 'wp-block-library' );
}
add_action( 'wp_enqueue_scripts', 'dt_custom_dequeue', 9999 );
add_action( 'wp_head', 'dt_custom_dequeue', 9999 );
add_action( 'wp_print_styles', 'dt_custom_dequeue' );

/**
 * JS variables for frontend, such as AJAX URL.
 */
function js_vars_for_frontend() {
	$variables = ['ajax_url' => admin_url( 'admin-ajax.php' )];
	echo (
		'<script type="text/javascript">window.wp_data = '
		. json_encode( $variables ) .
		';</script>'
	);
}
add_action( 'wp_head', 'js_vars_for_frontend' );

/**
 * Remove unnecessary text from Archive title.
 */
add_filter( 'get_the_archive_title', function( $title ) {
	return preg_replace( '~^[^:]+: ~', '', $title );
} );

// TGMPA - notify Administrator to install required plugins.
require_once get_template_directory() . '/tgmpa/daddytales.php';
// Theme functions to avoid large size of code here.
require_once get_template_directory() . '/theme-functions/theme-functions.php';
// Theme AJAX functions.
require_once get_template_directory() . '/theme-functions/theme-ajax-functions.php';
// Kinopoisk API functions.
require_once get_template_directory() . '/theme-functions/kinopoisk-api.php';

