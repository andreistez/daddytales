<?php
if( ! defined( 'FW' ) ) die( 'Forbidden' );
$current_user = wp_get_current_user();
$current_user_login = $current_user->user_login;
?>

<div class="login-wrapper">
	<div class="login-inner">
		<?php
		// If User is already logged in.
		if( is_user_logged_in() ){
			get_template_part( 'includes/authorize/already', 'logged-in', ['text' => false] );
		}	else {	// User is not logged in yet.
			$user_id = isset( $_GET['user'] ) ? ( int )$_GET['user'] : '';
			$key = isset( $_GET['key'] ) ? $_GET['key'] : '';

			// If there are no GET-params in page address.
			if( ! $user_id || ! $key ){
				$text = esc_html__( 'Не переданы параметры для активации аккаунта. Пожалуйста, проверьте ссылку для активации из письма, присланного на указанный при регистрации аккаунта E-mail. Если письма нет во "Входящих", не забудьте проверить папку "Спам".', 'daddytales' );
				get_template_part( 'includes/authorize/already', 'logged-in', ['text' => $text] );
			}	else {
				// Get activation code stored in new User meta on registration.
				$code = get_user_meta( $user_id, 'has_to_be_activated', true );

				// If code & key parameter from URL are equal - success.
				if( $code === $key ) {
					// Delete User meta - don't need it anymore.
					delete_user_meta( $user_id, 'has_to_be_activated' );
					$text = "Активация прошла успешно! Теперь Вы можете <a href=\"/login\">войти</a> в свой аккаунт.";
					get_template_part( 'includes/authorize/already', 'logged-in', ['text' => $text] );
				} else {
					$text = esc_html__( 'Данные активации не верны или Ваш аккаунт уже активирован.', 'daddytales' );
					get_template_part( 'includes/authorize/already', 'logged-in', ['text' => $text] );
				}
			}
		}
		?>
	</div><!-- .login-inner -->
</div><!-- .login-wrapper -->

