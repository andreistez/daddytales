<?php
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

	if( 'wp-login.php' === $pagenow && ! current_user_can( 'administrator' ) ){
		wp_redirect( get_the_permalink( 6736 ) );
		exit;
	}

	if(
		is_admin()
		&& ! current_user_can( 'administrator' )
		&& ! ( defined( 'DOING_AJAX' ) && DOING_AJAX )
	){
		wp_redirect( get_the_permalink( 6736 ) );
		exit;
	}
}

/**
 * Catches all failed logins and redirect them.
 */
add_action( 'wp_login_failed', 'dt_login_failed', 10, 1 );
function dt_login_failed( $username ){
    wp_redirect( get_the_permalink( 6736 ), 302 );
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
function set_html_content_type(){
	return 'text/html';
}

