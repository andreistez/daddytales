<?php
if( !defined( 'FW' ) ) die( 'Forbidden' );

$options = [
	'box_slides'	=> [
		'type'		=> 'box',
		'title'		=> esc_html__( 'Дополнительные поля Сказок-слайдов', 'daddytales' ),
		'options'	=> [
			'tab_slides'	=> [
				'type'		=> 'tab',
				'title'		=> esc_html__( 'Слайдер сказки', 'daddytales' ),
				'options'	=> [
					'slider'	=> [
						'type'				=> 'addable-box',
						'label'				=> esc_html__( 'Слайды', 'daddytales' ),
						'box-options'		=> [
							'image'	=> [
								'type'			=> 'upload',
								'label'			=> esc_html__( 'Изображение', 'daddytales' ),
								'images_only'	=> true
							],

							'text'	=> [
								'type'			=> 'wp-editor',
								'label'			=> esc_html__( 'Текст', 'daddytales' ),
								'size'			=> 'small',
								'wpautop'		=> true,
								'editor_type'	=> false,
								'shortcodes'	=> false
							]
						],
						'template'			=> esc_html__( 'Слайд', 'daddytales' ),
						'limit'				=> 0,
						'add-button-text'	=> esc_html__( 'Добавить слайд', 'daddytales'),
						'sortable'			=> true
					]
				]
			]
		]
	]
];

