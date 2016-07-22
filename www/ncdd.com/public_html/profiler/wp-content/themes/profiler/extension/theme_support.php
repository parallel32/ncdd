<?php
// Remove theme generator meta tag
remove_action('wp_head', 'wp_generator');

if (function_exists('add_theme_support')) {
    // enable featured image
    add_theme_support('post-thumbnails');
    add_theme_support( 'automatic-feed-links' );
    register_nav_menu('primary','Primary Menu');
}
?>