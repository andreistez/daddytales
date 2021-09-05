<?php
/**
 * If user is already logged in.
 *
 * @package WordPress
 * @subpackage industrialcyber
 */

$user = wp_get_current_user();
$user_login = $user->user_login;
/** @var array $args */
$text = $args['text'];
?>

<div class="dt-form already-logged-in">
    <?php
    if( $text ){
        echo $text;
        ?>
        <div class="already-logged-in-buttons">
            <a class="button black icon" href="<?php echo home_url( '/' ) ?>">
                <?php esc_html_e( 'На Главную', 'daddytales' ) ?>
                <i class="fas fa-long-arrow-alt-left"></i>
            </a>
        </div>
        <?php
    }   else {
        printf( esc_html__( '%s, Вы уже вошли в свой аккаунт. ', 'daddytales' ), $user_login );
        ?>
        <a class="dt-logout" href="#" title="<?php esc_attr_e( 'Выйти', 'daddytales' ) ?>">
            <?php esc_attr_e( 'Выйти?', 'daddytales' ) ?>
        </a>

        <div class="already-logged-in-buttons">
            <a class="button black icon" href="<?php echo home_url( '/' ) ?>">
                <?php esc_html_e( 'Главная', 'daddytales' ) ?>
                <i class="fas fa-long-arrow-alt-left"></i>
            </a>

            <a class="button black icon" href="<?php echo get_the_permalink( 6736 ) ?>">
                <?php esc_html_e( 'Аккаунт', 'daddytales' ) ?>
                <i class="fas fa-user-cog"></i>
            </a>
        </div>
        <?php
    }
    ?>
</div>
