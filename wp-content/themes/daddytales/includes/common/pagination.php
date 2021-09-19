<?php
/**
 * Pagination.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$post_type	= $args['post_type'];
$tax_name	= $args['tax_name'];
$term_slug	= $args['term_slug'];
?>

<div
	class			= "tax-pagination-wrapper"
	data-type		= "<?php echo esc_attr( $post_type ) ?>"
	data-taxonomy	= "<?php echo esc_attr( $tax_name ) ?>"
	data-term		= "<?php echo esc_attr( $term_slug ) ?>"
>
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

