<?php
/**
 * Latest posts column preview.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$post_id = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();

if( ! $post_id ) return;

$post_type	= get_post_type( $post_id );
$colors		= ['yellow', 'blue', 'green', 'violet'];
$class		= $colors[array_rand( $colors )];
?>

<article class="latest-col-post post-<?php echo esc_attr( $post_id ), ' ', esc_attr( $class ) ?>">
	<?php
	if( has_post_thumbnail( $post_id ) ){
		?>
		<div class="latest-col-post-thumb">
			<?php echo get_the_post_thumbnail( $post_id, 'thumbnail' ) ?>
			<a class="latest-col-post-permalink" href="<?php echo get_the_permalink( $post_id ) ?>"></a>
		</div>
		<?php
	}
	?>

	<div class="latest-col-post-info">
		<h6 class="latest-col-post-info__title">
			<a href="<?php echo get_the_permalink( $post_id ) ?>">
				<?php printf( esc_html__( '%s', 'daddytales' ), get_the_title( $post_id ) ) ?>
			</a>
		</h6>

		<?php
		if( $post_type === 'poem' ){
			$preview_terms = get_the_terms( $post_id, 'poems' );

			if( is_array( $preview_terms ) ){
				?>
				<div class="song-preview-terms">
					<?php
					foreach( $preview_terms as $term ){
						if( ! $term->parent ) continue;
						?>
						<a class="song-preview-term" href="<?php echo get_term_link( $term->term_id, 'poems' ) ?>">
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

		<div class="latest-col-post-info__views">
			<i class="far fa-eye"></i>
			<?php echo number_format( dt_get_post_views( $post_id ), 0, '', ' ' ) ?>
		</div>
	</div>

	<a class="latest-col-post__link" href="<?php echo get_the_permalink( $post_id ) ?>"></a>
</article><!-- .latest-col-post -->

