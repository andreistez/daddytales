<?php
/**
 * Footer CTA.
 *
 * @see Appearance -> Customize -> Footer Settings -> Footer CTA
 *
 * @package WordPress
 * @subpackage industrialcyber
 */

$cta_alt_view = fw_get_db_customizer_option( 'footer_cta_alt_view' );
$cta_text_size = fw_get_db_customizer_option( 'footer_cta_text_size' );
$cta_title = fw_get_db_customizer_option( 'footer_cta_title' );
$cta_desc = fw_get_db_customizer_option( 'footer_cta_desc' );
$cta_button = [];
$cta_button['text'] = fw_get_db_customizer_option( 'footer_cta_button_text' ) ?? '';
$cta_button['url'] = fw_get_db_customizer_option( 'footer_cta_button_url' ) ?? '#';
$cta_button['target'] = fw_get_db_customizer_option( 'footer_cta_button_target' ) ? '_blank' : '_self';

if( $cta_title && $cta_desc ){
	?>
	<section class="fw-main-row footer-cta">
		<div class="fw-container">
			<div class="cwp-cta <?php echo esc_attr( $cta_text_size ) ?>">
				<?php
				// If User is not logged in or alt view = default view.
				if( ! is_user_logged_in() || ( is_user_logged_in() && $cta_alt_view === 'leave' ) ){
					?>
					<div class="cwp-cta-text">
						<h2 class="cwp-cta-text__title">
							<?php printf( esc_html__( '%s', 'daddytales' ), $cta_title ) ?>
						</h2>
						<p class="cwp-cta-text__desc">
							<?php printf( esc_html__( '%s', 'daddytales' ), $cta_desc ) ?>
						</p>
					</div><!-- .cwp-cta-text -->

					<?php
					if( ! empty( $cta_button ) ){
						?>
						<div class="cwp-cta-button">
							<a href="<?php echo esc_url( $cta_button['url'] ) ?>" class="button black lg cwp-cta-button__link" target="<?php echo esc_attr( $cta_button['target'] ) ?>">
								<?php printf( esc_html__( '%s', 'daddytales' ), $cta_button['text'] ) ?>
							</a>
						</div>
						<?php
					}
				}	else {
					$current_user = wp_get_current_user();
					$current_user_login = $current_user->user_login;
					?>
					<div class="cwp-cta-text">
						<h2 class="cwp-cta-text__title">
							<?php printf( esc_html__( 'Привет, %s!', 'daddytales' ), $current_user_login ) ?>
						</h2>
						<p class="cwp-cta-text__desc">
							<?php esc_html_e( 'Спасибо, что ты с нами.)', 'daddytales' ) ?>
						</p>
					</div>

					<div class="cwp-cta-button">
						<a href="<?php echo get_the_permalink( 6736 ) ?>" class="button black lg cwp-cta-button__link">
							<?php esc_html_e( 'Личный кабинет', 'daddytales' ) ?>
						</a>
					</div>
					<?php
				}
				?>
			</div><!-- .cwp-cta -->
		</div>
	</section>
	<?php
}

