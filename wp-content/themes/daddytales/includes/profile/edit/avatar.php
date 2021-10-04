<?php
/**
 * Profile avatar edit form.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$user_id			= $args['user_id'];
$user_avatar_url	= dt_get_user_avatar( $user_id );
?>

<form id="user-avatar" class="user-avatar" enctype="multipart/form-data">
	<fieldset>
		<div class="user-field avatar">
			<span class="user-field-label">
				<?php esc_html_e( 'Изображение профиля', 'daddytales' ) ?>
			</span>
			<div class="user-field-value">
				<img src="<?php echo esc_url( $user_avatar_url ) ?>" alt="" />
				<input id="avatar" name="avatar" type="file" accept="image/png, image/jpeg" />
			</div>
		</div>

		<div class="user-field user-field-button">
			<button class="button black icon" type="submit">
				<span><?php esc_html_e( 'Сохранить изображение', 'daddytales' ) ?></span>
				<i class="fas fa-user-circle"></i>
			</button>
		</div>

		<?php wp_nonce_field( 'dt_ajax_change_profile_avatar', 'dt_change_profile_avatar_nonce' ) ?>
		<div class="user-field note hidden"></div>
	</fieldset>
</form>

