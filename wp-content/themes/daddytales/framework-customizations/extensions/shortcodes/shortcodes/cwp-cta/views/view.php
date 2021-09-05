<?php
if( ! defined( 'FW' ) ) die( 'Forbidden' );

$alt_view = $atts['alt_view'];

// Not showing block if User is logged in and hide choice is selected.
if( is_user_logged_in() && $alt_view === 'hide' ) return;

$text_size = $atts['text_size'];
$title = $atts['title'];
$desc = $atts['desc'];
$button = [];
$button['text'] = $atts['button_text'] ?? '';
$button['url'] = $atts['button_url'] ?? '#';
$button['target'] = $atts['button_target'] ? '_blank' : '_self';
?>

<div class="cwp-cta <?php echo esc_attr( $text_size ) ?>">
	<?php
	// If User is not logged in or alt view = default view.
	if( ! is_user_logged_in() || ( is_user_logged_in() && $alt_view === 'leave' ) ){
		if( $title || $desc ){
			?>
			<div class="cwp-cta-text">
				<?php
				if( $title ){
					?>
					<h2 class="cwp-cta-text__title">
						<?php printf( esc_html__( '%s', 'daddytales' ), $title ) ?>
					</h2>
					<?php
				}

				if( $desc ){
					?>
					<p class="cwp-cta-text__desc">
						<?php printf( esc_html__( '%s', 'daddytales' ), $desc ) ?>
					</p>
					<?php
				}
				?>
			</div><!-- .cwp-cta-text -->
			<?php
		}

		if( ! empty( $button ) ){
			?>
			<div class="cwp-cta-button">
				<a href="<?php echo esc_url( $button['url'] ) ?>" class="button black lg cwp-cta-button__link" target="<?php echo esc_attr( $button['target'] ) ?>">
					<?php printf( esc_html__( '%s', 'daddytales' ), $button['text'] ) ?>
				</a>
			</div>
			<?php
		}
	}	else {
		$current_user = wp_get_current_user();
		$current_user_login = $current_user->user_login;
		?>
		<div class="cwp-cta-text">
			<h2 class="cwp-cta-text__title">
				<?php printf( esc_html__( 'Привет, %s!', 'daddytales' ), $current_user_login ) ?>
			</h2>
			<p class="cwp-cta-text__desc">
				<?php esc_html_e( 'Спасибо, что ты с нами.)', 'daddytales' ) ?>
			</p>
		</div>

		<div class="cwp-cta-button">
			<a href="<?php echo get_the_permalink( 6736 ) ?>" class="button black lg cwp-cta-button__link">
				<?php esc_html_e( 'Личный кабинет', 'daddytales' ) ?>
			</a>
		</div>
		<?php
	}
	?>
</div><!-- .cwp-cta -->

