<?php
/**
 * Sidebar terms section structure.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$tax_name	= $args['tax_name'];
$terms		= get_terms( $tax_name, ['hide_empty=1'] );

if( empty( $terms ) || is_wp_error( $terms ) ) return;

$colors = ['yellow', 'blue', 'green', 'violet'];
?>

<section class="sidebar-section white-wrapper">
	<div class="sidebar-section-title underlined">
		<h4 class="sidebar-section-title__text">
			<?php esc_html_e( 'Все Рубрики', 'daddytales' ) ?>
		</h4>
	</div>

	<div class="sidebar-terms">
		<?php
		foreach( $terms as $single_term ){
			$class = $colors[array_rand( $colors )];
			?>
			<a class="sidebar-term <?php echo esc_attr( $class ) ?>" href="<?php echo get_term_link( $single_term ) ?>">
				<?php echo esc_html( $single_term->name ) ?>
			</a>
			<?php
		}
		?>
	</div>
</section><!-- .sidebar-section -->

