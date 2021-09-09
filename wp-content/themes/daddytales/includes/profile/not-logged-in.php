<?php
/**
 * Profile - User is not logged in.
 *
 * @package WordPress
 * @subpackage daddytales
 */
?>

<div class="profile-not-logged">
	<div class="fw-container">
		<div class="profile-not-logged-inner">
			<h2><?php esc_html_e( 'Здравствуй, странник!', 'daddytales' ) ?></h2>
			<p>
				<?php esc_html_e( 'К большому сожалению, ты не должен находиться здесь.', 'daddytales' ) ?>
			</p>
			<p>
				<?php esc_html_e( 'Будь так добр, войди в свой личный аккаунт или зарегистрируй новый.', 'daddytales' ) ?>
			</p>

			<div class="not-logged-in-buttons">
				<a class="button black icon" href="<?php echo home_url( '/' ) ?>">
					<span><?php esc_html_e( 'На Главную', 'daddytales' ) ?></span>
                    <i class="fas fa-long-arrow-alt-left"></i>
				</a>

				<a class="button black icon" href="<?php echo get_the_permalink( 7010 ) ?>">
					<span><?php esc_html_e( 'Вход', 'daddytales' ) ?></span>
                    <i class="fas fa-sign-in-alt"></i>
				</a>

				<a class="button black icon" href="<?php echo get_the_permalink( 7013 ) ?>">
					<span><?php esc_html_e( 'Регистрация', 'daddytales' ) ?></span>
                    <i class="fas fa-user-alt"></i>
				</a>
			</div>
		</div><!-- .profile-not-logged-inner -->
	</div><!-- .fw-container -->
</div><!-- .profile-not-logged -->

