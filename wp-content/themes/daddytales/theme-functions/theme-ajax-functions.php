<?php
/**
 * AJAX login with redirect.
 */
add_action( 'wp_ajax_nopriv_dt_ajax_login', 'dt_ajax_login' );
function dt_ajax_login(){
	// Get data from request and clean it.
	$form_data = [];
	parse_str( $_POST['form_data'], $form_data );

	// Verify hidden nonce field.
	if( empty( $_POST ) || ! wp_verify_nonce( $form_data['dt_login_nonce'], 'dt_ajax_login' ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	$login = dt_clean_value( $form_data['login-name'] );
	$pass = dt_clean_value( $form_data['login-pass'] );
	$pass = htmlspecialchars_decode( $pass );
	$remember = dt_clean_value( $form_data['rememberme'] ) ? true : false;

	// If data is not set - send error.
	if( ! $login || ! $pass ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	// If can't find such login or email - user not exists, send error.
	if( ! username_exists( $login ) && ! email_exists( $login ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Такой Пользователь не существует.', 'daddytales' )
			]
		);
	}

	// First - trying to find user by login field.
	$user = get_user_by( 'login', $login );

	// If not success - trying to find user by email field.
	if( ! $user ){
		$user = get_user_by( 'email', $login );

		// If fail again - user not found, send error.
		if( ! $user ){
			wp_send_json_error(
				[
					'msg'	=> esc_html__( 'Ошибка во время получения данных Пользователя.', 'daddytales' )
				]
			);
		}
	}

	// Get user ID for user data.
	$user_id = $user->ID;

	// If User have not activated accout yet - send error.
	if( get_user_meta( $user_id, 'has_to_be_activated', true ) != false){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Аккаунт не активирован. Пожалуйста, проверьте указанную при создании Вашего аккаунта почту на предмет письма со ссылкой на активацию. Если письма нет во "Входящих" - не забудьте проверить также "Спам".', 'daddytales' )
			]
		);
	}

	$user_data = get_userdata( $user_id )->data;
	// Get hash pass for comparison.
	$hash = $user_data->user_pass;

	// If passwords are not equal - send error.
	if( ! wp_check_password( $pass, $hash, $user_id ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверный пароль. ', 'daddytales' )
			]
		);
	}

	// If all is OK - trying to sign user on.
	$creds = [
		'user_login'	=> $login,
		'user_password'	=> $pass,
		'remember'		=> $remember
	];
	$signon = wp_signon( $creds, false );

	// If there is error during signon - send it.
	if ( is_wp_error( $signon ) ) {
		wp_send_json_error(
			[
				'msg'	=> $signon->get_error_message()
			]
		);
	}

	wp_set_current_user( $user_id );
    wp_set_auth_cookie( $user_id, $remember );

	// Success! Redirect to User dashboard page on front-end.
	$redirect = get_the_permalink( 6736 );
	wp_send_json_success(
		[
			'msg'		=> "Привет, $login!",
			'redirect'	=> $redirect
		]
	);
}

/**
 * AJAX logout.
 */
add_action( 'wp_ajax_dt_ajax_logout', 'dt_ajax_logout' );
function dt_ajax_logout(){
	wp_logout();
	ob_clean();

	wp_send_json_success(
		[
			'msg'	=> esc_html__( 'Вы успешно вышли из аккаунта.', 'daddytales' )
		]
	);
}

/**
 * AJAX lost password.
 */
