<?php
/**
 * Archives template.
 *
 * @package WordPress
 * @subpackage daddytales
 */

get_header();

$tax_name = get_queried_object()->taxonomy;
$term_id = get_queried_object()->term_id;
$term = get_term( $term_id, $tax_name );
$term_slug = $term->slug;
?>

<main class="main">
	<section class="archive-section">
		<div class="fw-container">
			<div class="archive-inner">
                <div class="section-title underlined">
					<h3 class="section-title-text">
						<?php printf( esc_html__( '%s:', 'daddytales' ), get_the_archive_title() ) ?>
					</h3>
				</div>

                <?php
				if( have_posts() ){
					?>
					<div class="archive-posts">
						<?php
						while( have_posts() ){
							the_post();
							$post_id = get_the_ID();
							get_template_part( 'includes/single/slider', 'preview', ['post_id' => $post_id] );
						}
						?>
					</div>

					<div class="archive-pagination-wrapper" data-taxonomy="<?php echo esc_attr( $tax_name ) ?>" data-term="<?php echo esc_attr( $term_slug ) ?>">
						<nav class = "navigation pagination" role="navigation">
							<div class="nav-links">
								<?php
								echo paginate_links(
									[
										'show_all'			=> false,
										'end_size'			=> 1,
										'mid_size'			=> 1,
										'prev_next'			=> true,
										'prev_text'			=> '<i class="fas fa-chevron-left"></i>',
										'next_text'			=> '<i class="fas fa-chevron-right"></i>',
										'screen_reader_text'=> ' '
									]
								)
								?>
							</div>
						</nav>
					</div>
					<?php
				}	else {
					?>
					<div class="archive-posts not-found">
						<?php esc_html_e( 'Posts not found.', 'daddytales' ) ?>
					</div>
					<?php
				}
				?>
			</div><!-- .archive-inner -->
		</div><!-- .fw-container -->
	</section><!-- .archive-section -->
</main>

<?php
get_footer();
