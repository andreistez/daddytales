<?php
/**
 * Single post terms list.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$post_id	= $args['post_id'];
$taxonomy	= $args['taxonomy'];
?>

<div class="song-terms white-wrapper">
	<h3>
		<?php esc_html_e( 'Рубрики:', 'daddytales' ) ?>
	</h3>

	<?php
	$terms = get_the_terms( $post_id, $taxonomy );
	if( is_array( $terms ) ){
		?>
		<div class="song-terms-inner">
			<?php
			foreach( $terms as $term ){
				?>
				<a class="song-term" href="<?php echo get_term_link( $term->term_id, $taxonomy ) ?>">
					<?php echo esc_html( $term->name ) ?>
				</a>
				<?php
			}
			?>
		</div>
		<?php
	}
	?>
</div>

