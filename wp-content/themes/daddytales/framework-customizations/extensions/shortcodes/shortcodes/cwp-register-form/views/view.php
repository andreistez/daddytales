<?php if( ! defined( 'FW' ) ) die( 'Forbidden' ) ?>

<div class="login-wrapper">
	<div class="login-inner">
		<?php
		// If user is NOT logged in - show form.
		if( ! is_user_logged_in() ){
			// Check if new User is invited by already exisiting website member.
			if( isset( $_GET['invited_by'] ) ){
				$invited_by = (int) dt_clean_value( $_GET['invited_by'] );

				// Check if website User with this ID already exists.
				if( $invited_by && is_int( $invited_by ) ){
					// Then store it in session.
					if( $user = get_userdata( $invited_by ) ) $_SESSION['invited_by'] = $invited_by;
				}
			}
			?>
			<div class="login-content">
				<form class="dt-form dt-register">
					<fieldset>
						<div class="dt-form-field">
							<label for="first-name">
								<?php esc_html_e( 'Имя', 'daddytales' ) ?>
								<span class="dt-form-required">*</span>
							</label>
							<input id="first-name" name="first-name" class="input" type="text" />
						</div>

						<div class="dt-form-field">
							<label for="last-name">
								<?php esc_html_e( 'Фамилия', 'daddytales' ) ?>
							</label>
							<input id="last-name" name="last-name" class="input" type="text" />
						</div>

						<div class="dt-form-field">
							<label for="email">
								<?php esc_html_e( 'Email', 'daddytales' ) ?>
								<span class="dt-form-required">*</span>
							</label>
							<input id="email" name="email" class="input" type="email" />
						</div>

						<div class="dt-form-field">
							<label for="login">
								<?php esc_html_e( 'Логин', 'daddytales' ) ?>
								<span class="dt-form-required">*</span>
							</label>
							<input id="login" name="login" class="input" type="text" />
						</div>

						<div class="dt-form-field">
							<label for="pass">
								<?php esc_html_e( 'Пароль', 'daddytales' ) ?>
								<span class="dt-form-required">*</span>
							</label>
							<input id="pass" name="pass" class="input" type="password" />
						</div>

						<div class="dt-form-field">
							<label for="pass-confirm">
								<?php esc_html_e( 'Подтверждение пароля', 'daddytales' ) ?>
								<span class="dt-form-required">*</span>
							</label>
							<input id="pass-confirm" name="pass-confirm" class="input" type="password" />
						</div>

						<div class="dt-form-field dt-form-field_button">
							<!-- Google reCAPTCHA v2 -->
							<script src="https://www.google.com/recaptcha/api.js" async defer></script>
							<div class="g-recaptcha" data-sitekey="6LdALS0UAAAAAF8PmMhEgCd_MvDouhfginJgPCgA"></div>
							<!-- /Google reCAPTCHA v2 -->

							<button class="button black icon" type="submit">
								<?php esc_html_e( 'Зарегистрироваться!', 'daddytales' ) ?>
								<i class="fas fa-user-check"></i>
							</button>
						</div>

						<?php wp_nonce_field( 'dt_ajax_register', 'dt_register_nonce' ) ?>
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
							<a href="<?php echo get_the_permalink( 6720 ) ?>">
								<?php esc_html_e( 'Забыли пароль?', 'daddytales' ) ?>
							</a>
						</div>
					</div>
				</form><!-- .dt-form.dt-register -->
			</div><!-- .login-content -->
			<?php
		}	else {
			get_template_part( 'includes/authorize/already', 'logged-in', ['text' => false] );
		}
		?>
	</div><!-- .login-inner -->
</div><!-- .login-wrapper -->

