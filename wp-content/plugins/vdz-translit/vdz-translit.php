<?php
/*
Plugin Name: VDZ Translit Plugin (SEO permalinks)
Plugin URI:  http://online-services.org.ua
Description: Simple ukrainian and russian translit for post/page title and uploaded files.
Version:     1.3.14
Author:      VadimZ
Author URI:  http://online-services.org.ua#vdz-translit
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/


define( 'VDZ_TRANSLIT_API', 'vdz_info_translit' );

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

require_once 'api.php';
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
register_deactivation_hook(
	__FILE__,
	function () {
		// do_action(VDZ_TRANSLIT_API, 'off', plugin_basename(__FILE__));
	}
);




/**
 * This function runs when WordPress completes its upgrade process
 * It iterates through each plugin updated to see if ours is included
 *
 * @param $upgrader_object Array
 * @param $options Array
 */
add_action(
	'upgrader_process_complete',
	function ( $upgrader_object, $options ) {
		// The path to our plugin's main file
		$our_plugin = plugin_basename( __FILE__ );
		// If an update has taken place and the updated type is plugins and the plugins element exists
		if ( 'update' === $options['action'] && 'plugin' === $options['type'] && isset( $options['plugins'] ) ) {
			// Iterate through the plugins being updated and check if ours is there
			foreach ( $options['plugins'] as $plugin ) {
				if ( $plugin === $our_plugin ) {
					// Set a transient to record that our plugin has just been updated
					set_transient( 'vdz_api_updated' . plugin_basename( __FILE__ ), 1 );
				}
			}
		}
	},
	10,
	2
);

/**
 * Show a notice to anyone who has just updated this plugin
 * This notice shouldn't display to anyone who has just installed the plugin for the first time
 */
add_action(
	'admin_notices',
	function () {
		// Check the transient to see if we've just updated the plugin
		if ( get_transient( 'vdz_api_updated' . plugin_basename( __FILE__ ) ) ) {

			if ( function_exists( 'get_locale' ) && in_array( get_locale(), array( 'uk', 'ru_RU' ), true ) ) {
				echo '<div class="notice notice-success">
					<h4>Поздравляю! Обновление успешно завершено! </h4>
					<h3><a target="_blank" href="https://wordpress.org/support/plugin/vdz-translit/reviews/?rate=5#new-post">Скажи спасибо и проголосуй (5 звезд) </a> - Мне будет приятно и я пойму, что все делаю правильно</h3>
				  </div>';
			} else {
				echo '<div class="notice notice-success">
					<h4>Congratulations! Update completed successfully!</h4>
					<h3><a target="_blank" href="https://wordpress.org/support/plugin/vdz-translit/reviews/?rate=5#new-post">Say thanks and vote (5 stars)</a> - I will be glad and understand that doing everything right</h3>
				  </div>';
			}

			delete_transient( 'vdz_api_updated' . plugin_basename( __FILE__ ) );
		}
	}
);