add_action( 'wp_ajax_nopriv_dt_ajax_lost_password', 'dt_ajax_lost_password' );
function dt_ajax_lost_password(){
	// Get data from request and clean it.
	$form_data = [];
	parse_str( $_POST['form_data'], $form_data );

	// Verify hidden nonce field.
	if( empty( $_POST ) || ! wp_verify_nonce( $form_data['dt_lostpass_nonce'], 'dt_ajax_lost_password' ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	$login = dt_clean_value( $form_data['login-name'] );

	// If data is not set - send error.
	if( ! $login ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	// If can't find such login or email - user not exists, send error.
	if( ! username_exists( $login ) && ! email_exists( $login ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Такой Пользователь не существует.', 'daddytales' )
			]
		);
	}

	// First - trying to find user by login field.
	$user = get_user_by( 'login', $login );

	// If not success - trying to find user by email field.
	if( ! $user ){
		$user = get_user_by( 'email', $login );

		// If fail again - user not found, send error.
		if( ! $user ){
			wp_send_json_error(
				[
					'msg'	=> esc_html__( 'Ошибка во время получения данных Пользователя.', 'daddytales' )
				]
			);
		}
	}

	// Get user ID for user data.
	$user_id = $user->ID;
	$user_email = $user->data->user_email;
	$pass = wp_generate_password( 16, true, true );
	$pass = str_replace( ' ', '', $pass );

	$msg = "Здравствуйте!\n";
	$msg .= "Вы запросили смену пароля для аккаунта $login.\n";
	$msg .= "Теперь Вы можете войти в свой аккаунт на сайте используя пароль: $pass\n\n\n";
	$msg .= "Если Вы не $login и это письмо попало к Вам по ошибке - просто удалите его.\n";
	$msg .= "С уважением, администрация сайта \"Папины Сказки\".";
	$send = wp_mail( $user_email, 'Папины Сказки', $msg );

	// If letter with password is not send - show error.
	if( ! $send ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неизвестная ошибка. Письмо не отправлено. Попробуйте позже.', 'daddytales' )
			]
		);
	}

	// If all is OK - change user password.
	wp_set_password( $pass, $user_id );
	wp_send_json_success(
		[
			'msg'	=> "Новый пароль выслан на Ваш E-mail. Если не видите письмо в разделе \"Входящие\" Вашей почты - не забудьте проверить также раздел \"Спам\"."
		]
	);
}

/**
 * AJAX register with redirect.
 */
