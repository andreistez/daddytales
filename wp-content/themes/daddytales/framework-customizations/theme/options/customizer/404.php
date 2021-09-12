<?php
/**
 * Main Header Settings in theme Customizer.
 */
$options[] = [
	'section_404'	=> [
		'title'					=> esc_html__( '404 Settings', 'daddytales' ),
		'wp-customizer-args'	=> [
			'priority'	=> 3
		],

		'options'	=> [
			'image_404'	=> [
				'type'          => 'upload',
				'label'         => esc_html__( 'Image 404', 'daddytales' ),
				'desc'          => esc_html__( 'Please, upload image.', 'daddytales' ),
				'images_only'   => true
			],

			'title_404'	=> [
				'type'	=> 'text',
				'label'	=> esc_html__( 'Title 404', 'daddytales' ),
				'desc'	=> esc_html__( 'Please, enter text.', 'daddytales' )
			],

			'desc_404'	=> [
				'type'			=> 'wp-editor',
				'label'			=> esc_html__( 'Description 404', 'daddytales' ),
				'desc'			=> esc_html__( 'Please, enter text.', 'daddytales' ),
				'size'			=> 'small',
				'editor_height'	=> 150,
				'wpautop'		=> true,
				'editor_type'	=> false,
				'shortcodes'	=> false
			]
		]
	]
];

