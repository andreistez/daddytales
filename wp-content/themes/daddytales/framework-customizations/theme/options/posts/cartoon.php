<?php
if( !defined( 'FW' ) ) die( 'Forbidden' );

$options = [
	'box_cartoon'	=> [
		'type'		=> 'box',
		'title'		=> esc_html__( 'Дополнительные поля мультфильмов', 'daddytales' ),
		'options'	=> [
			'tab_main'	=> [
				'type'		=> 'tab',
				'title'		=> esc_html__( 'Основная информация', 'daddytales' ),
				'options'	=> [
					'kinopoisk_id'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'ID на kinopoisk.ru', 'daddytales' )
					]
				]
			],

			'tab_auto'	=> [
				'type'		=> 'tab',
				'title'		=> esc_html__( 'Автоматически генерируемая информация', 'daddytales' ),
				'options'	=> [
					'original_name'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Название оригинала', 'daddytales' )
					],

					'year'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Год', 'daddytales' )
					],

					'length'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Продолжительность (мин)', 'daddytales' )
					],

					'kp_rating'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Рейтинг kinopoisk.ru', 'daddytales' )
					],

					'kp_voices'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Проголосовало на kinopoisk.ru', 'daddytales' )
					],

					'imdb_rating'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Рейтинг IMDB', 'daddytales' )
					],

					'imdb_voices'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Проголосовало на IMDB', 'daddytales' )
					],

					'description'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Описание', 'daddytales' )
					],

					'age_limit'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Возрастные ограничения', 'daddytales' )
					],

					'countries'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Страны', 'daddytales' )
					],

					'genres'	=> [
						'type'	=> 'text',
						'label'	=> esc_html__( 'Жанры', 'daddytales' )
					],

					'frames'	=> [
						'type'	=> 'textarea',
						'label'	=> esc_html__( 'Кадры', 'daddytales' )
					]
				]
			]
		]
	]
];