add_action( 'wp_ajax_nopriv_dt_ajax_register', 'dt_ajax_register' );
function dt_ajax_register(){
	if( ! get_option( 'users_can_register' ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Регистрация пользователей временно недоступна, попробуйте позже. Приносим свои извинения.', 'daddytales' )
			]
		);
	}

	// Get data from request and clean it.
	$form_data = [];
	parse_str( $_POST['form_data'], $form_data );

	// Verify hidden nonce field.
	if( empty( $_POST ) || ! wp_verify_nonce( $form_data['dt_register_nonce'], 'dt_ajax_register' ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	$first_name = dt_clean_value( $form_data['first-name'] );
	$last_name = dt_clean_value( $form_data['last-name'] ) ?? '';
	$email = dt_clean_value( $form_data['email'] );
	$login = dt_clean_value( $form_data['login'] );

	$pass = dt_clean_value( $form_data['pass'] );
	$pass = htmlspecialchars_decode( $pass );

	$pass_confirm = dt_clean_value( $form_data['pass-confirm'] );
	$pass_confirm = htmlspecialchars_decode( $pass_confirm );

	// If some of required data fields is not set - send error.
	if( ! $first_name || ! $email || ! $login || ! $pass || ! $pass_confirm ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	// Check first & last names length.
	if( ! dt_check_length( $first_name, 2, 40 ) || ( $last_name && ! dt_check_length( $last_name, 2, 40 ) ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Некорректная длина имени и/или фамилии.', 'daddytales' )
			]
		);
	}

	// Check first & last names symbols.
	if( ! dt_check_name( $first_name ) || ( $last_name && ! dt_check_name( $last_name ) ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Некорректный формат данных в полях имени и/или фамилии.', 'daddytales' )
			]
		);
	}

	// Check E-mail.
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Некорректный формат почты.', 'daddytales' )
			]
		);
	}

	// Check login length.
	if( ! dt_check_length( $login, 2, 20 ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Некорректная длина логина.', 'daddytales' )
			]
		);
	}

	// Check passwords length.
	if( ! dt_check_length( $pass, 8, 30 ) || ! dt_check_length( $pass_confirm, 8, 30 ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Некорректная длина пароля.', 'daddytales' )
			]
		);
	}

	// Check paswords equality.
	if( $pass !== $pass_confirm ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Пароли не совпадают.', 'daddytales' )
			]
		);
	}

	// Data to create new User.
	$userdata = [
		'user_login'			=> $login,
		'user_email'			=> $email,
		'first_name'			=> $first_name,
		'last_name'				=> $last_name,
		'rich_editing'			=> 'true',
		'syntax_highlighting'	=> 'true',
		'comment_shortcuts'		=> 'false',
		'admin_color'			=> 'fresh',
		'use_ssl'				=> 'false',
		'show_admin_bar_front'	=> 'false'
	];
	$new_user_id = wp_insert_user( $userdata );

	// If errors while creating new User - send them.
	if( is_wp_error( $new_user_id ) ){
		switch( $new_user_id->get_error_code() ){
			case 'existing_user_email':
				wp_send_json_error(
					[
						'msg'	=> esc_html__( 'Пользователь с такой почтой уже существует.', 'daddytales' )
					]
				);

			case 'existing_user_login':
				wp_send_json_error(
					[
						'msg'	=> esc_html__( 'Пользователь с таким логином уже существует.', 'daddytales' )
					]
				);

			case 'empty_user_login':
				wp_send_json_error(
					[
						'msg'	=> esc_html__( 'Пожалуйста, используйте для логина только латиницу.', 'daddytales' )
					]
				);

			default:
				wp_send_json_error(
					[
						'msg'	=> $new_user_id->get_error_message()
					]
				);
		}
	}

	// Set new User password.
	wp_set_password( $pass, $new_user_id );

	// Account activation.
	$code = sha1( $new_user_id . time() );
	$link = home_url() . '/activate/?key=' . $code . '&user=' . $new_user_id;
	add_user_meta( $new_user_id, 'has_to_be_activated', $code, true );

	// If this User was invited by other website member.
	if( isset( $_SESSION['invited_by'] ) ){
		// Remember ID in meta field.
		add_user_meta( $new_user_id, 'invited_by', $_SESSION['invited_by'], true );
		// Remove this ID from session.
		unset( $_SESSION['invited_by'] );
	}

	// Letter for new User.
	$msg = "<h1>Здравствуйте!</h1>";
	$msg .= "<p>Вы зарегистрировались на сайте \"Папины Сказки\".</p>";
	$msg .= "<p>Активируйте свой аккаунт, перейдя по <a href=\"$link\"><b>этой ссылке</b></a>.</p>";
	$msg .= "<p>Теперь Вы можете войти в свой аккаунт на сайте используя имя Пользователя $login и пароль $pass</p><br /><br /><br />";
	$msg .= "<p>Если Вы не $login и это письмо попало к Вам по ошибке - просто удалите его.</p>";
	$msg .= "<p>С уважением, администрация сайта \"Папины Сказки\".</p>";

	add_filter( 'wp_mail_from_name', function( $from_name ){
		return 'Папины Сказки';
	} );
	add_filter( 'wp_mail_from', function( $email_address ){
		return 'admin@daddy-tales.ru';
	} );
	add_filter( 'wp_mail_content_type', 'dt_set_html_content_type' );
	$send = wp_mail( $email, 'Папины Сказки', $msg );
	remove_filter( 'wp_mail_content_type', 'dt_set_html_content_type' );

	// If letter with is not send - show error.
	if( ! $send ){
		wp_send_json_error(
			[
				'msg'	=> sprintf( esc_html__( 'Новый Пользователь %s зарегистрирован успешно, но по неизвестной причине письмо с данными для Вашего аккаунта не было отправлено на почту %s.', 'daddytales' ), $login, $email )
			]
		);
	}

	// Success!
	wp_send_json_success(
		[
			'msg'	=> sprintf( esc_html__( 'Новый Пользователь %s зарегистрирован успешно. Письмо с данными для активации Вашего аккаунта было отправлено на почту %s.', 'daddytales' ), $login, $email )
		]
	);
}

