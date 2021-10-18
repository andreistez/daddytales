<?php
/**
 * Archives template for Slides Tales taxonomy.
 *
 * @package WordPress
 * @subpackage daddytales
 */

get_header();

$tax_name	= get_queried_object()->taxonomy;
$term_id	= get_queried_object()->term_id;
$term		= get_term( $term_id, $tax_name );
$term_slug	= $term->slug;
?>

<main class="main">
	<section class="tax-section">
		<?php
		$title_args = [
			'title'			=> $term->name,
			'margin_left'	=> null
		];
		get_template_part( 'includes/common/section', 'title', $title_args );
		?>

		<div class="fw-container">
			<div class="tax-inner">
				<?php
				$args = [
					'post_type'	=> 'slidestale',
					'tax_name'	=> $tax_name,
					'term'		=> $term
				];
				get_template_part( 'includes/sidebar/sidebar', null, $args );
				?>

                <?php
				if( have_posts() ){
					?>
					<div class="tax-content white-wrapper">
						<div class="tax-posts">
							<?php
							while( have_posts() ){
								the_post();
								$post_id = get_the_ID();

								if( ! $post_id ) continue;

								get_template_part( 'includes/single/slider', 'preview', ['post_id' => $post_id] );
							}
							?>
						</div>

						<?php
						$pagination_args = [
							'post_type'	=> 'slidestale',
							'tax_name'	=> $tax_name,
							'term_slug'	=> $term_slug
						];
						get_template_part( 'includes/common/pagination', null, $pagination_args );
						?>
					</div><!-- .tax-content -->
					<?php
				}	else {
					?>
					<div class="tax-posts not-found">
						<?php esc_html_e( 'Записи не найдены.', 'daddytales' ) ?>
					</div>
					<?php
				}
				?>
			</div><!-- .tax-inner -->
		</div><!-- .fw-container -->
	</section><!-- .tax-section -->
</main>

<?php
get_footer();

