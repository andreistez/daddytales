<?php
/**
 * Profile change password form.
 *
 * @package WordPress
 * @subpackage daddytales
 */
?>

<form id="user-pass" class="user-pass">
	<fieldset>
		<div class="user-field">
			<span class="user-field-label">
				<?php esc_html_e( 'Пароль', 'daddytales' ) ?>
			</span>
			<div class="user-field-value">
				<input id="pass" name="pass" class="input" type="password" />
			</div>
		</div>

		<div class="user-field">
			<span class="user-field-label">
				<?php esc_html_e( 'Новый пароль', 'daddytales' ) ?>
			</span>
			<div class="user-field-value">
				<input id="pass-new" name="pass-new" class="input" type="password" />
			</div>
		</div>

		<div class="user-field">
			<span class="user-field-label">
				<?php esc_html_e( 'Подтверждение нового пароля', 'daddytales' ) ?>
			</span>
			<div class="user-field-value">
				<input id="pass-new-confirm" name="pass-new-confirm" class="input" type="password" />
			</div>
		</div>

		<div class="user-field user-field-button">
			<button class="button black icon" type="submit">
				<span><?php esc_html_e( 'Измененить пароль', 'daddytales' ) ?></span>
				<i class="fas fa-key"></i>
			</button>
		</div>

		<?php wp_nonce_field( 'dt_ajax_change_password', 'dt_change_password_nonce' ) ?>
		<div class="user-field note hidden"></div>
	</fieldset>
</form>

