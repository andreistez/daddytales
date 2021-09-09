<?php
/**
 * Profile content part.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$user = $args['user'];
$user_id = $user->ID;
$user_avatar_url = get_avatar_url( $user_id );
$first_name = $user->first_name ? ' value="' . esc_attr( $user->first_name ) . '"' : '';
$last_name = $user->last_name ? ' value="' . esc_attr( $user->last_name ) . '"' : '';;

$user_data = get_userdata( $user_id );
$website = $user_data->user_url ? ' value="' . esc_url( $user_data->user_url ) . '"' : '';

$user_meta = get_user_meta( $user_id );
$biography = $user_meta['description'][0] ? $user_meta['description'][0] : '';
?>

<div class="profile-content-inner user-edit" data-content="edit">
	<div class="section-title underlined">
		<h3 class="section-title-text">
			<?php esc_html_e( 'Редактировать личную информацию', 'daddytales' ) ?>
		</h3>
	</div>

	<form id="user-fields" class="user-fields" enctype="multipart/form-data">
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

			<div class="user-field">
				<span class="user-field-label">
					<?php esc_html_e( 'Имя', 'daddytales' ) ?>
				</span>
				<div class="user-field-value">
					<input id="first-name" name="first-name" class="input" type="text"<?php echo $first_name ?> />
				</div>
			</div>

			<div class="user-field">
				<span class="user-field-label">
					<?php esc_html_e( 'Фамилия', 'daddytales' ) ?>
				</span>
				<div class="user-field-value">
					<input id="last-name" name="last-name" class="input" type="text"<?php echo $last_name ?> />
				</div>
			</div>

			<div class="user-field">
				<span class="user-field-label">
					<?php esc_html_e( 'Веб-сайт', 'daddytales' ) ?>
				</span>
				<div class="user-field-value">
					<input id="website" name="website" class="input" type="url"<?php echo $website ?> />
				</div>
			</div>

			<div class="user-field">
				<span class="user-field-label">
					<?php esc_html_e( 'О себе', 'daddytales' ) ?>
				</span>
				<div class="user-field-value">
					<textarea id="biography" name="biography" class="textarea"><?php echo $biography ?></textarea>
				</div>
			</div>

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
					<span><?php esc_html_e( 'Сохранить изменения', 'daddytales' ) ?></span>
					<i class="fas fa-user-check"></i>
				</button>
			</div>

			<?php wp_nonce_field( 'dt_ajax_save_profile_changes', 'dt_save_profile_changes_nonce' ) ?>
			<div class="user-field note hidden"></div>
		</fieldset>
	</form><!-- .user-fields -->
</div><!-- .profile-content-inner.user-edit -->

