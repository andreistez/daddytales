<?php
if( !defined( 'FW' ) ) die( 'Forbidden' );

$options = [
	'taxonomy'  => [
		'type'	=> 'multi-picker',
		'label'	=> false,
		'desc'	=> false,
		'value'	=> [
			'choice'	=> 'category'
		],

		'picker'    => [
			'choice'    => [
				'type'      => 'select',
				'label'     => esc_html__( 'Taxonomy Type', 'daddytales' ),
				'choices'   => [
					'category'	=> esc_html__( 'Category', 'daddytales' ),
					'songs'		=> esc_html__( 'Songs', 'daddytales' )
				]
			]
		],

		'choices'   => [
			'category'	=> [
				'terms'	=> [
					'type'			=> 'multi-select',
					'label'			=> esc_html__( 'Category', 'daddytales' ),
					'population'	=> 'taxonomy',
					'source'		=> 'category',
					'prepopulate'	=> false,
					'limit'			=> 1
				]
			],

			'songs'		=> [
				'terms'	=> [
					'type'			=> 'multi-select',
					'label'			=> esc_html__( 'Songs', 'daddytales' ),
					'population'	=> 'taxonomy',
					'source'		=> 'songs',
					'prepopulate'	=> false,
					'limit'			=> 1
				]
			]
		],
		'show_borders'  => false
	],

	'posts_count'	=> [
		'type'	=> 'text',
		'label'	=> esc_html__( 'Posts Count', 'daddytales' )
	]
];

