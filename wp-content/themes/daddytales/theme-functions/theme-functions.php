<?php
/**
 * For user sessions.
 */
function dt_register_session(){
	if( ! session_id() ) session_start();
}
add_action( 'init', 'dt_register_session' );

/**
 * Clean incoming value from trash.
 *
 * @param	mixed	$value	- some value to clean.
 * @return	mixed	$value	- the same value, but cleaned.
 */
function dt_clean_value( $value )
{
	$value = wp_unslash( $value );
	$value = trim( $value );
	$value = stripslashes( $value );
	$value = strip_tags( $value );
	$value = htmlspecialchars( $value );
	return $value;
}

/**
 * Function checks if value length is between min and max parameters.
 *
 * @param   mixed   $value  - any value.
 * @param   int     $min    - minimum symbols value length.
 * @param   int     $max    - maximum symbols value length.
 * @return  bool            - true if OK, false if value length is too small or large.
 */
function dt_check_length( $value = '', int $min, int $max ): bool
{
	$result = ( mb_strlen( $value ) < $min || mb_strlen( $value ) > $max );
	return !$result;
}

/**
 * Function checks name symbols.
 *
 * @param   string  $name   - some name.
 * @return  bool            - true if OK, false if string has bad symbols.
 */
function dt_check_name( string $name = '' ): bool
{
	$name_check = ['А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е', 'Ё', 'ё', 'Ж', 'ж', 'З', 'з',
		'И', 'и', 'Й', 'й', 'К', 'к', 'Л', 'л', 'М', 'м', 'Н', 'н', 'О', 'о', 'П', 'п', 'Р', 'р',
		'С', 'с', 'Т', 'т', 'У', 'у', 'Ф', 'ф', 'Х', 'х', 'Ц', 'ц', 'Ч', 'ч', 'Ш', 'ш', 'Щ', 'щ',
		'Ъ', 'ъ', 'Ы', 'ы', 'Ь', 'ь', 'Э', 'э', 'Ю', 'ю', 'Я', 'я', 'Є', 'є', 'І', 'і', 'Ї', 'ї',
		'A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e', 'F', 'f', 'G', 'g', 'H', 'h', 'I', 'i',
		'J', 'j', 'K', 'k', 'L', 'l', 'M', 'm', 'N', 'n', 'O', 'o', 'P', 'p', 'Q', 'q', 'R', 'r',
		'S', 's', 'T', 't', 'U', 'u', 'V', 'v', 'W', 'w', 'X', 'x', 'Y', 'y', 'Z', 'z', '-', '\'', ' '];
	$name_arr = preg_split( '//u', $name, -1, PREG_SPLIT_NO_EMPTY );

	for( $i = 0; $i < count( $name_arr ); $i++ ){
		$break_flag = 1;

		for( $j = 0; $j < count( $name_check ); $j++ ){
			if( $name_arr[$i] === $name_check[$j] ){
				$break_flag = 0;
				break;
			}
		}

		if( $break_flag ) return false;
	}

	return true;
}

/**
 * Redirect users from Admin Console.
 */
add_action( 'init', 'dt_blockusers_init' );
function dt_blockusers_init(){
	global $pagenow;

	if(
		( 'wp-login.php' === $pagenow || is_admin() )
		&& ! current_user_can( 'administrator' )
		&& ! ( defined( 'DOING_AJAX' ) && DOING_AJAX )
	){
		wp_redirect( get_the_permalink( 6706 ) );
		exit;
	}
}

/**
 * Catches all failed logins and redirect them.
 */
add_action( 'wp_login_failed', 'dt_login_failed', 10, 1 );
function dt_login_failed( $username ){
	wp_redirect( get_the_permalink( 6706 ), 302 );
	exit;
}

/**
 * Get post views count.
 */
function dt_get_post_views( $post_id ){
	$count_key = 'post_views_count';
	$count = get_post_meta( $post_id, $count_key, true );

	if( $count === '' ){
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
		return '0';
	}

	return $count;
}

/**
 * Set post views count.
 */
