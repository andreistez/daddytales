<?php
/**
 * Profile content part.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$user		= $args['user'];
$user_id	= $user->ID;
?>

<div class="profile-content-inner user-edit active" data-content="edit">
	<div class="section-title underlined">
		<h3 class="section-title-text">
			<?php esc_html_e( 'Личная информация', 'daddytales' ) ?>
		</h3>
	</div>

	<?php
	get_template_part( 'includes/profile/edit/avatar', null, ['user_id' => $user_id] );
	get_template_part( 'includes/profile/edit/common', null, ['user' => $user] );
	get_template_part( 'includes/profile/edit/password' );
	?>
</div><!-- .profile-content-inner.user-edit -->

