<?php
/**
 * @package WordPress
 * @subpackage daddytales
 */

get_header();
?>

<main class="main">
	<?php if (have_posts()) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php echo get_the_permalink(); ?>

			<?php the_post_thumbnail('thumb-width'); ?> OR <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>

			<?php the_title(); ?>

			<?php if ( has_excerpt() ) : ?>
				<?php the_excerpt(); ?>
			<?php endif; ?>

			<?php $post_date = get_the_date( 'F j, Y' ); ?>
			<?php echo $post_date; ?>

		<?php endwhile; ?>

	<?php else: ?>

	<?php endif; ?>

	<?php if (get_next_posts_link()) : ?>
		<?php next_posts_link(''); ?>
	<?php endif; ?>
</main>

<?php
get_footer();
