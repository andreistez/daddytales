<?php
/**
 * Song preview.
 *
 * @package WordPress
 * @subpackage daddytales
 */

// Correct only inside WP loop.
$post_id	= get_the_ID();
$post_views	= dt_get_post_views( $post_id );

if( ! $post_id ) return;
?>

<article class="song-preview post-<?php echo esc_attr( $post_id ) ?>">
	<div class="song-preview-inner">
		<?php
		if( has_post_thumbnail( $post_id ) ){
			?>
			<div class="slide-thumb song-preview-thumb">
				<?php echo get_the_post_thumbnail( $post_id, 'full' ) ?>
				<a class="slide-permalink" href="<?php echo get_the_permalink( $post_id ) ?>"></a>
			</div>
			<?php
		}
		?>

		<div class="song-preview-info">
			<h6 class="slide-info__title">
				<a href="<?php echo get_the_permalink( $post_id ) ?>">
					<?php printf( esc_html__( '%s', 'daddytales' ), get_the_title( $post_id ) ) ?>
				</a>
			</h6>

			<div class="slide-button">
				<a class="button yellow" href="<?php echo get_the_permalink( $post_id ) ?>">
					<?php esc_html_e( 'Слушать', 'daddytales' ) ?>
				</a>
			</div>

			<div class="slide-views">
				<i class="far fa-eye"></i> <?php echo number_format( esc_html( $post_views ), 0, '', ' ' ) ?>
			</div>
		</div>
	</div><!-- .slide-inner -->
</article><!-- .song-preview -->

