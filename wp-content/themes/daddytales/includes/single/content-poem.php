<?php
/**
 * Single Poem post content.
 *
 * @package WordPress
 * @subpackage daddytales
 */

if( isset( $args['post_id'] ) ) $post_id = $args['post_id'];
else $post_id = get_the_ID();

// If this is single post page.
if( is_singular( 'poem' ) ){
	dt_set_post_views( $post_id );
	?>
	<article class="single-post song-single poem-single post-<?php echo esc_attr( $post_id ) ?>">
		<div class="cwp-title">
			<h1 class="cwp-title__text">
				<?php
				$post_title = str_replace( ' ', '', get_the_title( $post_id ) );
				printf( esc_html__( '%s', 'daddytales' ), $post_title );
				?>
			</h1>
		</div>

		<div class="fw-container">
			<div class="song-inner poem-inner">
				<div class="song-content poem-content white-wrapper">
					<?php the_content() ?>
				</div>

				<?php
				$args = [
					'post_id'	=> $post_id,
					'taxonomy'	=> 'poems'
				];
				get_template_part( 'includes/single/single', 'terms', $args );

				get_template_part( 'includes/common/related', 'articles' );

				if ( comments_open() || get_comments_number() ) comments_template( '', true );
				?>
			</div>
		</div>
	</article><!-- .single-post.poem-single -->
	<?php
}

