<?php
/**
 * Single Cartoon frames slide.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$frame_image	= $args['image'] ?? null;
$frame_preview	= $args['preview'] ?? null;

if( ! $frame_image || ! $frame_preview ) return;
?>

<div class="slide cartoon-frame">
	<div class="slide-inner cartoon-frame-inner img-cover-inside">
		<img class="cartoon-frame__img" src="<?php echo esc_url( $frame_image ) ?>" alt="" />
		<img class="cartoon-frame__preview" src="<?php echo esc_url( $frame_preview ) ?>" alt="" />
	</div>
</div><!-- .cartoon-frame -->

