<?php
if ( !defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = [
	'title'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Title', 'daddytales' )
	],

	'desc'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Description', 'daddytales' )
	],

	'button_box'	=> [
		'type'		=> 'box',
		'title'		=> esc_html__( 'Button', 'daddytales' ),
        'options'	=> [
			'button_text'	=> [
				'type'	=> 'text',
				'label'	=> esc_html__( 'Button Text', 'daddytales' )
			],

			'button_url'	=> [
				'type'	=> 'text',
				'label'	=> esc_html__( 'Button URL', 'daddytales' )
			],

			'button_target'	=> [
				'type'	=> 'checkbox',
				'label'	=> esc_html__( 'Open in a New Tab', 'daddytales' ),
				'value'	=> false,
				'text'	=> esc_html__( 'Yes', 'daddytales' )
			]
		]
	]
];