/**
 * AJAX change profile avatar.
 */
add_action( 'wp_ajax_dt_ajax_change_profile_avatar', 'dt_ajax_change_profile_avatar' );
function dt_ajax_change_profile_avatar(){
	// Verify hidden nonce field.
	if( empty( $_POST ) || ! wp_verify_nonce( $_POST['dt_change_profile_avatar_nonce'], 'dt_ajax_change_profile_avatar' ) )
		wp_send_json_error( ['msg' => esc_html__( 'Запрос из постороннего источника.', 'daddytales' )] );

	// Get current user ID.
	$user = wp_get_current_user();
	if( ! ( $user_id = $user->ID ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неавторизованный запрос.', 'daddytales' )
			]
		);
	}

	// Avatar upload if file exists.
	if( ! isset( $_FILES['avatar']['size'] ) || $_FILES['avatar']['size'] <= 0 )
		wp_send_json_error( ['msg' => esc_html__( 'Изображение не отправлено.', 'daddytales' )] );

	// Conditions for avatar: ( png | jpg | jpeg ) and < 1 MB.
	$allowed_image_types = ['image/jpeg', 'image/png'];
	$max_image_size = 1000000;

	// Check conditions for avatar.
	if( ! in_array( $_FILES['avatar']['type'], $allowed_image_types ) || ( int ) $_FILES['avatar']['size'] > $max_image_size )
		wp_send_json_error( ['msg' => esc_html__( 'Только ( png | jpg | jpeg ) изображения < 1 Мб разрешены.', 'daddytales' )] );

	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );

	// If current User has no post ID in meta field - insert new hidden post.
	if( ! $post_id = get_user_meta( $user_id, 'dt_avatar_image_id', true ) ){
		$post_id = wp_insert_post(
			[
				'post_author'	=> $user_id,
				'post_type'		=> 'user_avatar',
				'post_status'	=> 'publish',
				'post_title'	=> $user->data->display_name
			]
		);
	}
	$attachment_id = media_handle_upload( 'avatar', $post_id );

	if( is_wp_error( $attachment_id ) )
		wp_send_json_error( [ 'msg' => esc_html__( 'Ошибка при загрузке изображения профиля.', 'daddytales' )] );

	// If all is good - set attachment ID as ID for user avatar.
	update_user_meta( $user_id, 'dt_avatar_image_id', $attachment_id );
	if( $attachment_id != get_user_meta( $user_id, 'dt_avatar_image_id', true ) )
		wp_send_json_error( ['msg' => esc_html__( 'Ошибка при установке изображения профиля.', 'daddytales' )] );

	update_user_meta( $user_id, 'dt_post_id', $post_id );
	if( $post_id != get_user_meta( $user_id, 'dt_post_id', true ) )
		wp_send_json_error( [ 'msg' => esc_html__( 'Ошибка при записи данных изображения профиля.', 'daddytales' )] );

	// Set post thumb - avatar.
	set_post_thumbnail( $post_id, $attachment_id );

	// Success!
	wp_send_json_success( ['msg' => esc_html__( 'Изображение профиля успешно загружено. Перезагрузка...', 'daddytales' )] );
}

/**
 * AJAX save profile common fields.
 */
