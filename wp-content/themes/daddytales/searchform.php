<?php
/**
 * Search form structure.
 *
 * @see Appearance -> Customize -> Header Settings -> Search.
 *
 * @package WordPress
 * @subpackage daddytales
 */

// Get string with placeholder variations separated by pipe | symbol.
$search_placeholders = fw_get_db_customizer_option( 'search_placeholders' );

if( $search_placeholders ){
    // String to array.
    $search_placeholders_arr = explode( '|', $search_placeholders );
    // Get random array element key.
    $search_placeholder_key = array_rand( $search_placeholders_arr );
    // Get array element with this key.
    $search_placeholder = $search_placeholders_arr[$search_placeholder_key];
}   else {
    // OR set defaults.
    $search_placeholder = 'Поиск по сайту';
}
?>

<form role="search" method="get" class="searchform" action="<?php echo home_url( '/' ) ?>">
    <input class="input input-search" type="text" value="<?php echo get_search_query() ?>" name="s" placeholder="<?php printf( esc_attr__( '%s', 'daddytales' ), $search_placeholder ) ?>" />
    <button class="searchform-button" type="submit" title="<?php printf( esc_attr__( '%s', 'daddytales' ), $search_placeholder ) ?>">
        <i class="fas fa-search"></i>
    </button>
</form>

