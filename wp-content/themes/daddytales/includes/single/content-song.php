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
				</div>

				<div class="song-terms white-wrapper">
					<h3>
						<?php esc_html_e( 'Рубрики:', 'daddytales' ) ?>
					</h3>

					<?php
					$song_terms = get_the_terms( $post_id, 'songs' );
					if( is_array( $song_terms ) ){
						?>
						<div class="song-terms-inner">
							<?php
							foreach( $song_terms as $song_term ){
								?>
								<a class="song-term" href="<?php echo get_term_link( $song_term->term_id, 'songs' ) ?>">
									<?php echo esc_html( $song_term->name ) ?>
								</a>
								<?php
							}
							?>
						</div>
						<?php
					}
					?>
				</div>

				<?php
				// If comments are open or we have at least one comment.
				if ( comments_open() || get_comments_number() ) comments_template( '', true );
				?>
			</div>
		</div>
	</article><!-- .single-post.single-song -->
	<?php
}

