<?php
/**
 * Profile content part.
 *
 * @package WordPress
 * @subpackage daddytales
 */

/** @var array $args */
$user = $args['user'];
$user_id = $user->ID;
$user_fullname = $user->user_firstname;
if( $user->user_lastname ) $user_fullname .= ' ' . $user->user_lastname;

$user_email = $user->user_email;
$user_bio = get_user_meta( $user_id )['description'][0];
$user_link = get_userdata( $user_id )->user_url;
?>

<div class="profile-content-inner user-info active" data-content="info">
	<div class="section-title underlined">
		<h3 class="section-title-text">
			<?php esc_html_e( 'Информация профиля', 'daddytales' ) ?>
		</h3>
	</div>

	<div class="user-fields">
        <div class="user-field">
            <span class="user-field-label">
                <?php esc_html_e( 'Полное имя', 'daddytales' ) ?>
            </span>
            <span class="user-field-value">
                <?php echo $user_fullname ?>
            </span>
        </div>

        <div class="user-field">
            <span class="user-field-label">
                <?php esc_html_e( 'E-mail', 'daddytales' ) ?>
            </span>
            <span class="user-field-value">
                <?php echo $user_email ?>
            </span>
        </div>
	</div><!-- .user-fields -->
</div><!-- .user-dashboard-info -->

