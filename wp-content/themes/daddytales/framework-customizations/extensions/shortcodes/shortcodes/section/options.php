<?php
if( !defined( 'FW' ) ) die( 'Forbidden' );

$options = [
	'class_name'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Class Name', 'daddytales' )
	],

	'is_fullwidth'	=> [
		'label'	=> esc_html__( 'Full Width', 'daddytales' ),
		'type'	=> 'switch'
	],

	'background_color'	=> [
		'label'	=> esc_html__( 'Background Color', 'daddytales' ),
		'type'	=> 'color-picker'
	],

	'bg_image'	=> [
		'type'			=> 'upload',
		'label'			=> esc_html__( 'Background Image', 'daddytales' ),
		'images_only'	=> true
	],

	'gradient_box'	=> [
		'type'		=> 'box',
		'title'		=> esc_html__( 'Gradient', 'daddytales' ),
        'options'	=> [
			'gradient_start'	=> [
				'type'	=> 'color-picker',
				'label'	=> esc_html__( 'Gradient Start Color', 'daddytales' )
			],

			'gradient_end'		=> [
				'type'	=> 'color-picker',
				'label'	=> esc_html__( 'Gradient End Color', 'daddytales' )
			],

			'gradient_degrees'	=> [
				'type'	=> 'text',
				'label'	=> esc_html__( 'Gradient Degrees (number only)', 'daddytales' )
			]
		]
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
	],

	'margin_top'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Margin Top (px)', 'daddytales' ),
		'desc'	=> esc_html__( 'Please, enter top margin value in pixels.', 'daddytales' )
	],

	'margin_bottom'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Margin Bottom (px)', 'daddytales' ),
		'desc'	=> esc_html__( 'Please, enter bottom margin value in pixels.', 'daddytales' )
	]
];

