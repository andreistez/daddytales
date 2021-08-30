<?php
/**
 * Single post content.
 *
 * @package WordPress
 * @subpackage daddytales
 */

// Correct only inside WP loop.
$post_id = get_the_ID();

// If this is single post page.
if( is_singular( 'post' ) ){
    dt_set_post_views( $post_id );
    ?>
    <article class="single-post post-<?php echo esc_attr($post_id) ?>">
        <h1><?php the_title() ?></h1>
        <?php the_content() ?>
    </article><!-- .single-post -->
    <?php
}   else {
    // Archive post preview.
    ?>
    <article class="post-preview post-preview-<?php echo esc_attr($post_id) ?>">
        <?php
        the_title();
        $content = the_content();
        ?>
    </article><!-- .post-preview -->
    <?php
}

