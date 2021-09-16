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

<div class="cartoon-player">
	<?php
	if( $frames ){
		$frames = json_decode( $frames );
		?>
		<div class="cwp-slider cartoon-frames">
			<?php
			foreach( $frames->frames as $key => $frame ){
				$frame_image	= $frame->image;
				$frame_preview	= $frame->preview;
				?>
				<div class="slide cartoon-frame">
					<div class="slide-inner cartoon-frame-inner img-cover-inside">
						<?php
						if( $frame_image ){
							?>
							<img class="cartoon-frame__img" src="<?php echo esc_url( $frame_image ) ?>" alt="" />
							<?php
						}

						if( $frame_preview ){
							?>
							<img class="cartoon-frame__preview" src="<?php echo esc_url( $frame_preview ) ?>" alt="" />
							<?php
						}
						?>
					</div>
				</div><!-- .cartoon-frame -->
				<?php
			}
			?>
		</div><!-- .cartoon-frames -->
		<?php
	}
	?>

	<div id="yohoho" data-kinopoisk="<?php echo esc_attr( $kinopoisk_id ) ?>"></div>
</div><!-- .cartoon-player -->

