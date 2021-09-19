<?php
/**
 * Single post content.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$post_id = $args['post_id'];

// If this is single post page.
if( is_singular( 'post' ) ){
    dt_set_post_views( $post_id );
    ?>
    <article class="single-post post-<?php echo esc_attr( $post_id ) ?>">
        <h1><?php the_title() ?></h1>
        <?php the_content() ?>

        <?php
        // If comments are open or we have at least one comment.
		if ( comments_open() || get_comments_number() ) comments_template( '', true );
        ?>
    </article><!-- .single-post -->
    <?php
}

