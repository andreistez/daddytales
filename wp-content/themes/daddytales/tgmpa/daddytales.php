<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Daddytales
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

require_once get_template_directory() . '/tgmpa/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'daddytales_register_required_plugins' );
function daddytales_register_required_plugins() {
	$plugins = [
		[
			'name'		=> 'Unyson Framework Plugin',
			'slug'		=> 'unyson-framework-plugin',
			'source'	=> 'http://downloads.wordpress.org/plugin/unyson.zip',
			'required'	=> true
		]
	];

	$config = [
		'id'			=> 'daddytales',
		'default_path'	=> '',
		'menu'			=> 'tgmpa-install-plugins',
		'parent_slug'	=> 'themes.php',
		'capability'	=> 'edit_theme_options',
		'has_notices'	=> true,
		'dismissable'	=> true,
		'dismiss_msg'	=> '',
		'is_automatic'	=> false,
		'message'		=> ''
	];

	tgmpa( $plugins, $config );
}
