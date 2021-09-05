<?php
if( !defined( 'FW' ) ) die( 'Forbidden' );

$options = [
	'title'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Title', 'daddytales' )
	],

	'margin_left'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Margin Left (%)', 'daddytales' )
	]
];