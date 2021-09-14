<?php
/**
 * Main Footer Settings in theme Customizer.
 */
$options[] = [
	'section_footer' => [
		'title' => esc_html__( 'Footer Settings', 'daddytales' ),
		'wp-customizer-args' => [
			'priority' => 2
		],
		'options' => [
			'group_footer' => [
				'type'     => 'box',
				'title'    => esc_html__( 'Copyright', 'daddytales' ),
				'options'  => [
					'footer_copyrights'	=> [
						'type'  		=> 'wp-editor',
						'label' 		=> esc_html__( 'Copyright Text', 'daddytales' ),
						'desc'  		=> esc_html__( 'Please, enter text.', 'daddytales' ),
						'size'			=> 'small',
						'editor_height'	=> 100,
						'wpautop'		=> true,
						'editor_type'	=> false,
						'shortcodes'	=> false
					]
				]
			],

			'footer_cta'	=> [
				'type'		=> 'box',
				'title'		=> esc_html__( 'Footer CTA', 'daddytales' ),
				'options'	=> [
					'footer_cta_text_size'	=> [
						'type'		=> 'radio',
						'value'		=> 'large',
						'label'		=> esc_html__( 'Text Size', 'daddytales' ),
						'choices'	=> [
							'large'	=> esc_html__( 'Large', 'daddytales' ),
							'small'	=> esc_html__( 'Small', 'daddytales' )
						],
						'inline'	=> true
					],

					'footer_cta_title'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Title', 'daddytales' )
					],

					'footer_cta_desc'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Description', 'daddytales' )
					],

					'footer_cta_button_text'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Button Text', 'daddytales' )
					],

					'footer_cta_button_url'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Button URL', 'daddytales' )
					],

					'footer_cta_button_target'	=> [
						'type'	=> 'checkbox',
						'label'	=> esc_html__( 'Open in a New Tab', 'daddytales' ),
						'value'	=> false,
						'text'	=> esc_html__( 'Yes', 'daddytales' )
					],

					'footer_cta_alt_view'  => [
						'type'			=> 'select',
						'label'			=> esc_html__( 'Alt View If User is Logged In', 'daddytales' ),
						'choices'		=> [
							'leave'				=> esc_html__( 'Leave the Same View', 'daddytales' ),
							'hide'				=> esc_html__( 'Hide', 'daddytales' ),
							'show_alt_content'	=> esc_html__( 'Show User Greetings', 'daddytales' )
						],
						'no-validate'	=> false
					]
				]
			]
		]
	]
];

