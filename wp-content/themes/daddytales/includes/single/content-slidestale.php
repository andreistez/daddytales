<?php
/**
 * Single Slides Tale post content.
 *
 * @package WordPress
 * @subpackage daddytales
 */

if( isset( $args['post_id'] ) ) $post_id = $args['post_id'];
else $post_id = get_the_ID();

if( is_singular( 'slidestale' ) ){
	dt_set_post_views( $post_id );
	?>
	<article class="single-post song-single slidestale-single post-<?php echo esc_attr( $post_id ) ?>">
		<div class="cwp-title">
			<h1 class="cwp-title__text">
				<?php
				$post_title = str_replace( ' ', '', get_the_title( $post_id ) );
				printf( esc_html__( '%s', 'daddytales' ), $post_title );
				?>
			</h1>
		</div>

		<div class="fw-container">
			<div class="song-inner">
				<div class="song-content white-wrapper">
					<?php the_content() ?>
				</div>

				<?php
				get_template_part( 'includes/single/slidestale/slider', null, ['post_id' => $post_id] );

				$args = [
					'post_id'	=> $post_id,
					'taxonomy'	=> 'slidestales'
				];
				get_template_part( 'includes/single/single', 'terms', $args );

				if ( comments_open() || get_comments_number() ) comments_template( '', true );
				?>
			</div>
		</div>
	</article><!-- .single-post.slidestale-single -->
	<?php
}

