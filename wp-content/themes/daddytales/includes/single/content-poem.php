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

				<div class="song-terms poem-terms white-wrapper">
					<h3>
						<?php esc_html_e( 'Рубрики:', 'daddytales' ) ?>
					</h3>

					<?php
					$poem_terms = get_the_terms( $post_id, 'poems' );
					if( is_array( $poem_terms ) ){
						?>
						<div class="song-terms-inner">
							<?php
							foreach( $poem_terms as $poem_term ){
								?>
								<a class="song-term" href="<?php echo get_term_link( $poem_term->term_id, 'poems' ) ?>">
									<?php echo esc_html( $poem_term->name ) ?>
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
	</article><!-- .single-post.single-poem -->
	<?php
}