function dt_set_post_views( $post_id ){
	$count_key = 'post_views_count';
	$count = get_post_meta( $post_id, $count_key, true );

	if( $count === '' ){
		$count = 0;
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
	}	else {
		$count++;
		update_post_meta( $post_id, $count_key, $count );
	}
}

/**
 * Remove double view count when opening post.
 */
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

/**
 * Posts views in Admin Console.
 */
add_filter( 'manage_posts_columns', 'dt_posts_column_views' );
add_filter( 'manage_pages_columns', 'dt_posts_column_views' );
function dt_posts_column_views( $defaults ){
	$defaults['post_views'] = esc_html__( 'Views' );
	return $defaults;
}
add_action( 'manage_posts_custom_column', 'dt_posts_custom_column_views', 5, 2 );
add_action( 'manage_pages_custom_column', 'dt_posts_custom_column_views', 5, 2 );
function dt_posts_custom_column_views( $column_name, $id ){
	if( $column_name === 'post_views' ) echo dt_get_post_views( get_the_ID() );
}

/**
 * Function for HTML content type in E-mails.
 */
function dt_set_html_content_type(){
	return 'text/html';
}

/**
 * Register new post types and taxonomies.
 */
add_action( 'init', 'dt_custom_init' );
function dt_custom_init(){
	// Hidden post type for users' avatars.
	register_post_type(
		'user_avatar',
		[
			'labels'				=> ['name' => esc_html__( 'User Avatar', 'daddytales' )],
			'menu_icon'				=> 'dashicons-id-alt',
			'public'				=> false,
			'publicly_queryable'	=> false,
			'exclude_from_search'	=> true,
			'show_ui'				=> false,
			'show_in_menu'			=> false,
			'show_in_rest'			=> false,
			'query_var'				=> true,
			'rewrite'				=> false,
			'capability_type'		=> 'user_avatar',
			'map_meta_cap'			=> true,
			'has_archive'			=> false,
			'hierarchical'			=> false,
			'supports'				=> ['title', 'thumbnail', 'author']
		]
	);

	// Cartoons taxonomy.
	register_taxonomy(
		'cartoons',
		['cartoon'],
		[
			'label'                 => esc_html__( 'Категории Мультфильмов', 'daddytales' ),
			'labels'                => [
				'name'              => esc_html__( 'Категории Мультфильмов', 'daddytales' ),
				'singular_name'     => esc_html__( 'Категория Мультфильмов', 'daddytales' ),
				'search_items'      => esc_html__( 'Искать Категории Мультфильмов', 'daddytales' ),
				'all_items'         => esc_html__( 'Все Категории Мультфильмов', 'daddytales' ),
				'view_item '        => esc_html__( 'Показать Категории Мультфильмов', 'daddytales' ),
				'parent_item'       => esc_html__( 'Родительская Категория', 'daddytales' ),
				'parent_item_colon' => esc_html__( 'Родительская Категория:', 'daddytales' ),
				'edit_item'         => esc_html__( 'Редактировать Категорию', 'daddytales' ),
				'update_item'       => esc_html__( 'Обновить Категорию', 'daddytales' ),
				'add_new_item'      => esc_html__( 'Добавить Новую Категорию Мультфильмов', 'daddytales' ),
				'new_item_name'     => esc_html__( 'Новая Категория Мультфильмов', 'daddytales' ),
				'menu_name'         => esc_html__( 'Категории Мультфильмов', 'daddytales' ),
			],
			'description'           => '',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_in_nav_menus'     => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_tagcloud'         => true,
			'show_in_quick_edit'    => true,
			'hierarchical'          => true,
			'rewrite'               => true,
			'capabilities'          => [],
			'show_admin_column'     => true,
			'show_in_rest'          => true
		]
	);
	// Cartoon post type.
	register_post_type(
		'cartoon',
		[
			'labels'				=> [
				'name'				=> esc_html__( 'Мультфильм', 'daddytales' ),
				'singular_name'		=> esc_html__( 'Мультфильм', 'daddytales' ),
				'add_new'			=> esc_html__( 'Добавить Новый', 'daddytales' ),
				'add_new_item'		=> esc_html__( 'Добавить Новый Мультфильм', 'daddytales' ),
				'edit_item'			=> esc_html__( 'Редактировать Мультфильм', 'daddytales' ),
				'new_item'			=> esc_html__( 'Новый Мультфильм', 'daddytales' ),
				'view_item'			=> esc_html__( 'Посмотреть Мультфильм', 'daddytales' ),
				'search_items'		=> esc_html__( 'Найти Мультфильм', 'daddytales' ),
				'not_found'         => esc_html__( 'Мультфильмы не Найдены', 'daddytales' ),
				'not_found_in_trash'=> esc_html__( 'В Корзине Нет Мультфильмов', 'daddytales' ),
				'parent_item_colon'	=> '',
				'menu_name'			=> esc_html__( 'Мультфильмы', 'daddytales' )
			],
			'menu_icon'				=> 'dashicons-video-alt3',
			'public'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> false,
			'show_ui'				=> true,
			'show_in_menu'			=> true,
			'show_in_rest'			=> true,
			'query_var'				=> true,
			'rewrite'				=> ['slug' => 'cartoon'],
			'capability_type'		=> 'post',
			'map_meta_cap'			=> true,
			'has_archive'			=> true,
			'hierarchical'			=> false,
			'menu_position'			=> 6,
			'supports'				=> ['title', 'editor', 'thumbnail', 'author', 'comments']
		]
	);

	// Songs taxonomy.
	register_taxonomy(
		'songs',
		['song'],
		[
			'label'                 => esc_html__( 'Категории Песен', 'daddytales' ),
			'labels'                => [
				'name'              => esc_html__( 'Категории Песен', 'daddytales' ),
				'singular_name'     => esc_html__( 'Категория Песен', 'daddytales' ),
				'search_items'      => esc_html__( 'Искать Категории Песен', 'daddytales' ),
				'all_items'         => esc_html__( 'Все Категории Песен', 'daddytales' ),
				'view_item '        => esc_html__( 'Показать Категории Песен', 'daddytales' ),
				'parent_item'       => esc_html__( 'Родительская Категория', 'daddytales' ),
				'parent_item_colon' => esc_html__( 'Родительская Категория:', 'daddytales' ),
				'edit_item'         => esc_html__( 'Редактировать Категорию', 'daddytales' ),
				'update_item'       => esc_html__( 'Обновить Категорию', 'daddytales' ),
				'add_new_item'      => esc_html__( 'Добавить Новую Категорию Песен', 'daddytales' ),
				'new_item_name'     => esc_html__( 'Новая Категория Песен', 'daddytales' ),
				'menu_name'         => esc_html__( 'Категории Песен', 'daddytales' ),
			],
			'description'           => '',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_in_nav_menus'     => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_tagcloud'         => true,
			'show_in_quick_edit'    => true,
			'hierarchical'          => true,
			'rewrite'               => true,
			'capabilities'          => [],
			'show_admin_column'     => true,
			'show_in_rest'          => true
		]
	);
	// Song post type.
	register_post_type(
		'song',
		[
			'labels'				=> [
				'name'				=> esc_html__( 'Песня', 'daddytales' ),
				'singular_name'		=> esc_html__( 'Песня', 'daddytales' ),
				'add_new'			=> esc_html__( 'Добавить Новую', 'daddytales' ),
				'add_new_item'		=> esc_html__( 'Добавить Новую Песню', 'daddytales' ),
				'edit_item'			=> esc_html__( 'Редактировать Песню', 'daddytales' ),
				'new_item'			=> esc_html__( 'Новая Песня', 'daddytales' ),
				'view_item'			=> esc_html__( 'Посмотреть Песню', 'daddytales' ),
				'search_items'		=> esc_html__( 'Найти Песню', 'daddytales' ),
				'not_found'         => esc_html__( 'Песни не Найдены', 'daddytales' ),
				'not_found_in_trash'=> esc_html__( 'В Корзине Нет Песен', 'daddytales' ),
				'parent_item_colon'	=> '',
				'menu_name'			=> esc_html__( 'Песни', 'daddytales' )
			],
			'menu_icon'				=> 'dashicons-format-audio',
			'public'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> false,
			'show_ui'				=> true,
			'show_in_menu'			=> true,
			'show_in_rest'			=> true,
			'query_var'				=> true,
			'rewrite'				=> ['slug' => 'song'],
			'capability_type'		=> 'post',
			'map_meta_cap'			=> true,
			'has_archive'			=> true,
			'hierarchical'			=> false,
			'menu_position'			=> 7,
			'supports'				=> ['title', 'editor', 'thumbnail', 'author', 'comments']
		]
	);

	// Audio taxonomy.
	register_taxonomy(
		'audios',
		['audio'],
		[
			'label'                 => esc_html__( 'Категории Аудио', 'daddytales' ),
			'labels'                => [
				'name'              => esc_html__( 'Категории Аудио', 'daddytales' ),
				'singular_name'     => esc_html__( 'Категория Аудио', 'daddytales' ),
				'search_items'      => esc_html__( 'Искать Категории Аудио', 'daddytales' ),
				'all_items'         => esc_html__( 'Все Категории Аудио', 'daddytales' ),
				'view_item '        => esc_html__( 'Показать Категории Аудио', 'daddytales' ),
				'parent_item'       => esc_html__( 'Родительская Категория', 'daddytales' ),
				'parent_item_colon' => esc_html__( 'Родительская Категория:', 'daddytales' ),
				'edit_item'         => esc_html__( 'Редактировать Категорию', 'daddytales' ),
				'update_item'       => esc_html__( 'Обновить Категорию', 'daddytales' ),
				'add_new_item'      => esc_html__( 'Добавить Новую Категорию Аудио', 'daddytales' ),
				'new_item_name'     => esc_html__( 'Новая Категория Аудио', 'daddytales' ),
				'menu_name'         => esc_html__( 'Категории Аудио', 'daddytales' ),
			],
			'description'           => '',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_in_nav_menus'     => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_tagcloud'         => true,
			'show_in_quick_edit'    => true,
			'hierarchical'          => true,
			'rewrite'               => true,
			'capabilities'          => [],
			'show_admin_column'     => true,
			'show_in_rest'          => true
		]
	);
	// Audio post type.
	register_post_type(
		'audio',
		[
			'labels'				=> [
				'name'				=> esc_html__( 'Аудио', 'daddytales' ),
				'singular_name'		=> esc_html__( 'Аудио', 'daddytales' ),
				'add_new'			=> esc_html__( 'Добавить Новую', 'daddytales' ),
				'add_new_item'		=> esc_html__( 'Добавить Новую Аудио', 'daddytales' ),
				'edit_item'			=> esc_html__( 'Редактировать Аудио', 'daddytales' ),
				'new_item'			=> esc_html__( 'Новая Аудио', 'daddytales' ),
				'view_item'			=> esc_html__( 'Посмотреть Аудио', 'daddytales' ),
				'search_items'		=> esc_html__( 'Найти Аудио', 'daddytales' ),
				'not_found'         => esc_html__( 'Аудио не Найдены', 'daddytales' ),
				'not_found_in_trash'=> esc_html__( 'В Корзине Нет Аудио', 'daddytales' ),
				'parent_item_colon'	=> '',
				'menu_name'			=> esc_html__( 'Аудио', 'daddytales' )
			],
			'menu_icon'				=> 'dashicons-playlist-audio',
			'public'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> false,
			'show_ui'				=> true,
			'show_in_menu'			=> true,
			'show_in_rest'			=> true,
			'query_var'				=> true,
			'rewrite'				=> ['slug' => 'audio'],
			'capability_type'		=> 'post',
			'map_meta_cap'			=> true,
			'has_archive'			=> true,
			'hierarchical'			=> false,
			'menu_position'			=> 7,
			'supports'				=> ['title', 'editor', 'thumbnail', 'author', 'comments']
		]
	);

	// Poems taxonomy.
	register_taxonomy(
		'poems',
		['poem'],
		[
			'label'                 => esc_html__( 'Категории Стихов', 'daddytales' ),
			'labels'                => [
				'name'              => esc_html__( 'Категории Стихов', 'daddytales' ),
				'singular_name'     => esc_html__( 'Категория Стихов', 'daddytales' ),
				'search_items'      => esc_html__( 'Искать Категории Стихов', 'daddytales' ),
				'all_items'         => esc_html__( 'Все Категории Стихов', 'daddytales' ),
				'view_item '        => esc_html__( 'Показать Категории Стихов', 'daddytales' ),
				'parent_item'       => esc_html__( 'Родительская Категория', 'daddytales' ),
				'parent_item_colon' => esc_html__( 'Родительская Категория:', 'daddytales' ),
				'edit_item'         => esc_html__( 'Редактировать Категорию', 'daddytales' ),
				'update_item'       => esc_html__( 'Обновить Категорию', 'daddytales' ),
				'add_new_item'      => esc_html__( 'Добавить Новую Категорию Стихов', 'daddytales' ),
				'new_item_name'     => esc_html__( 'Новая Категория Стихов', 'daddytales' ),
				'menu_name'         => esc_html__( 'Категории Стихов', 'daddytales' ),
			],
			'description'           => '',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_in_nav_menus'     => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_tagcloud'         => true,
			'show_in_quick_edit'    => true,
			'hierarchical'          => true,
			'rewrite'               => true,
			'capabilities'          => [],
			'show_admin_column'     => true,
			'show_in_rest'          => true
		]
	);
	// Poem post type.
	register_post_type(
		'poem',
		[
			'labels'				=> [
				'name'				=> esc_html__( 'Стих', 'daddytales' ),
				'singular_name'		=> esc_html__( 'Стих', 'daddytales' ),
				'add_new'			=> esc_html__( 'Добавить Новый', 'daddytales' ),
				'add_new_item'		=> esc_html__( 'Добавить Новый Стих', 'daddytales' ),
				'edit_item'			=> esc_html__( 'Редактировать Стих', 'daddytales' ),
				'new_item'			=> esc_html__( 'Новый Стих', 'daddytales' ),
				'view_item'			=> esc_html__( 'Посмотреть Стих', 'daddytales' ),
				'search_items'		=> esc_html__( 'Найти Стих', 'daddytales' ),
				'not_found'         => esc_html__( 'Стихи не Найдены', 'daddytales' ),
				'not_found_in_trash'=> esc_html__( 'В Корзине Нет Стихов', 'daddytales' ),
				'parent_item_colon'	=> '',
				'menu_name'			=> esc_html__( 'Стихи', 'daddytales' )
			],
			'menu_icon'				=> 'dashicons-editor-aligncenter',
			'public'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> false,
			'show_ui'				=> true,
			'show_in_menu'			=> true,
			'show_in_rest'			=> true,
			'query_var'				=> true,
			'rewrite'				=> ['slug' => 'poem'],
			'capability_type'		=> 'post',
			'map_meta_cap'			=> true,
			'has_archive'			=> true,
			'hierarchical'			=> false,
			'menu_position'			=> 7,
			'supports'				=> ['title', 'editor', 'thumbnail', 'comments']
		]
	);

	// Coloring images taxonomy.
	register_taxonomy(
		'coloring_images',
		['coloring_image'],
		[
			'label'                 => esc_html__( 'Категории Раскрасок', 'daddytales' ),
			'labels'                => [
				'name'              => esc_html__( 'Категории Раскрасок', 'daddytales' ),
				'singular_name'     => esc_html__( 'Категория Раскрасок', 'daddytales' ),
				'search_items'      => esc_html__( 'Искать Категории Раскрасок', 'daddytales' ),
				'all_items'         => esc_html__( 'Все Категории Раскрасок', 'daddytales' ),
				'view_item '        => esc_html__( 'Показать Категории Раскрасок', 'daddytales' ),
				'parent_item'       => esc_html__( 'Родительская Категория', 'daddytales' ),
				'parent_item_colon' => esc_html__( 'Родительская Категория:', 'daddytales' ),
				'edit_item'         => esc_html__( 'Редактировать Категорию', 'daddytales' ),
				'update_item'       => esc_html__( 'Обновить Категорию', 'daddytales' ),
				'add_new_item'      => esc_html__( 'Добавить Новую Категорию Раскрасок', 'daddytales' ),
				'new_item_name'     => esc_html__( 'Новая Категория Раскрасок', 'daddytales' ),
				'menu_name'         => esc_html__( 'Категории Раскрасок', 'daddytales' ),
			],
			'description'           => '',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_in_nav_menus'     => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_tagcloud'         => true,
			'show_in_quick_edit'    => true,
			'hierarchical'          => true,
			'rewrite'               => true,
			'capabilities'          => [],
			'show_admin_column'     => true,
			'show_in_rest'          => true
		]
	);
	// Coloring image post type.
	register_post_type(
		'coloring_image',
		[
			'labels'				=> [
				'name'				=> esc_html__( 'Раскраска', 'daddytales' ),
				'singular_name'		=> esc_html__( 'Раскраска', 'daddytales' ),
				'add_new'			=> esc_html__( 'Добавить Новую', 'daddytales' ),
				'add_new_item'		=> esc_html__( 'Добавить Новую Раскраску', 'daddytales' ),
				'edit_item'			=> esc_html__( 'Редактировать Раскраску', 'daddytales' ),
				'new_item'			=> esc_html__( 'Новая Раскраска', 'daddytales' ),
				'view_item'			=> esc_html__( 'Посмотреть Раскраску', 'daddytales' ),
				'search_items'		=> esc_html__( 'Найти Раскраску', 'daddytales' ),
				'not_found'         => esc_html__( 'Раскраски не Найдены', 'daddytales' ),
				'not_found_in_trash'=> esc_html__( 'В Корзине Нет Раскрасок', 'daddytales' ),
				'parent_item_colon'	=> '',
				'menu_name'			=> esc_html__( 'Раскраски', 'daddytales' )
			],
			'menu_icon'				=> 'dashicons-admin-appearance',
			'public'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> false,
			'show_ui'				=> true,
			'show_in_menu'			=> true,
			'show_in_rest'			=> true,
			'query_var'				=> true,
			'rewrite'				=> ['slug' => 'coloring'],
			'capability_type'		=> 'post',
			'map_meta_cap'			=> true,
			'has_archive'			=> true,
			'hierarchical'			=> false,
			'menu_position'			=> 7,
			'supports'				=> ['title', 'editor', 'thumbnail', 'comments']
		]
	);

	// Slides Tales taxonomy.
	register_taxonomy(
		'slidestales',
		['slidestale'],
		[
			'label'                 => esc_html__( 'Категории Слайдов', 'daddytales' ),
			'labels'                => [
				'name'              => esc_html__( 'Категории Слайдов', 'daddytales' ),
				'singular_name'     => esc_html__( 'Категория Слайдов', 'daddytales' ),
				'search_items'      => esc_html__( 'Искать Категории Слайдов', 'daddytales' ),
				'all_items'         => esc_html__( 'Все Категории Слайдов', 'daddytales' ),
				'view_item '        => esc_html__( 'Показать Категории Слайдов', 'daddytales' ),
				'parent_item'       => esc_html__( 'Родительская Категория', 'daddytales' ),
				'parent_item_colon' => esc_html__( 'Родительская Категория:', 'daddytales' ),
				'edit_item'         => esc_html__( 'Редактировать Категорию', 'daddytales' ),
				'update_item'       => esc_html__( 'Обновить Категорию', 'daddytales' ),
				'add_new_item'      => esc_html__( 'Добавить Новую Категорию Слайдов', 'daddytales' ),
				'new_item_name'     => esc_html__( 'Новая Категория Слайдов', 'daddytales' ),
				'menu_name'         => esc_html__( 'Категории Слайдов', 'daddytales' ),
			],
			'description'           => '',
			'public'                => true,
			'publicly_queryable'    => true,
			'show_in_nav_menus'     => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_tagcloud'         => true,
			'show_in_quick_edit'    => true,
			'hierarchical'          => true,
			'rewrite'               => true,
			'capabilities'          => [],
			'show_admin_column'     => true,
			'show_in_rest'          => true
		]
	);
	// Slides Tale post type.
	register_post_type(
		'slidestale',
		[
			'labels'				=> [
				'name'				=> esc_html__( 'Слайды', 'daddytales' ),
				'singular_name'		=> esc_html__( 'Слайды', 'daddytales' ),
				'add_new'			=> esc_html__( 'Добавить Слайды', 'daddytales' ),
				'add_new_item'		=> esc_html__( 'Добавить Новые Слайды', 'daddytales' ),
				'edit_item'			=> esc_html__( 'Редактировать Слайды', 'daddytales' ),
				'new_item'			=> esc_html__( 'Новые Слайды', 'daddytales' ),
				'view_item'			=> esc_html__( 'Посмотреть Слайды', 'daddytales' ),
				'search_items'		=> esc_html__( 'Найти Слайды', 'daddytales' ),
				'not_found'         => esc_html__( 'Слайды не Найдены', 'daddytales' ),
				'not_found_in_trash'=> esc_html__( 'В Корзине Нет Слайдов', 'daddytales' ),
				'parent_item_colon'	=> '',
				'menu_name'			=> esc_html__( 'Сказки-слайды', 'daddytales' )
			],
			'menu_icon'				=> 'dashicons-images-alt2',
			'public'				=> true,
			'publicly_queryable'	=> true,
			'exclude_from_search'	=> false,
			'show_ui'				=> true,
			'show_in_menu'			=> true,
			'show_in_rest'			=> true,
			'query_var'				=> true,
			'rewrite'				=> ['slug' => 'slides'],
			'capability_type'		=> 'post',
			'map_meta_cap'			=> true,
			'has_archive'			=> true,
			'hierarchical'			=> false,
			'menu_position'			=> 7,
			'supports'				=> ['title', 'editor', 'thumbnail', 'comments']
		]
	);
}

