<?php
if( !defined( 'FW' ) ) die( 'Forbidden' );

$options = [
	'type_of_slider'  => [
		'type'  => 'multi-picker',
		'label' => false,
		'desc'  => false,
		'value' => [
			'choice'	=> 'auto'
		],

		'picker'    => [
			'choice'    => [
				'type'      => 'select',
				'label'     => esc_html__( 'Slider Type', 'daddytales' ),
				'choices'   => [
					'auto'		=> esc_html__( 'Auto Fill (Last Posts)', 'daddytales' ),
					'manual'	=> esc_html__( 'Manual Fill', 'daddytales' )
				]
			]
		],

		'choices'   => [
			'auto'		=> [
				'posts_count'	=> [
					'type'	=> 'text',
					'label'	=> esc_html__( 'Posts Count', 'daddytales' )
				]
			],

			'manual'	=> [
				'slides' => [
					'type'  			=> 'addable-box',
					'label' 			=> esc_html__( 'Slides', 'daddytales' ),
					'box-options'		=> [
						'slide'	=> [
							'type'			=> 'multi-select',
							'label'			=> esc_html__( 'Post for Slide', 'daddytales' ),
							'population'	=> 'posts',
							'source'		=> 'cartoon',
							'prepopulate'	=> 10,
							'limit'			=> 1
						]
					],
					'template'			=> 'Slide',
					'limit'				=> 0,
					'add-button-text'	=> esc_html__( 'Add Slide', 'daddytales' ),
					'sortable'			=> true
				]
			]
		],
		'show_borders'  => false
	]
];