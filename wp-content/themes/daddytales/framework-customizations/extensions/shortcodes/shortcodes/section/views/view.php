<?php
if( ! defined( 'FW' ) ) die( 'Forbidden' );

$class = $atts['class_name'] ? ' ' . $atts['class_name'] : '';

$bg_color = '';
if ( ! empty( $atts['background_color'] ) ) {
	$bg_color = 'background-color:' . $atts['background_color'] . ';';
}	else {
	$bg_color = 'background-color:#fff;';
}

$padding_top	= ( isset( $atts['padding_top'] ) && $atts['padding_top'] )
				? $atts['padding_top'] : 0;
$padding_bottom	= ( isset( $atts['padding_bottom'] ) && $atts['padding_bottom'] )
				? $atts['padding_bottom'] : 0;
$padding		= 'padding:' . esc_attr( $padding_top ) . 'px 0 ' . esc_attr( $padding_bottom ) . 'px;';

$section_style   = $bg_color ? 'style="' . $padding . esc_attr( $bg_color ) . '"' : '';
$container_class = ( isset( $atts['is_fullwidth'] ) && $atts['is_fullwidth'] ) ? 'fw-container-fluid' : 'fw-container';
?>
<section class = "fw-main-row<?php echo esc_attr( $class ) ?>" <?php echo $section_style ?>>
	<div class = "<?php echo esc_attr( $container_class ) ?>">
		<?php echo do_shortcode( $content ) ?>
	</div>
</section>
