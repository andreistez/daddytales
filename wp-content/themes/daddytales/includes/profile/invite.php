<?php
/**
 * Profile - invite friend form.
 *
 * @package WordPress
 * @subpackage daddytales
 */

/** @var array $args */
$user = $args['user'];
$user_id = $user->ID;
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
	</form><!-- .user-invite -->

	<?php
	$users = get_users( [
		'meta_key'		=> 'invited_by',
		'meta_value'	=> $user_id,
		'meta_compare'	=> '=',
		'number'		=> '',
		'fields'		=> 'all_with_meta'
	] );

	if( $users ){
		?>
		<div class="section-title underlined">
			<h3 class="section-title-text">
				<?php esc_html_e( 'Пользователи, пришедшие по Вашей ссылке', 'daddytales' ) ?>
			</h3>
		</div>

		<div class="invite-list">
			<?php
			$iter = 1;
			foreach( $users as $key => $invited_user ){
				$args = [
					'iter'	=> $iter,
					'user'	=> $invited_user
				];
				get_template_part( 'includes/profile/invited', 'user', $args );
				$iter++;
			}
			?>
		</div><!-- .invite-list -->
		<?php
	}	else {
		?>
		<p class="invite-list-empty">
			<?php esc_html_e( 'Здесь будут отображаться все Пользователи, прошедшие регистрацию на сайте по Вашей ссылке.', 'daddytales' ) ?>
		</p>
		<?php
	}
	?>
</div><!-- .profile-content-inner.invite -->

