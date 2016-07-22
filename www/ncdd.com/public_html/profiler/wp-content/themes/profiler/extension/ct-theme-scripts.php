<?php
add_action('init', 'register_theme_scripts_ct');
function register_theme_scripts_ct()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php') {

        if (is_admin()) {

            add_action('admin_enqueue_scripts','register_back_end_ct');

        } else {

            add_action('wp_enqueue_scripts', 'register_front_end_styles_ct');
            add_action('wp_enqueue_scripts', 'register_front_end_scripts_ct');

        }
    }
}
//Register back-end
function register_back_end_ct(){

    wp_enqueue_style('tz-options', THEME_PATH . '/extension/assets/css/tz-options.css');

    wp_register_script('tz-option', THEME_PATH . '/extension/assets/js/tz-option.js', false, '1.0', $in_footer=true);
    wp_enqueue_script('tz-option');

}
//Register Front-End Styles
function register_front_end_styles_ct()
{
    $css_option               =    ot_get_option(THEME_PREFIX.'_TzGlobalOptionCss','0');
    if($css_option == '1'){
        wp_enqueue_style('customcss', THEME_PATH . '/css/custom/custom_profiler_css.css');
    }

    if(!is_404()) {
        wp_enqueue_style('tzportfolio', THEME_PATH . '/css/tzportfolio.css');
        wp_enqueue_style('OpenSansRegular', THEME_PATH . '/fonts/OpenSansRegular/stylesheet.css');
        wp_enqueue_style('OpenSansSemibold', THEME_PATH . '/fonts/OpenSansSemibold/stylesheet.css');
        wp_enqueue_style('OpenSansLightItalic', THEME_PATH . '/fonts/OpenSansLightItalic/stylesheet.css');
        wp_enqueue_style('bebas_neueregular', THEME_PATH . '/fonts/bebas_neueregular/stylesheet.css');
        wp_enqueue_style('supersized', THEME_PATH . '/css/supersized.css');
        wp_enqueue_style('supersized.shutter', THEME_PATH . '/css/supersized.shutter.css');
        wp_enqueue_style('responsive767', THEME_PATH . '/css/responsive767.css');
        wp_enqueue_style('responsive480', THEME_PATH . '/css/responsive480.css');

        if ( is_page_template('template-portfolio.php') ) :
            wp_enqueue_style('isotope', THEME_PATH . '/css/isotope.css');

        endif;
        if ( is_single() ):
            wp_enqueue_style('single-portfolio', THEME_PATH . '/css/single-portfolio.css');
            wp_enqueue_style('flexslider', THEME_PATH . '/css/flexslider.css');
        endif;
        if ( is_single() && !is_singular('portfolio')):
            wp_enqueue_style('single', THEME_PATH . '/css/single.css');
        endif;

        if ( ( is_archive() || is_search() || is_page() ) && !is_page_template('template-portfolio.php') ):
            wp_enqueue_style('archive', THEME_PATH . '/css/archive.css');
        endif;
        if( is_home() && !is_page_template('template-portfolio.php') ) :
            wp_enqueue_style('archive', THEME_PATH . '/css/archive.css');
        endif;

        if ( is_page() && !is_page_template('template-portfolio.php') ):
            wp_enqueue_style('custom-page', THEME_PATH . '/css/custom-page.css');
        endif;

        wp_enqueue_style('template', THEME_PATH . '/css/template.css');
        wp_enqueue_style('megamenu', THEME_PATH . '/css/megamenu.css');
        wp_enqueue_style('megamenu-responsive', THEME_PATH . '/css/megamenu-responsive.css');
        wp_enqueue_style('shortcode', THEME_PATH . '/css/shortcode.css');
        wp_enqueue_style('megamenu-theme', THEME_PATH . '/css/megamenu-theme.css');
        wp_enqueue_style('custom_theme', THEME_PATH . '/css/custom_theme.css');



    }
}