/**
 * Get User avatar.
 *
 * @param	int		$user_id	- User ID.
 * @return	string	User avatar URL.
 */
function dt_get_user_avatar( $user_id ): string
{
	// User avatar - trying to get attachment ID from current User meta field.
	$user_avatar_url	= get_user_meta( $user_id, 'dt_avatar_image_id', true );
	$user_avatar_url	=  $user_avatar_url ? wp_get_attachment_image_url( $user_avatar_url, 'thumbnail' ) : '';

	// If fail - get standard gravatar url.
	if( ! $user_avatar_url ) return get_avatar_url( $user_id );
	return $user_avatar_url;
}

/**
 * Remove website URL field from comment form.
 */
add_filter( 'comment_form_default_fields', 'dt_unset_url_field_in_comment_form' );
function dt_unset_url_field_in_comment_form( $fields ){
    if( isset( $fields['url'] ) ) unset( $fields['url'] );
    return $fields;
}

/**
 * Comments restyling.
 */
function dt_theme_comments( $comment, $args, $depth ){
	$GLOBALS['comment']		= $comment;
	$comment_author_email	= $comment->comment_author_email;
	$comment_author			= get_user_by( 'email', $comment_author_email );

	// If such User exists.
	if( $comment_author ){
		$comment_author_name	= $comment_author->user_firstname;
		$comment_author_login	= $comment_author->user_login;
		$user_avatar_url		= dt_get_user_avatar( $comment_author->ID );
	}	else {	// User not exists.
		$comment_author_name	= $comment->comment_author;
		$comment_author_login	= '';
		$user_avatar_url = dt_get_user_avatar( null );
	}

	// echo var_dump( $comment );

	switch( $comment->comment_type ){
		case 'comment':
			?>
			<li <?php comment_class() ?> id="li-comment-<?php comment_ID() ?>">
				<div class="comment-avatar img-cover-inside">
					<?php
					if( $user_avatar_url ){
						?>
						<img class="avatar avatar-100 photo" src="<?php echo $user_avatar_url ?>" loading="lazy" width="100" height="100" alt="" />
						<?php
					}
					?>
				</div>

				<div id="comment-<?php comment_ID() ?>" class="comment-inner">
					<div class = "comment-author">
						<h4 class="comment-author__name">
							<?php
							if( $comment_author_login ) printf( esc_html( '%s (%s):'), $comment_author_name, $comment_author_login );
							else echo esc_html( $comment_author_name ), ':';
							?>
						</h4>
					</div>

					<div class="comment-data">
						<?php
						printf(
							esc_html__( '%1$s в %2$s' ),
							get_comment_date( 'd.m.Y' ),
							get_comment_time( 'h:i' )
						);
						?>
					</div>

					<?php
					if( $comment->comment_approved == '0' ){
						?>
						<div class="comment-awaiting-verification">
							<?php esc_html_e( 'Ваш комментарий на модерации.', 'daddytales' ) ?>
						</div>
						<?php
					}
					?>

					<div class="comment-text">
						<?php comment_text() ?>
					</div>

					<div class="reply">
						<?php
						if( ! is_user_logged_in() ){
							?>
							<a class="comment-reply-link" href="<?php echo get_permalink( 6706 ) ?>">
								<i class="fas fa-reply"></i>
								<?php esc_html_e( 'Войдите, чтобы ответить', 'daddytales' ) ?>
							</a>
							<?php
						}	else {
							comment_reply_link(
								array_merge( $args, [
									'depth'			=> $depth,
									'max_depth'		=> $args['max_depth'],
									'reply_text'	=> esc_html__( 'Ответить', 'daddytales' ),
									'before'		=> '<i class="fas fa-reply"></i>'
								] )
							);
						}
						?>
					</div><!-- .reply -->
				</div><!-- .comment-inner -->
			<?php
			break;

		case 'pingback':
		case 'trackback':
			?>
			<li class="post pingback">
				<?php
				comment_author_link();
				edit_comment_link( esc_html__( 'Редактировать', 'daddytales' ), ' ' );
			break;
	}
}

