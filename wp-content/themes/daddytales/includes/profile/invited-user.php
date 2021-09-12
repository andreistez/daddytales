<?php
/**
 * Invited and already registered User info.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$number = $args['iter'];
$invited_user = $args['user'];
$invited_user_id = $invited_user->ID;

// User avatar - trying to get attachment ID from current User meta field.
$user_avatar_url = get_user_meta( $invited_user_id, 'dt_avatar_image_id', true );
$user_avatar_url = $user_avatar_url ? wp_get_attachment_image_url( $user_avatar_url, 'thumbnail' ) : '';
// If fail - get standard gravatar url.
if( ! $user_avatar_url ) $user_avatar_url = get_avatar_url( $invited_user_id );

$user_login		= $invited_user->user_login;
$user_email		= $invited_user->user_email;
$user_website	= $invited_user->user_url;
$user_fullname	= $invited_user->last_name
				? $invited_user->first_name . ' ' . $invited_user->last_name
				: $invited_user->first_name;
$user_status	= get_user_meta( $invited_user_id, 'has_to_be_activated', true )
				? esc_html__( 'not activated', 'daddytales' )
				: esc_html__( 'activated', 'daddytales' );
$user_class		= get_user_meta( $invited_user_id, 'has_to_be_activated', true )
				? 'not-activated'
				: 'activated';
?>

<div class="invite-member <?php echo esc_attr( $user_class ) ?>">
	<div class="invite-member-number">
		<?php echo esc_html( $number ) ?>
	</div>

	<div class="invite-member-image img-cover-inside">
		<img class="avatar avatar-80 photo" src="<?php echo $user_avatar_url ?>" loading="lazy" width="80" height="80" alt="" />
	</div>

	<div class="invite-member-info">
		<h4 class="invite-member__title">
			<?php echo esc_html( $user_fullname ) ?>
			<span class="invite-member__status">
				(<?php echo $user_status ?>)
			</span>
		</h4>

		<p class="invite-member__row">
			<span class="invite-member__label">
				<?php echo esc_html_e( 'Логин:', 'daddytales' ) ?>
			</span>
			<span class="invite-member__value">
				<i class="fas fa-user"></i>
				<?php echo $user_login ?>
			</span>
		</p>

		<p class="invite-member__row">
			<span class="invite-member__label">
				<?php echo esc_html_e( 'E-mail:', 'daddytales' ) ?>
			</span>
			<span class="invite-member__value">
				<a href="mailto:<?php echo esc_attr( $user_email ) ?>" title="<?php esc_attr_e( 'Написать письмо', 'daddytales' ) ?>">
					<i class="fas fa-envelope"></i>
					<?php echo $user_email ?>
				</a>
			</span>
		</p>

		<?php
		if( $user_website ){
			?>
			<p class="invite-member__row">
				<span class="invite-member__label">
					<?php echo esc_html_e( 'Веб-сайт:', 'daddytales' ) ?>
				</span>
				<span class="invite-member__value">
					<a href="<?php echo esc_url( $user_website ) ?>" target="_blank" title="<?php esc_attr_e( 'Открыть в новой вкладке', 'daddytales' ) ?>">
						<i class="fas fa-external-link-alt"></i>
						<?php echo $user_website ?>
					</a>
				</span>
			</p>
			<?php
		}
		?>
	</div><!-- .invite-member-info -->
</div><!-- .invite-member -->

