<?php
/**
 * Profile sidebar part.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$user = $args['user'];
$user_id = $user->ID;
$user_login = $user->user_login;
?>

<aside class="profile-sidebar">
    <div class="profile-avatar">
        <?php echo get_avatar( $user_id, 100, 100 ) ?>
        <h4 class="profile-login">
            <?php echo esc_html( $user_login ) ?>
        </h4>
        <a class="dt-logout" href="#" title="<?php esc_attr_e( 'Выйти', 'daddytales' ) ?>">
            <i class="fas fa-sign-out-alt"></i>
            <?php esc_attr_e( 'Выйти?', 'daddytales' ) ?>
        </a>
    </div>

    <div class="user-tabs">
        <div class="user-tab active" data-content="info">
            <?php esc_html_e( 'Информация', 'daddytales' ) ?>
        </div>
        <div class="user-tab" data-content="invite">
            <?php esc_html_e( 'Пригласить друга', 'daddytales' ) ?>
        </div>
        <div class="user-tab" data-content="edit">
            <?php esc_html_e( 'Редактировать профиль', 'daddytales' ) ?>
        </div>
    </div><!-- .user-tabs -->
</aside><!-- .profile-sidebar -->

