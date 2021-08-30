<?php
if( ! defined( 'FW' ) ) die( 'Forbidden' );

if( ! $title = $atts['title'] ) return;

$margin_left = $atts['margin_left'] ? $atts['margin_left'] . '%' : '5%';
?>

<div class="cwp-title">
	<h2 class="cwp-title__text" style="margin-left: <?php echo esc_attr( $margin_left ) ?>">
		<?php printf( esc_html__( '%s', 'daddytales' ), $title ) ?>
	</h2>
</div><!-- .latest-col -->

