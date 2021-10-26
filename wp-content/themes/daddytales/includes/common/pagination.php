<?php
/**
 * Pagination.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$post_type	= isset( $args['post_type'] )
			? ' data-type="' . esc_attr( $args['post_type'] ) . '"' : '';
$tax_name	= isset( $args['tax_name'] )
			? ' data-taxonomy="' . esc_attr( $args['tax_name'] ) . '"' : '';
$term_slug	= isset( $args['term_slug'] )
			? ' data-term="' . esc_attr( $args['term_slug'] ) . '"' : '';
$s_query	= isset( $args['s'] )
			? ' data-search-query="' . esc_attr( $args['s'] ) . '"' : '';
?>

<div class = "tax-pagination-wrapper"<?php echo $post_type, $tax_name, $term_slug, $s_query ?>>
	<nav class = "navigation pagination" role="navigation">
		<div class="nav-links">
			<?php
			echo paginate_links(
				[
					'show_all'				=> false,
					'end_size'				=> 1,
					'mid_size'				=> 1,
					'prev_next'				=> true,
					'prev_text'				=> '<i class="fas fa-chevron-left"></i>',
					'next_text'				=> '<i class="fas fa-chevron-right"></i>',
					'screen_reader_text'	=> ' '
				]
			)
			?>
		</div>
	</nav>
</div><!-- .tax-pagination-wrapper -->