add_action( 'wp_ajax_dt_ajax_save_common_fields', 'dt_ajax_save_common_fields' );
function dt_ajax_save_common_fields(){
	$form_data = [];
	parse_str( $_POST['form_data'], $form_data );

	// Verify hidden nonce field.
	if( empty( $_POST ) || ! wp_verify_nonce( $form_data['dt_save_common_fields_nonce'], 'dt_ajax_save_common_fields' ) )
		wp_send_json_error( ['msg' => esc_html__( 'Запрос из постороннего источника.', 'daddytales' )] );

	// Get current user ID.
	$user = wp_get_current_user();
	if( ! ( $user_id = $user->ID ) )
		wp_send_json_error( ['msg' => esc_html__( 'Неавторизованный запрос.', 'daddytales' )] );

	$first_name	= dt_clean_value( $form_data['first-name'] );
	$last_name	= dt_clean_value( $form_data['last-name'] );
	$website	= dt_clean_value( $form_data['website'] );
	$biography	= dt_clean_value( $form_data['biography'] );

	// If required data fields is not set - send error.
	if( ! $first_name && ! $last_name && ! $website && ! $biography )
		wp_send_json_error( ['msg' => esc_html__( 'Поля пусты.', 'daddytales' )] );

	// Set other User meta fields - only if they are not empty.
	if( $website ){
		$update_website = wp_update_user( [
			'ID'		=> $user_id,
			'user_url'	=> $website
		] );

		if( is_wp_error( $update_website ) )
			wp_send_json_error( ['msg' => esc_html__( 'Ошибка при обновлении поля "Веб-сайт".', 'daddytales' )] );
	}

	if( $first_name )	update_user_meta( $user_id, 'first_name', $first_name );
	if( $last_name )	update_user_meta( $user_id, 'last_name', $last_name );
	if( $biography )	update_user_meta( $user_id, 'description', $biography );

	// Success!
	wp_send_json_success( ['msg' => esc_html__( 'Изменения сохранены успешно. Перезагрузка...', 'daddytales' )] );
}

/**
 * AJAX change password.
 */
add_action( 'wp_ajax_dt_ajax_change_password', 'dt_ajax_change_password' );
function dt_ajax_change_password(){
	$form_data = [];
	parse_str( $_POST['form_data'], $form_data );

	// Verify hidden nonce field.
	if( empty( $_POST ) || ! wp_verify_nonce( $form_data['dt_change_password_nonce'], 'dt_ajax_change_password' ) )
		wp_send_json_error( ['msg' => esc_html__( 'Запрос из постороннего источника.', 'daddytales' )] );

	// Get current user ID.
	$user = wp_get_current_user();
	if( ! ( $user_id = $user->ID ) )
		wp_send_json_error( ['msg' => esc_html__( 'Неавторизованный запрос.', 'daddytales' )] );

	$pass = dt_clean_value( $form_data['pass'] );
	$pass = htmlspecialchars_decode( $pass );

	$pass_new = dt_clean_value( $form_data['pass-new'] );
	$pass_new = htmlspecialchars_decode( $pass_new );

	$pass_new_confirm = dt_clean_value( $form_data['pass-new-confirm'] );
	$pass_new_confirm = htmlspecialchars_decode( $pass_new_confirm );

	// If required data fields is not set - send error.
	if( ! $pass && ! $pass_new && ! $pass_new_confirm )
		wp_send_json_error( ['msg' => esc_html__( 'Поля пусты.', 'daddytales' )] );

	// If at least one password field is empty - send error.
	if( empty( $pass ) || empty( $pass_new ) || empty( $pass_new_confirm ) )
		wp_send_json_error( ['msg' => esc_html__( 'Все поля с паролями должны быть заполнены для изменения.', 'daddytales' )] );

	// If new passwords are the same as old - send error.
	if( $pass === $pass_new && $pass === $pass_new_confirm )
		wp_send_json_error( ['msg' => esc_html__( 'Ошибка - все поля с паролями одинаковы.', 'daddytales' )] );

	// Get hash pass for comparison.
	$user_data	= get_userdata( $user_id )->data;
	$hash		= $user_data->user_pass;

	// If old pass is not equal to DB - send error.
	if( ! wp_check_password( $pass, $hash, $user_id ) )
		wp_send_json_error( ['msg' => esc_html__( 'Ошибка - старый пароль указан неверно.', 'daddytales' )] );

	// Check new password length.
	if( ! dt_check_length( $pass_new, 8, 30 ) || ! dt_check_length( $pass_new_confirm, 8, 30 ) )
		wp_send_json_error( ['msg' => esc_html__( 'Некорректная длина нового пароля.', 'daddytales' )] );

	// Check new passwords equality.
	if( $pass_new !== $pass_new_confirm )
		wp_send_json_error( ['msg' => esc_html__( 'Новые пароли различаются.', 'daddytales' )] );

	// Set new User password.
	wp_set_password( $pass_new, $user_id );

	// Letter to notice current User by E-mail about password is changed.
	$msg = "<h1>Привет, $user->user_login!</h1>
	<p>Пароль от Вашего аккаунта изменён на новый: $pass_new.</p><br />
	<p>Если это были не Вы - пожалуйста, обратитесь к Администрации сайта \"Папины Сказки\" как можно быстрее.</p><br />
	<p>Если Вы не $user->user_login - просто удалите это письмо.</p><br />
	<p>С наилучшими пожеланиями, Администрация сайта <a href=\"" . home_url( '/' ) . "\">\"Папины Сказки\"</a>.</p>";

	add_filter( 'wp_mail_from_name', function( $from_name ){
		return 'Папины Сказки';
	} );
	add_filter( 'wp_mail_from', function( $email_address ){
		return 'no-reply@daddy-tales.ru';
	} );
	add_filter( 'wp_mail_content_type', 'dt_set_html_content_type' );
	wp_mail( $user->user_email, 'Папины Сказки', $msg );
	remove_filter( 'wp_mail_content_type', 'dt_set_html_content_type' );

	// Success!
	wp_send_json_success( ['msg' => esc_html__( 'Пароль изменён успешно. Перезагрузка...', 'daddytales' )] );
}

