<?php
/**
 * Template Name: Views
 *
 * @package WordPress
 * @subpackage daddytales
 */

get_header();

$posts_query = new WP_Query(
	[
		'post_type'			=> 'post',
		'posts_per_page'	=> -1,
		'orderby'			=> 'title',
		'order'				=> 'ASC'
	]
);
?>

<main class="main">
	<div class="fw-container">
		<form class="change-views-count">
			<fieldset>
				<?php
				if( $posts_query->have_posts() ){
					?>
					<select id="views-select" class="input" name="views-select">
						<?php
						while( $posts_query->have_posts() ){
							$posts_query->the_post();
							$post_id = get_the_ID();
							?>
							<option value="<?php echo esc_attr( $post_id ) ?>">
								<?php echo get_the_title( $post_id ), " | POST ID = $post_id" ?>
							</option>
							<?php
						}
						?>
					</select>
					<?php
				}
				?>

				<input id="views-count" name="views-count" type="text" placeholder="<?php esc_attr_e( 'Количество просмотров', 'daddytales' ) ?>" />

				<button class="button" type="submit">
					<?php esc_html_e( 'Изменить', 'daddytales' ) ?>
				</button>

				<div class="note"></div>
			</fieldset>
		</form>
	</div>
</main>

<?php
get_footer();

