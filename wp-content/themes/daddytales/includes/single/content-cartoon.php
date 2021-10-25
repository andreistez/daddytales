<?php
/**
 * Single Cartoon post content.
 *
 * @see Cartoon post -> Cartoon additional fields.
 *
 * @package WordPress
 * @subpackage daddytales
 */

if( isset( $args['post_id'] ) ) $post_id = $args['post_id'];
else $post_id = get_the_ID();

// If this is single Cartoon post.
if( is_singular( 'cartoon' ) ){
	// Post views count.
	dt_set_post_views( $post_id );
	// Get cartoon ID on kinopoisk.ru portal from meta field.
	$kinopoisk_id = ( int ) fw_get_db_post_option( $post_id, 'kinopoisk_id' );

	if( $kinopoisk_id ){
		// Update all necessary data.
		dt_get_cartoon_info( $post_id, $kinopoisk_id );
		dt_get_cartoon_frames( $post_id, $kinopoisk_id );

		// Get all data from post fields.
		$original_name	= fw_get_db_post_option( $post_id, 'original_name' );
		$rating_kp		= fw_get_db_post_option( $post_id, 'kp_rating' );
		$kp_voices		= fw_get_db_post_option( $post_id, 'kp_voices' );
		$rating_imdb	= fw_get_db_post_option( $post_id, 'imdb_rating' );
		$imdb_voices	= fw_get_db_post_option( $post_id, 'imdb_voices' );
		$year			= fw_get_db_post_option( $post_id, 'year' );
		$length			= fw_get_db_post_option( $post_id, 'length' );
		$description	= fw_get_db_post_option( $post_id, 'description' );
		$age_limit		= fw_get_db_post_option( $post_id, 'age_limit' );
		$countries		= fw_get_db_post_option( $post_id, 'countries' );
		$genres			= fw_get_db_post_option( $post_id, 'genres' );
	}
	?>
	<article class="cartoon-single post-<?php echo esc_attr( $post_id ) ?>">
		<div class="cwp-title">
			<h1 class="cwp-title__text">
				<?php
				$post_title = str_replace( ' ', '', get_the_title( $post_id ) );
				printf( esc_html__( '%s', 'daddytales' ), $post_title );
				?>
			</h1>
		</div>

		<div class="fw-container">
			<div class="cartoon-inner">
				<?php
				if( $kinopoisk_id ){
					?>
					<div class="cartoon-info white-wrapper">
						<?php
						if( has_post_thumbnail( $post_id ) ){
							$full_thumb = get_the_post_thumbnail_url( $post_id, 'full' );
							?>
							<div class="cartoon-info-thumb" data-full="<?php echo esc_url( $full_thumb ) ?>">
								<?php echo get_the_post_thumbnail( $post_id, 'full' ) ?>
							</div>
							<?php
						}
						?>

						<div class="cartoon-fields">
							<?php
							if( $year ){
								?>
								<p class="cartoon-field">
									<span class="cartoon-field__label">
										<?php esc_html_e( 'Год:', 'daddytales' ) ?>
									</span>
									<span class="cartoon-field__value">
										<?php echo esc_html( $year ) ?>
									</span>
								</p>
								<?php
							}

							if( $genres ){
								?>
								<p class="cartoon-field">
									<span class="cartoon-field__label">
										<?php esc_html_e( 'Жанр:', 'daddytales' ) ?>
									</span>
									<span class="cartoon-field__value">
										<?php echo esc_html( $genres ) ?>
									</span>
								</p>
								<?php
							}

							if( $countries ){
								?>
								<p class="cartoon-field">
									<span class="cartoon-field__label">
										<?php esc_html_e( 'Страна:', 'daddytales' ) ?>
									</span>
									<span class="cartoon-field__value">
										<?php echo esc_html( $countries ) ?>
									</span>
								</p>
								<?php
							}

							if( $length ){
								?>
								<p class="cartoon-field">
									<span class="cartoon-field__label">
										<?php esc_html_e( 'Продолжительность:', 'daddytales' ) ?>
									</span>
									<span class="cartoon-field__value">
										<?php printf( esc_html__( '%d мин.', 'daddytales' ), $length ) ?>
									</span>
								</p>
								<?php
							}

							if( $original_name ){
								?>
								<p class="cartoon-field">
									<span class="cartoon-field__label">
										<?php esc_html_e( 'Оригинальное название:', 'daddytales' ) ?>
									</span>
									<span class="cartoon-field__value">
										<?php echo esc_html( $original_name ) ?>
									</span>
								</p>
								<?php
							}

							if( $rating_kp && ( $kp_voices || $kp_voices == 0 ) ){
								?>
								<p class="cartoon-field">
									<span class="cartoon-field__label">
										<?php esc_html_e( 'Рейтинг kinopoisk.ru:', 'daddytales' ) ?>
									</span>
									<span class="cartoon-field__value">
										<span class="cartoon-field__rating">
											<?php echo esc_html( number_format( $rating_kp, 2, '.', '' ) ) ?>
										</span>
										<?php printf( esc_html( '/10 (%d оценок)' ), $kp_voices ) ?>
									</span>
								</p>
								<?php
							}

							if( $rating_imdb && ( $imdb_voices || $imdb_voices == 0 ) ){
								?>
								<p class="cartoon-field">
									<span class="cartoon-field__label">
										<?php esc_html_e( 'Рейтинг IMDB:', 'daddytales' ) ?>
									</span>
									<span class="cartoon-field__value">
										<span class="cartoon-field__rating">
											<?php echo esc_html( number_format( $rating_imdb, 2, '.', '' ) ) ?>
										</span>
										<?php printf( esc_html( '/10 (%d оценок)' ), $imdb_voices ) ?>
									</span>
								</p>
								<?php
							}

							if( $age_limit || $age_limit == 0 ){
								?>
								<p class="cartoon-field cartoon-field_age">
									<span class="cartoon-field__label">
										<?php esc_html_e( 'Возрастное ограничение:', 'daddytales' ) ?>
									</span>
									<span class="cartoon-field__value">
										<?php echo esc_html( $age_limit ), ' +' ?>
									</span>
								</p>
								<?php
							}

							if( $description ){
								?>
								<p class="cartoon-field cartoon-field_desc">
									<span class="cartoon-field__label">
										<?php esc_html_e( 'Описание:', 'daddytales' ) ?>
									</span>
									<span class="cartoon-field__value">
										<?php echo esc_html( $description ) ?>
									</span>
								</p>
								<?php
							}
							?>
						</div>
					</div><!-- .cartoon-info -->
					<?php
				}
				?>

				<div class="cartoon-desc white-wrapper">
					<?php the_content() ?>
				</div>

				<?php
				// Frames & player.
				if( $kinopoisk_id ){
					get_template_part( 'includes/single/cartoon/player', null, [
						'post_id'	=> $post_id,
						'kp_id'		=> $kinopoisk_id
					] );
				}

				get_template_part( 'includes/common/related', 'articles' );

				// If comments are open or we have at least one comment.
				if ( comments_open() || get_comments_number() ) comments_template( '', true );
				?>
			</div><!-- .cartoon-inner -->
		</div><!-- .fw-container -->
	</article><!-- .single-cartoon -->
	<?php
}

