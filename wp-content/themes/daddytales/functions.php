<?php
/**
 * @package WordPress
 * @subpackage daddytales
 */

function inclusion_enqueue() {
	$ver_num = mt_rand();
	wp_enqueue_style( 'main', get_template_directory_uri() . '/static/css/main.min.css', [], $ver_num, 'all' );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/static/js/main.min.js', ['jquery'], $ver_num, true );
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

/**
 * Clean incoming value from trash.
 *
 * @param	mixed	$value	- some value to clean.
 * @return	mixed	$value	- the same value, but cleaned.
 */
function dt_clean_value( $value )
{
	$value = trim( $value );
	$value = stripslashes( $value );
	$value = strip_tags( $value );
	$value = htmlspecialchars( $value );
	return $value;
}

require_once get_template_directory() . '/tgmpa/daddytales.php';

/**
 * Get post views count.
 */
function dt_get_post_views( $post_id ){
    $count_key = 'post_views_count';
    $count = get_post_meta( $post_id, $count_key, true );

    if( $count === '' ){
        delete_post_meta( $post_id, $count_key );
        add_post_meta( $post_id, $count_key, '0' );
        return '0';
    }

    return $count;
}

/**
 * Set post views count.
 */
function dt_set_post_views( $post_id ){
    $count_key = 'post_views_count';
    $count = get_post_meta( $post_id, $count_key, true );

    if( $count === '' ){
        $count = 0;
        delete_post_meta( $post_id, $count_key );
        add_post_meta( $post_id, $count_key, '0' );
    }	else {
        $count++;
        update_post_meta( $post_id, $count_key, $count );
    }
}

/**
 * Remove double view count when opening post.
 */
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

/**
 * Posts views in Admin Console.
 */
add_filter( 'manage_posts_columns', 'dt_posts_column_views' );
add_filter( 'manage_pages_columns', 'dt_posts_column_views' );
function dt_posts_column_views( $defaults ){
    $defaults['post_views'] = esc_html__( 'Views' );
    return $defaults;
}
add_action( 'manage_posts_custom_column', 'dt_posts_custom_column_views', 5, 2 );
add_action( 'manage_pages_custom_column', 'dt_posts_custom_column_views', 5, 2 );
function dt_posts_custom_column_views( $column_name, $id ){
    if( $column_name === 'post_views' ) echo dt_get_post_views( get_the_ID() );
}

