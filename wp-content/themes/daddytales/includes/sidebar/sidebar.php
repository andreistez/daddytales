<?php
/**
 * Sidebar structure.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$tax_name = isset( $args['tax_name'] ) ? $args['tax_name'] : '';
?>

<aside class="sidebar">
	<?php
	get_template_part( 'includes/sidebar/terms', null, ['tax_name' => $tax_name] );
	get_template_part( 'includes/sidebar/popular', null, $args );
	?>
</aside><!-- .sidebar -->

