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
			]
		]
	]
];

