<?php
if( !defined( 'FW' ) ) die( 'Forbidden' );

$options = [
	'class_name'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Class Name', 'daddytales' )
	],

	'is_fullwidth'	=> [
		'label'	=> __( 'Full Width', 'fw' ),
		'type'	=> 'switch'
	],

	'background_color'	=> [
		'label'	=> __( 'Background Color', 'fw' ),
		'desc'	=> __( 'Please select the background color', 'fw' ),
		'type'	=> 'color-picker'
	],

	'padding_top'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Padding Top (px)', 'daddytales' ),
		'desc'	=> esc_html__( 'Please, enter top padding value in pixels.', 'daddytales' )
	],

	'padding_bottom'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Padding Bottom (px)', 'daddytales' ),
		'desc'	=> esc_html__( 'Please, enter bottom padding value in pixels.', 'daddytales' )
	]
];

