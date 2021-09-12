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

// User avatar - trying to get attachment ID from current User meta field.
$user_avatar_url = get_user_meta( $user_id, 'dt_avatar_image_id', true );
$user_avatar_url = $user_avatar_url ? wp_get_attachment_image_url( $user_avatar_url, 'thumbnail' ) : '';
// If fail - get standard gravatar url.
if( ! $user_avatar_url ) $user_avatar_url = get_avatar_url( $user_id );

$user_meta = get_user_meta( $user_id );
$user_bio = $user_meta['description'][0];
?>

<aside class="profile-sidebar">
    <div class="profile-avatar">
        <img class="avatar avatar-100 photo" src="<?php echo $user_avatar_url ?>" loading="lazy" width="100" height="100" alt="" />
        <h4 class="profile-login">
            <?php echo esc_html( $user_login ) ?>
        </h4>
        <a class="dt-logout" href="#" title="<?php esc_attr_e( 'Выйти', 'daddytales' ) ?>">
            <i class="fas fa-sign-out-alt"></i>
            <?php esc_attr_e( 'Выйти?', 'daddytales' ) ?>
        </a>
    </div>

    <?php
    if( $user_bio ){
        ?>
        <div class="profile-bio">
            <?php echo esc_html( $user_bio ) ?>
        </div>
        <?php
    }
    ?>

    <div class="user-tabs">
        <div class="user-tab active" data-content="info">
            <i class="fas fa-info-circle"></i>
            <?php esc_html_e( 'Информация', 'daddytales' ) ?>
        </div>
        <div class="user-tab" data-content="invite">
            <i class="fas fa-user-plus"></i>
            <?php esc_html_e( 'Пригласить друга', 'daddytales' ) ?>
        </div>
        <div class="user-tab" data-content="edit">
            <i class="fas fa-user-edit"></i>
            <?php esc_html_e( 'Редактировать профиль', 'daddytales' ) ?>
        </div>

        <?php
        // If current User has role that can go to Admin Console.
        $allowed_roles = ['administrator'];
        if( array_intersect( $allowed_roles, $user->roles ) ){
            // Show button to quick redirect.
            ?>
            <div class="user-tab user-tab_admin" data-content="to-admin">
                <i class="fas fa-lock-open"></i>
                <a href="<?php echo home_url() ?>/wp-admin">
                    <?php esc_html_e( 'В Админку', 'daddytales' ) ?>
                </a>
            </div>
            <?php
        }
        ?>
    </div><!-- .user-tabs -->
</aside><!-- .profile-sidebar -->

