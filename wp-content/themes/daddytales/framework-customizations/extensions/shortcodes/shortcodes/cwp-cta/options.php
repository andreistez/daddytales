<?php
if( !defined( 'FW' ) ) die( 'Forbidden' );

$options = [
	'text_size'=> [
		'type'		=> 'radio',
		'value'		=> 'large',
		'label'		=> esc_html__( 'Text Size', 'daddytales' ),
		'choices'	=> [
			'large'	=> esc_html__( 'Large', 'daddytales' ),
			'small'	=> esc_html__( 'Small', 'daddytales' )
		],
		'inline'	=> true
	],

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
	],

	'alt_view'  => [
		'type'			=> 'select',
		'label'			=> esc_html__( 'Alt View If User is Logged In', 'daddytales' ),
		'choices'		=> [
			'leave'				=> esc_html__( 'Leave the Same View', 'daddytales' ),
			'hide'				=> esc_html__( 'Hide', 'daddytales' ),
			'show_alt_content'	=> esc_html__( 'Show User Greetings', 'daddytales' )
		],
		'no-validate'	=> false
	]
];