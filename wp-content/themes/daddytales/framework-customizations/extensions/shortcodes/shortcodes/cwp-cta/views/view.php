<?php
if( ! defined( 'FW' ) ) die( 'Forbidden' );

$title = $atts['title'];
$desc = $atts['desc'];
$button = [];
$button['text'] = $atts['button_text'] ?? '';
$button['url'] = $atts['button_url'] ?? '#';
$button['target'] = $atts['button_target'] ? '_blank' : '_self';
?>

<div class="cwp-cta">
	<?php
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
	?>
</div><!-- .cwp-cta -->

