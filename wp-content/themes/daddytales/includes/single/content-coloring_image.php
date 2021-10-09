<?php
/**
 * Single Coloring Image post content.
 *
 * @package WordPress
 * @subpackage daddytales
 */

if( isset( $args['post_id'] ) ) $post_id = $args['post_id'];
else $post_id = get_the_ID();

if( is_singular( 'coloring_image' ) ){
	dt_set_post_views( $post_id );
	$logged_in_class = is_user_logged_in() ? ' logged' : '';
	?>
	<article class="single-post song-single coloring-single post-<?php echo esc_attr( $post_id ) ?>">
		<div class="cwp-title">
			<h1 class="cwp-title__text">
				<?php
				$post_title = str_replace( ' ', '', get_the_title( $post_id ) );
				printf( esc_html__( '%s', 'daddytales' ), $post_title );
				?>
			</h1>
		</div>

		<div class="fw-container">
			<div class="song-inner coloring-inner">
				<div class="song-content coloring-content white-wrapper">
					<?php the_content() ?>

					<div class="coloring-image">
						<?php the_post_thumbnail( 'medium' ) ?>
					</div>

					<div class="coloring-button<?php echo esc_attr( $logged_in_class ) ?>">
						<?php
						if( is_user_logged_in() ){
							$bytes				= filesize( get_attached_file( get_post_thumbnail_id() ) );
							$thumb_full_weight	= size_format( $bytes );
							?>
							<button class="button black hover-yellow icon download-coloring" data-id="<?php echo esc_attr( $post_id ) ?>">
								<span>
									<?php printf( esc_html__( 'Скачать оригинал (%s)', 'daddytales' ), $thumb_full_weight ) ?>
								</span>
								<i class="fas fa-cloud-download-alt"></i>
							</button>
							<?php
						}	else {
							$upload_dir				= wp_upload_dir();
							$metadata_size			= image_get_intermediate_size(
								get_post_thumbnail_id(),
								'medium'
							);
							$path_inter				= $upload_dir[ 'basedir' ] . '/' . $metadata_size[ 'path' ];
							$bytes					= filesize( $path_inter );
							$thumb_medium_weight	= size_format( $bytes );
							?>
							<button class="button black icon download-coloring" data-id="<?php echo esc_attr( $post_id ) ?>">
								<span>
									<?php printf( esc_html__( 'Скачать низкое качество (%s)', 'daddytales' ), $thumb_medium_weight ) ?>
								</span>
								<i class="fas fa-cloud-download-alt"></i>
							</button>

							<div class="or">
								<?php esc_html_e( 'или', 'daddytales' ) ?>
							</div>

							<a href="<?php echo get_the_permalink( 6706 ) ?>" class="button yellow">
								<?php esc_html_e( 'Войдите и скачайте оригинал', 'daddytales' ) ?>
							</a>
							<?php
						}
						?>
					</div>
				</div>

				<div class="song-terms coloring-terms white-wrapper">
					<h3>
						<?php esc_html_e( 'Рубрики:', 'daddytales' ) ?>
					</h3>

					<?php
					$coloring_terms = get_the_terms( $post_id, 'coloring_images' );
					if( is_array( $coloring_terms ) ){
						?>
						<div class="song-terms-inner">
							<?php
							foreach( $coloring_terms as $coloring_term ){
								?>
								<a class="song-term" href="<?php echo get_term_link( $coloring_term->term_id, 'coloring_images' ) ?>">
									<?php echo esc_html( $coloring_term->name ) ?>
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

