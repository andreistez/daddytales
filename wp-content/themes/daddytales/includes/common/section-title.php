<?php
/**
 * Section title.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$title = $args['title'];
$style = $args['margin_left'] ? ' style="margin-left: ' . $args['margin_left'] . '%"' : '';
?>

<div class="cwp-title">
	<h2 class="cwp-title__text"<?php echo $style ?>>
		<?php printf( esc_html__( '%s', 'daddytales' ), $title ) ?>
	</h2>
</div>

