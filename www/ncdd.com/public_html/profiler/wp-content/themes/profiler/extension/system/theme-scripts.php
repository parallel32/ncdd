<?php
add_action('init', 'register_theme_scripts');
function register_theme_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php') {

        if (is_admin()) {

            add_action('admin_enqueue_scripts','register_back_end_styles');

        } else {

            add_action('wp_enqueue_scripts', 'register_front_end_styles');
            add_action('wp_enqueue_scripts', 'register_front_end_scripts');

        }
    }
}
//Register back-end
function register_back_end_styles(){

    global $pagenow;
    if ('post-new.php' == $pagenow || 'post.php' == $pagenow) :
        wp_enqueue_style('thickbox');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('jquery.fancybox', THEME_PATH. '/css/jquery.fancybox.css');
        wp_enqueue_style('admin_shortcode', THEME_PATH. '/extension/assets/css/admin_shortcode.css');
        wp_register_script('jquery.fancybox_js', THEME_PATH .'/js/jquery.fancybox.js', false, false, $in_footer=true);
        wp_enqueue_script('jquery.fancybox_js')  ;
    endif;
    // css
    wp_enqueue_style(THEME_PREFIX . '_admin_custom_styles', THEME_PATH . '/extension/system/css/admin-styles.css');
    wp_enqueue_style('tz-theme-option', THEME_PATH . '/extension/system/css/tz-theme-options.css');

    // js
    wp_register_script(THEME_PREFIX . '_admin_custom_scripts', THEME_PATH . '/extension/system/js/admin-scripts.js', array(), '1.0', false);
    wp_enqueue_script(THEME_PREFIX . '_admin_custom_scripts');
    wp_register_script('portfolio_meta_boxes', THEME_PATH . '/extension/system/js/portfolio_meta_boxes.js', false, '1.0', $in_footer=true);
    wp_enqueue_script('portfolio_meta_boxes');
    wp_register_script('portfolio_theme_option', THEME_PATH . '/extension/system/js/portfolio_theme_option.js', false, '1.0', $in_footer=true);
    wp_enqueue_script('portfolio_theme_option');


}
//Register Front-End Styles
function register_front_end_styles()
{
    if(!is_404()) {

        wp_enqueue_style('style', THEME_PATH . '/style.css', false );
        wp_enqueue_style('bootstrap', THEME_PATH . '/css/bootstrap.css', false );
        wp_enqueue_style('bootstrap-responsive', THEME_PATH . '/css/bootstrap-responsive.css', false );
        wp_enqueue_style('font-awesome', THEME_PATH . '/fonts/font-awesome/css/font-awesome.min.css', false );
        wp_enqueue_style('off-canvas', THEME_PATH . '/css/off-canvas.css', false );
        wp_enqueue_style('sidebar', THEME_PATH . '/css/sidebar.css', false );
        wp_enqueue_style('theme.css', THEME_PATH . '/css/theme.css', false );


    }else
    {
        wp_enqueue_style('404', THEME_PATH . '/css/404.css', false );
    }
}

//Register Front-End Scripts
function register_front_end_scripts()
{
    wp_enqueue_script('jquery');

    wp_deregister_script('bootstrap');
    wp_register_script('bootstrap', THEME_PATH . '/js/bootstrap.js', false, '2.3.1', $in_footer=true);
    wp_enqueue_script('bootstrap');
    wp_deregister_script('off-canvas');
    wp_register_script('off-canvas', THEME_PATH . '/js/off-canvas.js', false, false, $in_footer=true);
    wp_enqueue_script('off-canvas');


}

?>