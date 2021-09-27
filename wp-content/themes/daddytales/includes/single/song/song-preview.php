<?php
/**
 * Song preview.
 *
 * @package WordPress
 * @subpackage daddytales
 */

if( isset( $args['post_id'] ) ) $post_id = $args['post_id'];
else $post_id = get_the_ID();

$post_type	= isset( $args['post_type'] ) ? $args['post_type'] : 'song';
$tax_name	= isset( $args['tax_name'] ) ? $args['tax_name'] : 'songs';
$btn_icon	= isset( $args['btn_icon'] ) ? $args['btn_icon'] : null;
$btn_text	= isset( $args['btn_text'] ) ? $args['btn_text'] : esc_html__( 'Заценить', 'daddytales' );
$post_views	= dt_get_post_views( $post_id );
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
			<div class="song-preview-info__fields">
				<div class="slide-views">
					<i class="far fa-eye"></i> <?php echo number_format( esc_html( $post_views ), 0, '', ' ' ) ?>
				</div>

				<h6 class="slide-info__title">
					<a href="<?php echo get_the_permalink( $post_id ) ?>">
						<?php printf( esc_html__( '%s', 'daddytales' ), get_the_title( $post_id ) ) ?>
					</a>
				</h6>

				<?php
				if( $post_type === 'poem' ){
					$preview_terms = get_the_terms( $post_id, $tax_name );

					if( is_array( $preview_terms ) ){
						?>
						<div class="song-preview-terms">
							<?php
							foreach( $preview_terms as $term ){
								if( ! $term->parent ) continue;
								?>
								<a class="song-preview-term" href="<?php echo get_term_link( $term->term_id, $tax_name ) ?>">
									<?php echo esc_html( $term->name ) ?>
								</a>
								<?php
							}
							?>
						</div>
						<?php
					}
				}
				?>
			</div>

			<div class="slide-button">
				<a class="button yellow icon" href="<?php echo get_the_permalink( $post_id ) ?>">
					<span>
						<?php echo $btn_text ?>
					</span>
					<?php if( $btn_icon ) echo $btn_icon ?>
				</a>
			</div>
		</div>
	</div><!-- .slide-inner -->
</article><!-- .song-preview -->

