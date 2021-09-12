<?php
/**
 * Page not found template.
 *
 * @see Appearance -> Customize -> 404 Settings.
 *
 * @package WordPress
 * @subpackage daddytales
 */

get_header();

$image_404  = fw_get_db_customizer_option( 'image_404' );
$title_404  = fw_get_db_customizer_option( 'title_404' );
$desc_404   = fw_get_db_customizer_option( 'desc_404' );
?>

<main class="main">
	<section class="error404-section">
		<div class="fw-container">
			<div class="error404-inner">
				<?php
				if( $title_404 || $desc_404 ){
					?>
					<div class="error404-text">
						<?php
						if( $title_404 ){
							?>
							<h2 class="error404-text__title">
								<?php printf( esc_html__( '%s', 'daddytales' ), $title_404 ) ?>
							</h2>
							<?php
						}

						if( $desc_404 ){
							?>
							<div class="error404-text__desc">
								<?php printf( __( '%s', 'daddytales' ), $desc_404 ) ?>
							</div>
							<?php
						}
						?>

						<img class="error404-text__arrow error404-text__arrow_top" src="<?php echo get_template_directory_uri() ?>/static/img/arrow-min.png" alt="<?php esc_attr_e( 'Навигация в шапке сайта', 'daddytales' ) ?>" />
						<img class="error404-text__arrow error404-text__arrow_bottom" src="<?php echo get_template_directory_uri() ?>/static/img/arrow-min.png" alt="<?php esc_attr_e( 'Навигация в подвале сайта', 'daddytales' ) ?>" />
					</div>
					<?php
				}

				if( $image_404 ){
					?>
					<div class="error404-image">
						<?php echo wp_get_attachment_image( $image_404['attachment_id'], 'full' ) ?>
					</div>
					<?php
				}
				?>
			</div><!-- .error404-inner -->
		</div><!-- .fw-container -->
	</section><!-- .error404-section -->
</main>

<?php
get_footer();
