<?php
/**
 * Single Cartoon player and frames.
 *
 * @see Cartoon post -> Cartoon additional fields.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$post_id		= $args['post_id'];
$kinopoisk_id	= $args['kp_id'];

if( ! $post_id || ! $kinopoisk_id ) return;

$frames	= fw_get_db_post_option( $post_id, 'frames' );
?>

<div class="cartoon-player white-wrapper">
	<?php
	if( $frames ){
		$frames = json_decode( $frames );
		?>
		<div class="cwp-slider cartoon-frames">
			<?php
			if( isset( $frames->frames ) && ! empty( $frames->frames ) ){
				foreach( $frames->frames as $key => $frame ){
					get_template_part( 'includes/single/cartoon/slide', null, [
						'image'		=> $frame->image,
						'preview'	=> $frame->preview
					] );
				}
			}	else {
				foreach( $frames as $key => $frame ){
					get_template_part( 'includes/single/cartoon/slide', null, [
						'image'		=> $frame->imageUrl,
						'preview'	=> $frame->previewUrl
					] );
				}
			}
			?>
		</div><!-- .cartoon-frames -->
		<?php
	}
	?>

	<div id="yohoho" data-kinopoisk="<?php echo esc_attr( $kinopoisk_id ) ?>"></div>
</div><!-- .cartoon-player -->

