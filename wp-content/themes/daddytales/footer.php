<?php
/**
 * Theme footer.
 *
 * @see Appearance -> Customize -> Footer Settings.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$copyright = fw_get_db_customizer_option( 'footer_copyrights' );

/**
 * Header settings.
 *
 * @see Appearance -> Customize -> Header Settings.
 */
$header_logo = fw_get_db_customizer_option( 'header_logo' );
?>

			<?php
			// Hide header on Login/Registration/Lostpass/Activation pages.
			if(
				! is_page_template( 'page-template-login.php' )
				&& ! is_page_template( 'page-template-lostpass.php' )
				&& ! is_page_template( 'page-template-register.php' )
				&& ! is_page_template( 'page-template-activate.php' )
			){
				get_template_part( 'includes/common/footer/footer', 'cta' );
				?>

				<footer class="footer">
					<div class="footer-top">
						<div class="fw-container">
							<div class="fw-row">
								<div class="fw-col-xs-12">
									<div class="footer-top-inner">
										<?php
										if( $header_logo ){
											?>
											<div class="header-logo footer-logo">
												<a href="<?php echo home_url( '/' ) ?>" title="<?php esc_attr_e( 'На Главную', 'daddytales' ) ?>">
													<?php echo wp_get_attachment_image( $header_logo['attachment_id'] ) ?>
												</a>
											</div>
											<?php
										}

										wp_nav_menu(
											[
												'theme_location'	=> 'footer_menu',
												'container'			=> 'nav',
												'container_class'	=> 'footer-nav',
												'container_id'		=> 'footer-nav'
											]
										)
										?>

										<div class="footer-contacts">
											<p>
												<?php esc_html_e( 'Привет! Нашли ошибку или дубликат? Есть предложения или замечания по развитию ресурса? Смело заполняйте форму обратной связи и отправляйте нам. Мы читаем каждое письмо.', 'daddytales' ) ?>
											</p>
											<button class="button yellow icon footer-contacts__send">
												<?php esc_html_e( 'Написать', 'daddytales' ) ?>
												<i class="fas fa-paper-plane"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div><!-- .footer-top -->

					<div class="footer-bottom">
						<?php
						if( $copyright ){
							echo $copyright;
						}
						?>
					</div>
				</footer><!-- .footer -->
				<?php
			}

			wp_footer();
			?>
		</div><!-- .wrapper -->

		<?php get_template_part( 'includes/common/modal' ) ?>
    </body>
</html>

