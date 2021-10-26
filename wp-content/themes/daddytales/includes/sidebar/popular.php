<?php
/**
 * Sidebar Popular posts section structure.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$post_type		= isset( $args['post_type'] ) ? $args['post_type'] : '';
$tax_name		= isset( $args['tax_name'] ) ? $args['tax_name'] : '';
$term			= isset( $args['term'] ) ? $args['term'] : '';
$args			= [
	'post_status'   	=> 'publish',
	'posts_per_page'	=> 16,
	'meta_key'			=> 'post_views_count',
	'orderby'			=> ['meta_value_num' => 'DESC']
];

if( $post_type ) $args['post_type'] = $post_type;

if( $tax_name && $term ){
	$args['tax_query'] = [
		[
			'taxonomy'	=> $tax_name,
			'field'		=> 'slug',
			'terms'		=> [$term->slug]
		]
	];
}

$popular_query	= new WP_Query( $args );

if( ! $popular_query->have_posts() ) return;
?>

<section class="sidebar-section white-wrapper">
	<div class="sidebar-section-title underlined">
		<h4 class="sidebar-section-title__text">
			<?php esc_html_e( 'Популярные', 'daddytales' ) ?>
		</h4>
	</div>

	<div class="sidebar-posts">
		<?php
		while( $popular_query->have_posts() ){
			$popular_query->the_post();
			$post_id = get_the_ID();

			if( ! $post_id ) continue;

			get_template_part( 'includes/single/col', 'preview', ['post_id' => $post_id] );
		}
		wp_reset_query();
		?>
	</div>
</section><!-- .sidebar-section -->

