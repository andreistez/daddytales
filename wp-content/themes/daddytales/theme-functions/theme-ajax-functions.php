<?php
/**
 * AJAX login with redirect.
 */
add_action( 'wp_ajax_dt_ajax_login', 'dt_ajax_login' );
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
	$remember = dt_clean_value( $form_data['rememberme'] ) ? true : false;

	// If data is not set - send error.
	if( ! $login || ! $pass ){
		wp_send_json_error(
			[
				'msg'	=> esc_html__( 'Неверные данные.', 'daddytales' )
			]
		);
	}

	$pass = str_replace( '&amp;', '&', $pass );

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
add_action( 'wp_ajax_nopriv_dt_ajax_logout', 'dt_ajax_logout' );
function dt_ajax_logout(){
	// Redirect link to Login page.
	$redirect = get_the_permalink( 6706 );
	wp_logout();
	ob_clean();

	wp_send_json_success(
		[
			'msg'		=> esc_html__( 'Вы успешно вышли из аккаунта.', 'daddytales' ),
			'redirect'	=> $redirect
		]
	);
}

/**
 * AJAX lost password.
 */
add_action( 'wp_ajax_dt_ajax_lost_password', 'dt_ajax_lost_password' );
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
add_action( 'wp_ajax_dt_ajax_register', 'dt_ajax_register' );
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
	$pass_confirm = dt_clean_value( $form_data['pass-confirm'] );

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
	add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	$send = wp_mail( $email, 'Папины Сказки', $msg );
	remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

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
	add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	$send = wp_mail( $admin_email, 'Папины Сказки', $msg );
	remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

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

