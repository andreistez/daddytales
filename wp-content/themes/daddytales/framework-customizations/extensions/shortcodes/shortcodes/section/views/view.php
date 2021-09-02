<?php
if( ! defined( 'FW' ) ) die( 'Forbidden' );

$class = $atts['class_name'] ? ' ' . $atts['class_name'] : '';

$bg_color = '';
if ( ! empty( $atts['background_color'] ) ) {
	$bg_color = 'background-color:' . $atts['background_color'] . ';';
}	else {
	$bg_color = 'background-color:#fff;';
}

$bg_image		= $atts['bg_image'];
$gradient_deg	= $atts['gradient_degrees'] ?? 90;
$gradient		= ( $atts['gradient_start'] && $atts['gradient_end'] )
				? 'background: linear-gradient(' . esc_attr( $gradient_deg ) . 'deg, ' . esc_attr( $atts['gradient_start'] ) . ', ' . esc_attr( $atts['gradient_end'] ) . ');'
				: '';
$padding_top	= ( isset( $atts['padding_top'] ) && $atts['padding_top'] )
				? $atts['padding_top'] : 0;
$padding_bottom	= ( isset( $atts['padding_bottom'] ) && $atts['padding_bottom'] )
				? $atts['padding_bottom'] : 0;
$padding		= 'padding:' . esc_attr( $padding_top ) . 'px 0 ' . esc_attr( $padding_bottom ) . 'px;';

$margin_top		= ( isset( $atts['margin_top'] ) && $atts['margin_top'] )
				? $atts['margin_top'] : 0;
$margin_bottom	= ( isset( $atts['margin_bottom'] ) && $atts['margin_bottom'] )
				? $atts['margin_bottom'] : 0;
$margin			= 'margin:' . esc_attr( $margin_top ) . 'px 0 ' . esc_attr( $margin_bottom ) . 'px;';

$section_style	= $bg_color ? 'style="' . esc_attr( $bg_color ) . $gradient . $padding . $margin . '"' : '';
$container_class = ( isset( $atts['is_fullwidth'] ) && $atts['is_fullwidth'] ) ? 'fw-container-fluid' : 'fw-container';
?>
<section class = "fw-main-row<?php echo esc_attr( $class ) ?>" <?php echo $section_style ?>>
	<?php
	if( $bg_image ){
		?>
		<div class="section-bg-img img-cover-inside">
			<?php echo wp_get_attachment_image( $bg_image['attachment_id'], 'full' ) ?>
		</div>
		<?php
	}
	?>
	<div class = "<?php echo esc_attr( $container_class ) ?>">
		<?php echo do_shortcode( $content ) ?>
	</div>
</section>
