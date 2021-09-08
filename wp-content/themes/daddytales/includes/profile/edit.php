<?php
/**
 * Profile content part.
 *
 * @package WordPress
 * @subpackage daddytales
 */

if( ! is_user_logged_in() ) return;
$user = wp_get_current_user();
$user_id = $user->ID;
?>

<div class="profile-content-inner edit" data-content="edit">
	<div class="section-title underlined">
		<h3 class="section-title-text">
			<?php esc_html_e( 'Редактировать личную информацию', 'daddytales' ) ?>
		</h3>
	</div>
</div>