/**
 * AJAX invite a colleague -
 * sends letter to future member E-mail.
 */
add_action( 'wp_ajax_dt_ajax_invite_friend', 'dt_ajax_invite_friend' );
function dt_ajax_invite_friend(){
	// Get data from request and clean it.
	$form_data = [];
	parse_str( $_POST['form_data'], $form_data );

	// Verify hidden nonce field.
	if( empty( $_POST ) || ! wp_verify_nonce( $form_data['dt_invite_friend_nonce'], 'dt_ajax_invite_friend' ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	// Get current user ID.
	$user = wp_get_current_user();
	if( ! ( $user_id = $user->ID ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неавторизованный запрос.', 'daddytales' )
			]
		);
	}

	$new_fullname = dt_clean_value( $form_data['new-fullname'] );
	$new_email = dt_clean_value( $form_data['new-email'] );

	// If necessary fields are not set.
	if( ! $new_fullname || ! $new_email ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	// Check name symbols.
	if( ! dt_check_name( $new_fullname ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Некорректный формат имени.', 'daddytales' )
			]
		);
	}

	// Check name length.
	if( ! dt_check_length( $new_fullname, 3, 50 ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Некорректная длина имени.', 'daddytales' )
			]
		);
	}

	// Check E-mail.
	if( ! filter_var( $new_email, FILTER_VALIDATE_EMAIL ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Некорректный формат E-mail.', 'daddytales' )
			]
		);
	}

	if( email_exists( $new_email ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Пользователь с таким E-mail уже существует.', 'daddytales' )
			]
		);
	}

	$invite_url = home_url( '/' ) . 'registration/?invited_by=' . $user_id;

	// Letter to future member.
	$msg = "<h1>Привет, $new_fullname!</h1>
	<p>Это письмо является приглашением от зарегистрированного пользователя портала \"Папины сказки\" $user->first_name стать полноправным членом сообщества <a href=\"" . $invite_url . "\">\"Папиных Сказок\"</a>.</p><br /><br />
	<p>Если Вы не $new_fullname - просто удалите это письмо.</p><br />
	<p>С наилучшими пожеланиями, Администрация сайта \"Папины Сказки\".</p>";

	add_filter( 'wp_mail_from_name', function( $from_name ){
		return 'Папины Сказки';
	} );
	add_filter( 'wp_mail_from', function( $email_address ){
		return 'no-reply@daddy-tales.ru';
	} );
	add_filter( 'wp_mail_content_type', 'dt_set_html_content_type' );
	$send = wp_mail( $new_email, 'Папины Сказки', $msg );
	remove_filter( 'wp_mail_content_type', 'dt_set_html_content_type' );

	// If letter send is failed.
	if( ! $send ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Приглашение не отправлено. Пожалуйста, попробуйте позднее.', 'daddytales' )
			]
		);
	}

	// Success!
	wp_send_json_success(
		[
			'msg'	=> sprintf( esc_html__( 'Ваше приглашение успешно отправлено на почту %s!', 'daddytales' ), $new_email )
		]
	);
}

