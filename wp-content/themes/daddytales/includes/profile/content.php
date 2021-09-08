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

<div class="profile-content">
    <?php
    get_template_part( 'includes/profile/info', null, ['user' => $user] );
    get_template_part( 'includes/profile/invite', null, ['user_id' => $user_id] );
    get_template_part( 'includes/profile/edit', null, ['user_id' => $user_id] );
    ?>
</div>

