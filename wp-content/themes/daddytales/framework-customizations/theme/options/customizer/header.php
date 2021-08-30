<?php
/**
 * Main Header Settings in theme Customizer.
 */
$options[] = [
    'section_header' => [
        'title' => esc_html__( 'Header Settings', 'daddytales' ),
        'wp-customizer-args' => [
            'priority' => 1
        ],

        'options' => [
            'group_logo' => [
				'type'     => 'box',
				'title'    => esc_html__( 'Logo', 'daddytales' ),
				'options'  => [
					'header_logo' => [
						'type'          => 'upload',
						'label'         => esc_html__( 'Logo Image', 'daddytales' ),
						'desc'          => esc_html__( 'Please, upload image.', 'daddytales' ),
						'images_only'   => true
					]
				]
			],

			'group_search' => [
				'type'     => 'box',
				'title'    => esc_html__( 'Search', 'daddytales' ),
				'options'  => [
					'search_placeholders' => [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Search Placeholder Variations', 'daddytales' ),
						'desc'	=> esc_html__( 'Please, enter variations separated by pipes.', 'daddytales' )
					]
				]
			]
        ]
    ]
];