/**
 * AJAX send letter to Administrator.
 */
add_action( 'wp_ajax_dt_ajax_get_in_touch_form_send', 'dt_ajax_get_in_touch_form_send' );
add_action( 'wp_ajax_nopriv_dt_ajax_get_in_touch_form_send', 'dt_ajax_get_in_touch_form_send' );
function dt_ajax_get_in_touch_form_send(){
	// Get data from request and clean it.
	$form_data = [];
	parse_str( $_POST['form_data'], $form_data );

	// Verify hidden nonce field.
	if( empty( $_POST ) || ! wp_verify_nonce( $form_data['dt_modal_nonce'], 'dt_ajax_modal' ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	$subject = dt_clean_value( $form_data['subject'] );
	$message = dt_clean_value( $form_data['message'] );

	// If data is not set - send error.
	if( ! $subject || ! $message ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	// Check subject length.
	if( ! dt_check_length( $subject, 2, 100 ) ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Некорректная длина темы письма.', 'daddytales' )
			]
		);
	}

	// Trying to get current user who sends the letter.
	$current_user = wp_get_current_user();
	$current_user_login = $current_user_email = null;

	// If user is logged in.
	if( $current_user ){
		$current_user_login = $current_user->user_login;
		$current_user_email = $current_user->user_email;
		$current_user_text = "Пользователь $current_user_login с почтой $current_user_email отправил Вам сообщение с формы обратной связи:";
	}	else {
		$current_user_text = "Неизвестный Посетитель отправил Вам сообщение с формы обратной связи:";
	}

	// Letter for Administrator.
	$msg = "
		<h1>Здравствуйте!</h1>
		<p>$current_user_text</p><br /><br />
		<p>" . $message . "</p><br /><br /><br />
		<p>Если это письмо попало к Вам по ошибке - просто удалите его.</p>
		<p>С уважением, администрация сайта \"Папины Сказки\".</p>
	";
	$admin_email = get_option( 'admin_email' );

	add_filter( 'wp_mail_from_name', function( $from_name ){
		return 'Папины Сказки';
	} );
	add_filter( 'wp_mail_from', function( $email_address ){
		return 'admin@daddy-tales.ru';
	} );
	add_filter( 'wp_mail_content_type', 'dt_set_html_content_type' );
	$send = wp_mail( $admin_email, 'Папины Сказки', $msg );
	remove_filter( 'wp_mail_content_type', 'dt_set_html_content_type' );

	// If letter with is not send - show error.
	if( ! $send ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Ошибка. По неизвестной причине письмо не было отправлено. Пожалуйста, попробуйте позже.', 'daddytales' )
			]
		);
	}

	wp_send_json_success(
		[
			'msg'	=> esc_html__( 'Отправка прошла успешно! Спасибо за Ваше сообщение.', 'daddytales' )
		]
	);
}

/**
 * AJAX posts pagination.
 */
