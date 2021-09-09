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
$user_email = $user->user_email;
$user_fullname = $user->user_firstname;
if( $user->user_lastname ) $user_fullname .= ' ' . $user->user_lastname;

$user_data = get_userdata( $user_id );
$user_website = $user_data->user_url;
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

        <?php
        if( $user_website ){
            ?>
            <div class="user-field">
                <span class="user-field-label">
                    <?php esc_html_e( 'Веб-сайт', 'daddytales' ) ?>
                </span>
                <div class="user-field-value">
                    <a href="<?php echo esc_url( $user_website ) ?>" target="_blank" title="<?php esc_attr_e( 'Открыть в новой вкладке', 'daddytales' ) ?>">
                        <?php echo esc_html( $user_website ) ?>
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
	</div><!-- .user-fields -->
</div><!-- .user-dashboard-info -->

