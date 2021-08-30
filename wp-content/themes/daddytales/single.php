<?php
/**
 * @package WordPress
 * @subpackage daddytales
 */

get_header();
?>

<main class="main">
    <?php
	while( have_posts() ) :
		the_post();
		get_template_part( 'includes/single/content', get_post_type() );
	endwhile;
	?>
</main>

<?php
get_footer();
