<?php
/**
 * Profile content part.
 *
 * @package WordPress
 * @subpackage daddytales
 */

$user = $args['user'];
?>

<div class="profile-content">
    <?php
    get_template_part( 'includes/profile/info', null, ['user' => $user] );
    get_template_part( 'includes/profile/invite', null, ['user' => $user] );
    get_template_part( 'includes/profile/edit', null, ['user' => $user] );
    get_template_part( 'includes/profile/to', 'admin' );
    ?>
</div>

