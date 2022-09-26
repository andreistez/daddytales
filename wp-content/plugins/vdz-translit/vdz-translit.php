<?php
/*
Plugin Name: VDZ Translit Plugin (SEO permalinks)
Plugin URI:  http://online-services.org.ua
Description: Simple ukrainian and russian translit for post/page title and uploaded files.
Version:     1.3.21
Author:      VadimZ
Author URI:  http://online-services.org.ua#vdz-translit
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

define( 'VDZ_TRANSLIT_API', 'vdz_info_translit' );

require_once 'api.php';
require_once 'updated_plugin_admin_notices.php';

function vdz_translit( $string ) {

	$chars_arr = array(
		'а'     => 'a',
		'б'     => 'b',
		'в'     => 'v',
		'г'     => 'g',
		'ґ'     => 'g',
		'д'     => 'd',
		'е'     => 'e',
		'ё'     => 'e',
		'э'     => 'e',
		'є'     => 'ie',
		'ж'     => 'zh',
		'з'     => 'z',
		'и'     => 'i',
		'ы'     => 'y',
		'і'     => 'i',
		'ї'     => 'i',
		'й'     => 'i',
		'к'     => 'k',
		'л'     => 'l',
		'м'     => 'm',
		'н'     => 'n',
		'о'     => 'o',
		'п'     => 'p',
		'р'     => 'r',
		'с'     => 's',
		'т'     => 't',
		'у'     => 'u',
		'ф'     => 'f',
		'х'     => 'kh',
		'ц'     => 'ts',
		'ч'     => 'ch',
		'ш'     => 'sh',
		'щ'     => 'shch',
		'ю'     => 'iu',
		'я'     => 'ya',

		'ь'     => '',
		'Ь'     => '',
		'ъ'     => '',
		'Ъ'     => '',
		'!'     => '',
		'?'     => '',
		':'     => '',
		';'     => '',
		'’'     => '',
		"'"     => '',
		'—'     => '',
		'--'    => '',
		// "-" => "", //Allow in file & title
		// "." => "", //Allow in file & title

			'@' => '',
		'#'     => '',
		'#'     => '',
		'^'     => '',
		'*'     => '',
		'('     => '',
		')'     => '',
		// "_" => "", //Allow in a widgets panel
		'='     => '',
		'+'     => '',

		'₴'     => 'uah',
		'€'     => 'eur',
		'$'     => 'usd',
		'%'     => 'protsent',

		'à'     => 'a',
		'ô'     => 'o',
		'ď'     => 'd',
		'ḟ'     => 'f',
		'ë'     => 'e',
		'š'     => 's',
		'ơ'     => 'o',
		'ß'     => 'ss',
		'ă'     => 'a',
		'ř'     => 'r',
		'ț'     => 't',
		'ň'     => 'n',
		'ā'     => 'a',
		'ķ'     => 'k',
		'ŝ'     => 's',
		'ỳ'     => 'y',
		'ņ'     => 'n',
		'ĺ'     => 'l',
		'ħ'     => 'h',
		'ṗ'     => 'p',
		'ó'     => 'o',
		'ú'     => 'u',
		'ě'     => 'e',
		'é'     => 'e',
		'ç'     => 'c',
		'ẁ'     => 'w',
		'ċ'     => 'c',
		'õ'     => 'o',
		'ṡ'     => 's',
		'ø'     => 'o',
		'ģ'     => 'g',
		'ŧ'     => 't',
		'ș'     => 's',
		'ė'     => 'e',
		'ĉ'     => 'c',
		'ś'     => 's',
		'î'     => 'i',
		'ű'     => 'u',
		'ć'     => 'c',
		'ę'     => 'e',
		'ŵ'     => 'w',
		'ṫ'     => 't',
		'ū'     => 'u',
		'č'     => 'c',
		'ö'     => 'oe',
		'è'     => 'e',
		'ŷ'     => 'y',
		'ą'     => 'a',
		'ł'     => 'l',
		'ų'     => 'u',
		'ů'     => 'u',
		'ş'     => 's',
		'ğ'     => 'g',
		'ļ'     => 'l',
		'ƒ'     => 'f',
		'ž'     => 'z',
		'ẃ'     => 'w',
		'ḃ'     => 'b',
		'å'     => 'a',
		'ì'     => 'i',
		'ï'     => 'i',
		'ḋ'     => 'd',
		'ť'     => 't',
		'ŗ'     => 'r',
		'ä'     => 'ae',
		'í'     => 'i',
		'ŕ'     => 'r',
		'ê'     => 'e',
		'ü'     => 'ue',
		'ò'     => 'o',
		'ē'     => 'e',
		'ñ'     => 'n',
		'ń'     => 'n',
		'ĥ'     => 'h',
		'ĝ'     => 'g',
		'đ'     => 'd',
		'ĵ'     => 'j',
		'ÿ'     => 'y',
		'ũ'     => 'u',
		'ŭ'     => 'u',
		'ư'     => 'u',
		'ţ'     => 't',
		'ý'     => 'y',
		'ő'     => 'o',
		'â'     => 'a',
		'ľ'     => 'l',
		'ẅ'     => 'w',
		'ż'     => 'z',
		'ī'     => 'i',
		'ã'     => 'a',
		'ġ'     => 'g',
		'ṁ'     => 'm',
		'ō'     => 'o',
		'ĩ'     => 'i',
		'ù'     => 'u',
		'į'     => 'i',
		'ź'     => 'z',
		'á'     => 'a',
		'û'     => 'u',
		'þ'     => 'th',
		'ð'     => 'dh',
		'æ'     => 'ae',
		'µ'     => 'u',
		'ĕ'     => 'e',
		'œ'     => 'oe',
	);

	if ( function_exists( 'mb_strtolower' ) ) {
		$translit_string = mb_strtolower( urldecode( $string ), 'UTF-8' );
	} else {
		$translit_string = '';
		// Деактивируем плагин
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( 'Please Install/enable the mbstring extension http://php.net/manual/en/mbstring.installation.php' );
	}

	$translit_string = str_replace( array_keys( $chars_arr ), array_values( $chars_arr ), $translit_string );

	// Отсекаем лишние символы которые не указали в массиве
	$translit_string = preg_replace( '/[^a-zA-Z0-9-_\.]/i', '', $translit_string );

	return $translit_string;
}

add_filter( 'sanitize_file_name', 'vdz_translit' );
add_filter( 'sanitize_title', 'vdz_translit' );

// Код активации плагина
register_activation_hook(
	__FILE__,
	function () {
		global $wp_version;

		if ( version_compare( $wp_version, '3.8', '<' ) || ! function_exists( 'mb_strtolower' ) ) {
			// Деактивируем плагин
			deactivate_plugins( plugin_basename( __FILE__ ) );
			wp_die( 'This plugin required WordPress version 3.8 or higher. And please install/enable the mbstring extension http://php.net/manual/en/mbstring.installation.php' );
		}

		do_action( VDZ_TRANSLIT_API, 'on', plugin_basename( __FILE__ ) );
	}
);

// Код деактивации плагина
register_deactivation_hook( __FILE__, function () {
	$plugin_name = preg_replace( '|\/(.*)|', '', plugin_basename( __FILE__ ));
	$response = wp_remote_get( "http://api.online-services.org.ua/off/{$plugin_name}" );
	if ( ! is_wp_error( $response ) && isset( $response['body'] ) && ( json_decode( $response['body'] ) !== null ) ) {
		//TODO Вывод сообщения для пользователя
	}
} );
//Сообщение при отключении плагина
add_action( 'admin_init', function (){
	if(is_admin()){
		$plugin_data = get_plugin_data(__FILE__);
		$plugin_name = isset($plugin_data['Name']) ? $plugin_data['Name'] : ' us';
		$plugin_dir_name = preg_replace( '|\/(.*)|', '', plugin_basename( __FILE__ ));
		$handle = 'admin_'.$plugin_dir_name;
		wp_register_script( $handle, '', null, false, true );
		wp_enqueue_script( $handle );
		$msg = '';
		if ( function_exists( 'get_locale' ) && in_array( get_locale(), array( 'uk', 'ru_RU' ), true ) ) {
			$msg .= "Спасибо, что были с нами! ({$plugin_name}) Хорошего дня!";
		}else{
			$msg .= "Thanks for your time with us! ({$plugin_name}) Have a nice day!";
		}
		wp_add_inline_script( $handle, "document.getElementById('deactivate-".esc_attr($plugin_dir_name)."').onclick=function (e){alert('".esc_attr( $msg )."');}" );
	}
} );


