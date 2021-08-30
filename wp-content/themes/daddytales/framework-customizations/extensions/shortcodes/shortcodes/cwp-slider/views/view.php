<?php
if( ! defined( 'FW' ) ) die( 'Forbidden' );

$type_of_slider = $atts['type_of_slider'];
?>

<div class="cwp-slider-wrapper">
	<div class="cwp-slider-title">Мультфильмы</div>
	<div class = "cwp-slider">
		<?php
		if( $type_of_slider['choice'] === 'auto' ){
			$posts_count = $type_of_slider['auto']['posts_count'] ?? 20;
			$slider_query = new WP_Query(
				[
					'post_type'			=> 'post',
					'cat'				=> 6,
					'post_status'		=> 'publish',
					'posts_per_page'	=> $posts_count
				]
			);

			if( $slider_query->have_posts() ){
				while( $slider_query->have_posts() ){
					$slider_query->the_post();
					$post_id = get_the_ID();

					if( ! $post_id ) continue;

					get_template_part( 'includes/single/slider', 'preview', ['post_id' => $post_id] );
				}
			}
		}	else {
			$slides = $type_of_slider['manual']['slides'];

			if( empty( $slides ) ) return;

			foreach( $slides as $slide ){
				echo get_the_title( $slide );
			}
		}
		?>
	</div><!-- .cwp-slider -->
</div>