/**
 * Function adds previous and next posts navigation
 * in the end of the content of single post.
 */
add_filter( 'the_content', 'dt_show_prev_next_posts' );
function dt_show_prev_next_posts( $content ){
	$prev_post	= get_previous_post();
	$next_post	= get_next_post();

	// If at least one of side posts exists.
	if( ! empty( $prev_post ) || ! empty( $next_post ) ){
		$html = '<nav class="nav-single">';

		// If previous post exists.
		if( ! empty( $prev_post ) ){
			$prev_post_id		= $prev_post->ID;
			$prev_post_link		= get_permalink( $prev_post_id );
			$prev_post_thumb	= has_post_thumbnail( $prev_post_id )
								? '<div class="nav-single__img">' . get_the_post_thumbnail( $prev_post_id, 'thumbnail' ) . '</div>'
								: '';
			$html .= '<div class="nav-single__prev">
				<a href="' . $prev_post_link . '">
					<span>' . esc_html__( 'Предыдущая запись', 'daddytales' ) . '</span>
					' . $prev_post->post_title . $prev_post_thumb . '
				</a>
			</div>';
		}

		// If next post exists.
		if( ! empty( $next_post ) ){
			$next_post_id		= $next_post->ID;
			$next_post_link		= get_permalink( $next_post_id );
			$next_post_thumb	= has_post_thumbnail( $next_post_id )
								? '<div class="nav-single__img">' . get_the_post_thumbnail( $next_post_id, 'thumbnail' ) . '</div>'
								: '';
			$html .= '<div class="nav-single__next">
				<a href="' . $next_post_link . '">
					<span>' . esc_html__( 'Следующая запись', 'daddytales' ) . '</span>
					' . $next_post->post_title . $next_post_thumb . '
				</a>
			</div>';
		}

		$html .= '</nav>';

		$content .= $html;
	}

	return $content . ( shortcode_exists( 'addtoany' ) ? do_shortcode( '[addtoany]' ) : '' );
}

