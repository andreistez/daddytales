<?php
/**
 * Single Audio post content.
 *
 * @package WordPress
 * @subpackage daddytales
 */

if( isset( $args['post_id'] ) ) $post_id = $args['post_id'];
else $post_id = get_the_ID();

if( is_singular( 'audio' ) ){
	dt_set_post_views( $post_id );
	?>
	<article class="single-post audio-single post-<?php echo esc_attr( $post_id ) ?>">
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

					<div class="song-download audio-download">
						<a class="button yellow icon" href="#" download>
							<span>
								<?php esc_html_e( 'Скачать сказку', 'daddytales' ) ?>
							</span>
							<i class="fas fa-cloud-download-alt"></i>
						</a>
					</div>
				</div>

				<?php
				$args = [
					'post_id'	=> $post_id,
					'taxonomy'	=> 'audios'
				];
				get_template_part( 'includes/single/single', 'terms', $args );

				if ( comments_open() || get_comments_number() ) comments_template( '', true );
				?>
			</div>
		</div>
	</article><!-- .single-post.audio-single -->
	<?php
}

