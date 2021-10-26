<?php
/**
 * Archives template.
 *
 * @package WordPress
 * @subpackage daddytales
 */

get_header();
?>

<main class="main">
	<section class="tax-section">
		<?php
		$title_args = [
			'title'			=> esc_html__( 'Поиск', 'daddytales' ),
			'margin_left'	=> 5
		];
		get_template_part( 'includes/common/section', 'title', $title_args );
		?>

		<div class="fw-container">
			<div class="tax-inner">
				<?php get_template_part( 'includes/sidebar/sidebar' ) ?>

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
							'post_type' => 'post',
							's'			=> get_search_query()
						];
						get_template_part( 'includes/common/pagination', null, $pagination_args );
						?>
					</div><!-- .tax-content -->
					<?php
				}	else {
					?>
					<div class="tax-content not-found white-wrapper">
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
