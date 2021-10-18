<?php
/**
 * Single Slides Tale slider.
 *
 * @see Slides Tale post -> Slides Tales additional fields.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$post_id	= $args['post_id'];
$slider		= fw_get_db_post_option( $post_id, 'slider' );

if( ! is_array( $slider ) || count( $slider ) < 1 ) return;
?>

<div class="slidestales-slider white-wrapper">
	<?php
	foreach( $slider as $slide ){
		$image	= $slide['image'] ?: null;
		$text	= $slide['text'] ?: null;

		if( ! $image || ! $text ) continue;
		?>
		<div class="slidestales-slide">
			<div class="slidestales-slide-inner">
				<?php echo wp_get_attachment_image( $image['attachment_id'], 'full', null, ['class' => 'slidestales-slide__img'] ) ?>

				<div class="slidestales-slide__text">
					<?php echo $text ?>
				</div>
			</div>
		</div>
		<?php
	}
	?>
</div><!-- .slidestales-slider -->

