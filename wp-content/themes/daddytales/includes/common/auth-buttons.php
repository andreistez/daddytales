<?php
/**
 * Icons for authorization.
 *
 * @package WordPress
 * @subpackage industrialcyber
 */

$user = wp_get_current_user();
$user_login = $user->user_login;
?>

<div class="auth-buttons">
    <?php
    // If User is NOT logged in.
    if( ! is_user_logged_in() ){
        ?>
        <a class="button black icon" href="<?php echo get_the_permalink( 6706 ) ?>">
            <span>
                <?php esc_html_e( 'Вход', 'daddytales' ) ?>
            </span>
            <i class="fas fa-sign-in-alt"></i>
        </a>

        <a class="button yellow icon" href="<?php echo get_the_permalink( 6723 ) ?>">
            <span>
                <?php esc_html_e( 'Регистрация', 'daddytales' ) ?>
            </span>
            <i class="fas fa-user-alt"></i>
        </a>
        <?php
    }   else {  // User is logged in.
        ?>
        <a class="button black icon" href="<?php echo get_the_permalink( 6736 ) ?>">
            <span>
                <?php esc_html_e( 'Личный кабинет', 'daddytales' ) ?>
            </span>
            <i class="fas fa-user-cog"></i>
        </a>
        <?php
    }
    ?>
</div><!-- .auth-buttons -->
