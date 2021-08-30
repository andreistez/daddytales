<?php
if( ! defined( 'FW' ) ) die( 'Forbidden' );

if( ! $category_id = (int)$atts['category'][0] ) return;

$posts_count = $atts['posts_count'] ?? 10;
$col_query = new WP_Query(
	[
		'post_type'			=> 'post',
		'post_status'		=> 'publish',
		'cat'				=> $category_id,
		'posts_per_page'	=> $posts_count
	]
);

if( $col_query->have_posts() ){
	?>
	<div class="latest-col">
		<div class="latest-col-title">
			<h4 class="latest-col-title__text underlined yellow">
				<?php printf( esc_html__( '%s', 'daddytales' ), get_cat_name( $category_id ) ) ?>
			</h4>
		</div>

		<div class="latest-col-posts">
			<?php
			while( $col_query->have_posts() ){
				$col_query->the_post();
				get_template_part( 'includes/single/col', 'preview' );
			}
			?>
		</div>

		<div class="latest-col-button">
			<a class="link" href="<?php echo get_term_link( $category_id, 'category' ) ?>">
				<?php esc_html_e( 'Смотреть все', 'daddytales' ) ?>
			</a>
		</div>
	</div><!-- .latest-col -->
	<?php
}
wp_reset_query();

