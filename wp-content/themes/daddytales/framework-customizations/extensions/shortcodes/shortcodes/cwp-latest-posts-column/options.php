<?php
if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = [
	'category'	=> [
		'type'			=> 'multi-select',
		'label'			=> esc_html__( 'Category', 'daddytales' ),
		'population'	=> 'taxonomy',
		'source'		=> 'category',
		'prepopulate'	=> 999,
		'limit'			=> 1
	],

	'posts_count'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Posts Count', 'daddytales' )
	]
];