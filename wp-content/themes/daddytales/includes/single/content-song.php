<?php
/**
 * Single Song post content.
 *
 * @package WordPress
 * @subpackage daddytales
 */

if( isset( $args['post_id'] ) ) $post_id = $args['post_id'];
else $post_id = get_the_ID();

// If this is single post page.
if( is_singular( 'song' ) ){
	dt_set_post_views( $post_id );
	?>
	<article class="single-post song-single post-<?php echo esc_attr( $post_id ) ?>">
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

					<div class="song-download">
						<a class="button yellow icon" href="#" download>
							<span>
								<?php esc_html_e( 'Скачать песню', 'daddytales' ) ?>
							</span>
							<i class="fas fa-cloud-download-alt"></i>
						</a>
					</div>
				</div>

				<?php
				$args = [
					'post_id'	=> $post_id,
					'taxonomy'	=> 'songs'
				];
				get_template_part( 'includes/single/single', 'terms', $args );

				if ( comments_open() || get_comments_number() ) comments_template( '', true );
				?>
			</div>
		</div>
	</article><!-- .single-post.song-single -->
	<?php
}

