<?php
if( ! defined( 'FW' ) ) die( 'Forbidden' );

$taxonomy = $atts['taxonomy']['choice'];

switch( $taxonomy ){
	case 'category':
		$post_type	= 'post';
		$term_id	= ( int ) $atts['taxonomy']['category']['terms'][0];
		break;

	case 'songs':
		$post_type	= 'song';
		$term_id	= ( int ) $atts['taxonomy']['songs']['terms'][0];
		break;
}

$term			= get_term_by( 'id', $term_id, $taxonomy );
$term_name		= $term->name;
$posts_count	= $atts['posts_count'] ?? 12;
$col_query		= new WP_Query(
	[
		'post_type'			=> $post_type,
		'post_status'		=> 'publish',
		'tax_query'			=> [
			[
				'taxonomy'	=> $taxonomy,
				'field'		=> 'id',
				'terms'		=> [$term_id]
			]
		],
		'posts_per_page'	=> $posts_count
	]
);

if( $col_query->have_posts() ){
	?>
	<div class="latest-col">
		<div class="latest-col-title">
			<h4 class="latest-col-title__text underlined yellow">
				<?php printf( esc_html__( '%s', 'daddytales' ), $term_name ) ?>
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
			<a class="link" href="<?php echo get_term_link( $term_id, $taxonomy ) ?>">
				<?php esc_html_e( 'Смотреть все', 'daddytales' ) ?>
			</a>
		</div>
	</div><!-- .latest-col -->
	<?php
}
wp_reset_query();

