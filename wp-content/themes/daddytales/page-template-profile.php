<?php
/**
 * Template Name: Profile
 *
 * @package WordPress
 * @subpackage daddytales
 */

get_header();

$user = wp_get_current_user()
?>

<main class="main">
	<section class="profile">
        <div class="fw-container">
            <div class="profile-inner">
                <?php
                // If User is logged in.
                if( is_user_logged_in() ){
                    get_template_part( 'includes/profile/sidebar', null, ['user' => $user] );
                    get_template_part( 'includes/profile/content', null, ['user' => $user] );
                }   else {
                    get_template_part( 'includes/profile/not', 'logged-in' );
                }
                ?>
            </div>
        </div><!-- .fw-container -->
    </section><!-- .section-profile -->
</main>

<?php
get_footer();

