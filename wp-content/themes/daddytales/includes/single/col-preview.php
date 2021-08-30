<?php
/**
 * Latest posts column preview.
 *
 * @package WordPress
 * @subpackage daddytales
 */

// Correct only inside WP loop.
$post_id = get_the_ID();

if( ! $post_id ) return;
?>

<article class="latest-col-post post-<?php echo esc_attr( $post_id ) ?>">
    <?php
    if( has_post_thumbnail( $post_id ) ){
        ?>
        <div class="latest-col-post-thumb">
            <?php echo get_the_post_thumbnail( $post_id, 'thumbnail' ) ?>
            <a class="latest-col-post-permalink" href="<?php echo get_the_permalink( $post_id ) ?>"></a>
        </div>
        <?php
    }
    ?>

    <div class="latest-col-post-info">
        <h6 class="latest-col-post-info__title">
            <a href="<?php echo get_the_permalink( $post_id ) ?>">
                <?php printf( esc_html__( '%s', 'daddytales' ), get_the_title( $post_id ) ) ?>
            </a>
        </h6>

        <div class="latest-col-post-info__views">
            <i class="far fa-eye"></i>
            <?php echo number_format( dt_get_post_views( $post_id ), 0, '', ' ' ) ?>
        </div>
    </div>
</article><!-- .latest-col-post -->

