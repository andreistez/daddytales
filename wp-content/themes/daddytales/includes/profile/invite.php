<?php
/**
 * Profile - invite friend form.
 *
 * @package WordPress
 * @subpackage daddytales
 */
?>

<div class="profile-content-inner invite" data-content="invite">
	<div class="section-title underlined">
		<h3 class="section-title-text">
			<?php esc_html_e( 'Пригласить друга', 'daddytales' ) ?>
		</h3>
	</div>

	<form class="user-invite">
		<fieldset>
			<div class="user-field">
				<span class="user-field-label">
					<?php esc_html_e( 'Полное имя друга', 'daddytales' ) ?>
				</span>
				<div class="user-field-value">
					<input id="new-fullname" name="new-fullname" class="input" type="text" />
				</div>
			</div>

			<div class="user-field">
				<span class="user-field-label">
					<?php esc_html_e( 'E-mail друга', 'daddytales' ) ?>
				</span>
				<div class="user-field-value">
					<input id="new-email" name="new-email" class="input" type="email" />
				</div>
			</div>

			<div class="user-field user-field-button">
				<button class="button black icon" type="submit">
					<span><?php esc_html_e( 'Отправить приглашение', 'daddytales' ) ?></span>
					<i class="fas fa-paper-plane"></i>
				</button>
			</div>

			<?php wp_nonce_field( 'dt_ajax_invite_friend', 'dt_invite_friend_nonce' ) ?>
			<div class="user-field note hidden"></div>
		</fieldset>
	</form>
</div><!-- .profile-content-inner.invite -->

