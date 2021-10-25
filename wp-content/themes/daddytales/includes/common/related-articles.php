<?php
/**
 * Related Articles slider.
 *
 * @package WordPress
 * @subpackage industrialcyber
 */

if( ! is_single() ) return;

$post_id	= get_the_ID();
$post_type	= get_post_type( $post_id );

$related_query = new WP_Query(
	[
		'post_type'			=> $post_type,
		'post_status'		=> 'publish',
		'posts_per_page'	=> 12,
		'post__not_in'		=> [$post_id],
		'orderby'			=> 'rand'
	]
);

if( ! $related_query->have_posts() ){
	wp_reset_query();
	return;
}
?>

<div class="related white-wrapper">
	<h3 class="related__title">
		<?php esc_html_e( 'Похожие записи', 'daddytales' ) ?>
	</h3>

	<div class="cwp-slider related-slider">
		<?php
		while( $related_query->have_posts() ){
			$related_query->the_post();
			get_template_part( 'includes/single/slider', 'preview' );
		}
		wp_reset_query();
		?>
	</div>
</div><!-- .related -->