add_action( 'wp_ajax_dt_ajax_posts_pagination', 'dt_ajax_posts_pagination' );
add_action( 'wp_ajax_nopriv_dt_ajax_posts_pagination', 'dt_ajax_posts_pagination' );
function dt_ajax_posts_pagination(){
	// Get data from request and clean it.
	$page_to_load	= dt_clean_value( $_POST['page'] ) ?? 1;
	$search_query	= dt_clean_value( $_POST['search'] );
	$post_type		= dt_clean_value( $_POST['type'] );
	$taxonomy		= dt_clean_value( $_POST['taxonomy'] );
	$term			= dt_clean_value( $_POST['term'] );
	$posts_per_page	= 20;
	$offset = $page_to_load * $posts_per_page - $posts_per_page;

	$args = [
		'post_type'         	=> $post_type,
		'post_status'       	=> 'publish',
		'posts_per_page'    	=> $posts_per_page,
		'offset'            	=> $offset
	];

	// If search query is set - this is search results page, don't need tax & term.
	if( $search_query ){
		$args['s'] = $search_query;
	}	else {
		$args['tax_query'] = [
			[
				'taxonomy'	=> $taxonomy,
				'field'		=> 'slug',
				'terms'		=> $term
			]
		];
	}

	$new_query = new WP_Query( $args );
	$posts = $pagination = '';

	if( $new_query->have_posts() ){
		ob_start();
		while( $new_query->have_posts() ){
			$new_query->the_post();
			$post_id = get_the_ID();

			if( ! $post_id ) continue;

			switch( $post_type ){
				case 'song':
				case 'audio':
					$preview_args = [
						'post_id'	=> $post_id,
						'btn_icon'	=> '<i class="fas fa-play"></i>',
						'btn_text'	=> esc_html__( 'Слушать', 'daddytales' )
					];
					get_template_part( 'includes/single/song/song', 'preview', $preview_args );
					break;

				case 'poem':
					$preview_args = [
						'post_id'	=> $post_id,
						'post_type'	=> 'poem',
						'tax_name'	=> $taxonomy,
						'btn_icon'	=> '<i class="fas fa-feather"></i>',
						'btn_text'	=> esc_html__( 'Читать', 'daddytales' )
					];
					get_template_part( 'includes/single/song/song', 'preview', $preview_args );
					break;

				case 'cartoon':
				default:
					get_template_part( 'includes/single/slider', 'preview', ['post_id' => $post_id] );
					break;
			}
		}
		$posts = ob_get_contents();
		ob_end_clean();

		$query_max_num_pages = $new_query->max_num_pages;
		$pagination = '<nav class = "navigation pagination" role="navigation">
			<div class="nav-links">
				' . paginate_links(
					[
						'total'					=> $query_max_num_pages,
						'current'				=> $page_to_load,
						'show_all'				=> false,
						'end_size'				=> 1,
						'mid_size'				=> 1,
						'prev_next'				=> true,
						'prev_text'				=> '<i class="fas fa-chevron-left"></i>',
						'next_text'				=> '<i class="fas fa-chevron-right"></i>',
						'screen_reader_text'	=> ' '
					]
				) . '
			</div>
		</nav>';
	}
	wp_reset_query();

	if( ! $posts ) $posts = '<p class="posts-not-found">' . esc_html__( 'Записи не найдены.', 'daddytales' ) . '</p>';

	wp_send_json_success(
		[
			'posts'			=> $posts,
			'pagination'	=> $pagination
		]
	);
}

/**
 * AJAX download image from Coloring Image post type.
 */
add_action( 'wp_ajax_dt_ajax_download_image', 'dt_ajax_download_image' );
add_action( 'wp_ajax_nopriv_dt_ajax_download_image', 'dt_ajax_download_image' );
function dt_ajax_download_image(){
	$post_id = dt_clean_value( $_POST['post_id'] );

	// Send error if post ID was not sent.
	if( ! $post_id )
		wp_send_json_error( ['msg' => esc_html__( 'Необходимые данные не переданы.', 'daddytales' )] );

	$image_url	= is_user_logged_in()
				? get_the_post_thumbnail_url( $post_id, 'full' )
				: get_the_post_thumbnail_url( $post_id, 'medium' );

	wp_send_json_success(
		[
			'msg'		=> esc_html__( 'Success', 'daddytales' ),
			'image_url'	=> $image_url
		]
	);
}

