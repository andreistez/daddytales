<?php
/**
 * Common Settings in theme Customizer.
 */
$options[] = [
    'section_common' => [
        'title' => esc_html__( 'Common Settings', 'daddytales' ),
        'wp-customizer-args' => [
            'priority' => 1
        ],

        'options' => [
			'x_api_key' => [
				'type'	=> 'text',
				'label'	=> esc_html__( 'X-API-KEY', 'daddytales' ),
				'desc'	=> esc_html__( 'Please, paste your key here.', 'daddytales' )
			]
        ]
    ]
];