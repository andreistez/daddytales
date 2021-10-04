<?php
/**
 * Profile common fields edit form.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$user		= $args['user'];
$user_id	= $user->ID;
$first_name	= $user->first_name ? ' value="' . esc_attr( $user->first_name ) . '"' : '';
$last_name	= $user->last_name ? ' value="' . esc_attr( $user->last_name ) . '"' : '';;

$user_data	= get_userdata( $user_id );
$website	= $user_data->user_url ? ' value="' . esc_url( $user_data->user_url ) . '"' : '';

$user_meta	= get_user_meta( $user_id );
$biography	= $user_meta['description'][0] ? $user_meta['description'][0] : '';
?>

<form id="user-common" class="user-common">
	<fieldset>
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

		<div class="user-field user-field-button">
			<button class="button black icon" type="submit">
				<span><?php esc_html_e( 'Сохранить изменения', 'daddytales' ) ?></span>
				<i class="fas fa-user-check"></i>
			</button>
		</div>

		<?php wp_nonce_field( 'dt_ajax_save_common_fields', 'dt_save_common_fields_nonce' ) ?>
		<div class="user-field note hidden"></div>
	</fieldset>
</form>

