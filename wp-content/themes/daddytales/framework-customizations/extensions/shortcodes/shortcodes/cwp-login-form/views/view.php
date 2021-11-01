<?php if( ! defined( 'FW' ) ) die( 'Forbidden' ) ?>

<div class="login-wrapper">
	<div class="login-inner">
		<?php
		// If user is NOT logged in - show form.
		if( ! is_user_logged_in() ){
			?>
			<div class="login-content">
				<form class="dt-form dt-login">
					<fieldset>
						<div class="dt-form-field">
							<label for="login-name">
								<?php esc_html_e( 'Логин или Email', 'daddytales' ) ?>
								<span class="dt-form-required">*</span>
							</label>
							<input id="login-name" name="login-name" class="input" type="text" />
						</div>

						<div class="dt-form-field">
							<label for="login-pass">
								<?php esc_html_e( 'Пароль', 'daddytales' ) ?>
								<span class="dt-form-required">*</span>
							</label>
							<input id="login-pass" name="login-pass" class="input" type="password" />
						</div>

						<div class="dt-form-field dt-form-field_checkbox">
							<input id="rememberme" name="rememberme" class="checkbox" type="checkbox" />
							<label for="rememberme">
								<?php esc_html_e( 'Запомнить меня', 'daddytales' ) ?>
							</label>
						</div>

						<div class="dt-form-field dt-form-field_button">
							<!-- Google reCAPTCHA v2 -->
							<script src="https://www.google.com/recaptcha/api.js" async defer></script>
							<div class="g-recaptcha" data-sitekey="6LdALS0UAAAAAF8PmMhEgCd_MvDouhfginJgPCgA"></div>
							<!-- /Google reCAPTCHA v2 -->

							<button class="button black icon" type="submit">
								<?php esc_html_e( 'Войти', 'daddytales' ) ?>
								<i class="fas fa-sign-in-alt"></i>
							</button>
						</div>

						<?php wp_nonce_field( 'dt_ajax_login', 'dt_login_nonce' ) ?>
						<div class="dt-form-field note hidden"></div>
					</fieldset>

					<div class="dt-form-links">
						<div class="dt-form-link">
							<a href="<?php echo home_url( '/' ) ?>">
								<?php esc_html_e( 'На Главную', 'daddytales' ) ?>
							</a>
						</div>
						<div class="dt-form-link">
							<a href="<?php echo get_the_permalink( 6723 ) ?>">
								<?php esc_html_e( 'Регистрация', 'daddytales' ) ?>
							</a>
						</div>
						<div class="dt-form-link">
							<a href="<?php echo get_the_permalink( 6720 ) ?>">
								<?php esc_html_e( 'Забыли пароль?', 'daddytales' ) ?>
							</a>
						</div>
					</div>
				</form><!-- .dt-form.dt-login -->
			</div><!-- .login-content -->
			<?php
		}	else {
			get_template_part( 'includes/authorize/already', 'logged-in', ['text' => false] );
		}
		?>
	</div><!-- .login-inner -->
</div><!-- .login-wrapper -->