//Register Front-End Scripts
function register_front_end_scripts_ct()
{
    wp_deregister_script('shortcode');
    wp_register_script('shortcode', THEME_PATH . '/js/shortcode.js', false,false, $in_footer=true);
    wp_enqueue_script('shortcode');

    wp_deregister_script('jquery.easing.min');
    wp_register_script('jquery.easing.min', THEME_PATH . '/js/jquery.easing.min.js', false,false, $in_footer=true);
    wp_enqueue_script('jquery.easing.min');

    // gallery

    $status               =    ot_get_option(THEME_PREFIX. '_status_gallery','show');
    if ( $status == 'show' ):

    wp_deregister_script('supersized.3.2.7');
    wp_register_script('supersized.3.2.7', THEME_PATH . '/js/supersized.3.2.7.js', false,false, $in_footer=false);
    wp_enqueue_script('supersized.3.2.7');

    wp_deregister_script('supersized.shutter');
    wp_register_script('supersized.shutter', THEME_PATH . '/js/supersized.shutter.js', false,false, $in_footer=false);
    wp_enqueue_script('supersized.shutter');
     endif;

    wp_deregister_script('jquery.tinyscrollbar.min');
    wp_register_script('jquery.tinyscrollbar.min', THEME_PATH . '/js/jquery.tinyscrollbar.min.js', false,false, $in_footer=true);
    wp_enqueue_script('jquery.tinyscrollbar.min');


    wp_deregister_script('custom_theme');
    wp_register_script('custom_theme', THEME_PATH . '/js/custom_theme.js', false,false, $in_footer=true);
    wp_enqueue_script('custom_theme');


    if ( ( is_archive() || is_search() || is_page() || is_home()) && !is_page_template('template-portfolio.php') ):

        wp_deregister_script('script');
        wp_register_script('script', THEME_PATH . '/js/script.js', false,false, $in_footer=true);
        wp_enqueue_script('script');

        wp_deregister_script('menu');
        wp_register_script('menu', THEME_PATH . '/js/menu.js', false,false, $in_footer=true);
        wp_enqueue_script('menu');

        wp_deregister_script('page');
        wp_register_script('page', THEME_PATH . '/js/page.js', false,false, $in_footer=true);
        wp_enqueue_script('page');

        wp_deregister_script('profile_script_resize');
        wp_register_script('profile_script_resize', THEME_PATH . '/js/profile_script_resize.js', false,false, $in_footer=true);
        wp_enqueue_script('profile_script_resize');
    endif;


    if ( is_page_template('template-portfolio.php') ) :

        wp_deregister_script('script');
        wp_register_script('script', THEME_PATH . '/js/script.js', false,false, $in_footer=true);
        wp_enqueue_script('script');

        wp_deregister_script('menu');
        wp_register_script('menu', THEME_PATH . '/js/menu.js', false,false, $in_footer=true);
        wp_enqueue_script('menu');

        wp_deregister_script('page');
        wp_register_script('page', THEME_PATH . '/js/page.js', false,false, $in_footer=true);
        wp_enqueue_script('page');

        wp_deregister_script('flatui-checkbox');
        wp_register_script('flatui-checkbox', THEME_PATH . '/js/flatui-checkbox.js', false,false, $in_footer=true);
        wp_enqueue_script('flatui-checkbox');

        wp_deregister_script('flatui-radio');
        wp_register_script('flatui-radio', THEME_PATH . '/js/flatui-radio.js', false,false, $in_footer=true);
        wp_enqueue_script('flatui-radio');

        wp_deregister_script('resizeimage');
        wp_register_script('resizeimage', THEME_PATH . '/js/resizeimage.js', false,false, $in_footer=true);
        wp_enqueue_script('resizeimage');

        wp_deregister_script('tz_profiler');
        wp_register_script('tz_profiler', THEME_PATH . '/js/tz_profiler.js', false,false, $in_footer=true);
        wp_enqueue_script('tz_profiler');


        wp_deregister_script('jquery.isotope.min');
        wp_register_script('jquery.isotope.min', THEME_PATH . '/js/jquery.isotope.min.js', false,false, $in_footer=true);
        wp_enqueue_script('jquery.isotope.min');

        wp_deregister_script('html5.min');
        wp_register_script('html5.min', THEME_PATH . '/js/html5.min.js', false,false, $in_footer=true);
        wp_enqueue_script('html5.min');

        wp_deregister_script('jquery.infinitescroll.min');
        wp_register_script('jquery.infinitescroll.min', THEME_PATH . '/js/jquery.infinitescroll.min.js', false,false, $in_footer=true);
        wp_enqueue_script('jquery.infinitescroll.min');

        wp_deregister_script('profile_script_resize');
        wp_register_script('profile_script_resize', THEME_PATH . '/js/profile_script_resize.js', false,false, $in_footer=true);
        wp_enqueue_script('profile_script_resize');

        wp_deregister_script('portfolio');
        wp_register_script('portfolio', THEME_PATH . '/js/portfolio.js', false,false, $in_footer=true);
        wp_enqueue_script('portfolio');

        $width    = ot_get_option( THEME_PREFIX .'_TZPortfoliowidth',310 ) ;
        $loadmore = ot_get_option( THEME_PREFIX .'_TZPortfolioimage' ) ;
        $textload = ot_get_option( THEME_PREFIX .'_TZPortfolioendload' ) ;
        $tzvar   = array(
                    'width' =>  $width,
                    'image' =>  $loadmore,
                    'text'  =>  $textload
                );
        wp_localize_script('portfolio','tzvar',$tzvar) ;

    endif; // endif template portfolio

    if ( is_single() ):

        wp_deregister_script('script');
        wp_register_script('script', THEME_PATH . '/js/script.js', false,false, $in_footer=true);
        wp_enqueue_script('script');

        wp_deregister_script('menu');
        wp_register_script('menu', THEME_PATH . '/js/menu.js', false,false, $in_footer=true);
        wp_enqueue_script('menu');

        wp_deregister_script('page');
        wp_register_script('page', THEME_PATH . '/js/page.js', false,false, $in_footer=true);
        wp_enqueue_script('page');

        wp_deregister_script('profile_script_resize');
        wp_register_script('profile_script_resize', THEME_PATH . '/js/profile_script_resize.js', false,false, $in_footer=true);
        wp_enqueue_script('profile_script_resize');

        wp_deregister_script('widgets');
        wp_register_script('widgets', THEME_PATH . '/js/widgets.js', false, false, $in_footer=true);
        wp_enqueue_script('widgets');

        wp_deregister_script('jquery.flexslider');
        wp_register_script('jquery.flexslider', THEME_PATH . '/js/jquery.flexslider.js', false,false, $in_footer=true);
        wp_enqueue_script('jquery.flexslider');

        wp_deregister_script('single');
        wp_register_script('single', THEME_PATH . '/js/single.js', false,false, $in_footer=true);
        wp_enqueue_script('single');

    endif;

     if (   is_single() && !is_singular('portfolio') ):
         wp_deregister_script('comment-single');
         wp_register_script('comment-single', THEME_PATH . '/js/comment-single.js', false,false, $in_footer=true);
         wp_enqueue_script('comment-single');
     endif;



}

?>