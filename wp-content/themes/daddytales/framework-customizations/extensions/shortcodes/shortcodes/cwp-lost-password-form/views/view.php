<?php if( ! defined( 'FW' ) ) die( 'Forbidden' ) ?>

<div class="login-wrapper">
	<div class="login-inner">
		<?php
		// If user is NOT logged in - show form.
		if( ! is_user_logged_in() ){
			?>
			<div class="login-content">
				<form class="dt-form dt-lostpass">
					<fieldset>
						<div class="dt-form-field">
							<label for="login-name">
								<?php esc_html_e( 'Логин или Email', 'daddytales' ) ?>
								<span class="dt-form-required">*</span>
							</label>
							<input id="login-name" name="login-name" class="input" type="text" />
						</div>

						<div class="dt-form-field dt-form-field_button">
							<button class="button black icon" type="submit">
								<?php esc_html_e( 'Получить новый пароль', 'daddytales' ) ?>
								<i class="fas fa-key"></i>
							</button>
						</div>

						<?php wp_nonce_field( 'dt_ajax_lost_password', 'dt_lostpass_nonce' ); ?>
						<div class="dt-form-field note hidden"></div>
					</fieldset>

					<div class="dt-form-links">
						<div class="dt-form-link">
							<a href="<?php echo home_url( '/' ) ?>">
								<?php esc_html_e( 'На Главную', 'daddytales' ) ?>
							</a>
						</div>
						<div class="dt-form-link">
							<a href="<?php echo get_the_permalink( 6706 ) ?>">
								<?php esc_html_e( 'Вход', 'daddytales' ) ?>
							</a>
						</div>
						<div class="dt-form-link">
							<a href="<?php echo get_the_permalink( 6723) ?>">
								<?php esc_html_e( 'Регистрация', 'daddytales' ) ?>
							</a>
						</div>
					</div>
				</form><!-- .dt-form dt-lostpass -->
			</div><!-- .login-content -->
			<?php
		}	else {
			get_template_part( 'includes/authorize/already', 'logged-in', ['text' => false] );
		}
		?>
	</div><!-- .login-inner -->
</div><!-- .login-wrapper -->

