<?php

require_once( 'functions-plazat.php' );

/*
 * Method add ot_get_option
 */

if(!is_admin()):

    if ( ! function_exists( 'ot_get_option' ) ) {
        function ot_get_option( $option_id, $default = '' ) {
            /* get the saved options */
            $options = get_option( 'option_tree' );
            /* look for the saved value */
            if ( isset( $options[$option_id] ) && '' != $options[$option_id] ) {
                return $options[$option_id];
            }
            return $default;
        }
    }
    if(function_exists('ot_get_option')){

    /*===================================
     * Blog
     ====================================*/
    $TZcategorysidebar           =   ot_get_option(THEME_PREFIX . '_sidebarcat','show');
    $TZtagsidebar                =   ot_get_option(THEME_PREFIX . '_sidebartag','show');
    $TZauthorsidebar             =   ot_get_option(THEME_PREFIX . '_sidebarauthor','show');



    /*===================================
     * Global Option
     ===================================*/

    $showtootbaradmin     =   ot_get_option(THEME_PREFIX.'_TzGlobalOptionAdmin');
    $googAnlytice         =   ot_get_option(THEME_PREFIX . '_google_analytics');



    }


endif;



/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
    $content_width = 900;


/*
 * Adds JavaScript to pages with the comment form to support
 * sites with threaded comments (when in use).
 */
if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );


if (isset($googAnlytice) && $googAnlytice != '') {
    add_action('wp_footer', 'add_google_analytics_code');
}
function add_google_analytics_code() {
    echo '<script type="text/javascript">';
    echo ot_get_option(THEME_PREFIX . '_google_analytics');
    echo '</script>';
}

/*
 * Method limit excerpt
 */
function limitexcerpt($lenght){
    return ot_get_option(THEME_PREFIX.'_porlimitexcerpt',50) ;
}
add_filter('excerpt_length','limitexcerpt');

/*
 * Methor support author for portoflio
 */
add_filter('posts_where', 'include_for_author');
function include_for_author($where){
    if(is_author())
        $where = str_replace(".post_type = 'post'", ".post_type in ('post', 'portfolio')", $where);

    return $where;
}

/*
 *  Method show or hide toolbar admin
 */
if(isset($showtootbaradmin) && $showtootbaradmin=='0'){
    add_filter('show_admin_bar', '__return_false');
}


function profiler_CustomCss($data='', $prefix='css') {
    $tem_path = get_template_directory();
    $folder_path=$tem_path."/css/custom";
    if (!is_dir($folder_path)) {
        wp_mkdir_p($folder_path);
        @chmod($folder_path, 0755);
    }
    $filename_css = $prefix.'-' . substr(md5($data), 0, 15) . '.css';
    $filename ='custom_profiler_css.css';
    $filepart = $folder_path . '/' . $filename;
    $filepart_css = $folder_path . '/' . $filename_css;

    $filetime = file_exists($filepart_css);
    if($filetime==false){

        foreach (glob(''.$folder_path.'/*.css') as $filenames) {
            if($filenames != $filepart_css){
//                unlink($filenames);
            }
        }
        global $wp_filesystem;
// Initialize the WP filesystem, no more using 'file-put-contents' function
        if (empty($wp_filesystem)) {
            require_once (ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        if(!$wp_filesystem->put_contents( $filepart, $data, 0644) ) {
            return esc_html__('Failed to create css file', TEXT_DOMAIN );
        }
    }
}

/* Function hex--rgba */
function profiler_hex2rgb($hex,$o) {
    $hex = str_replace("#", "", $hex);

    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgba = array($r, $g, $b,$o);
    return implode(",", $rgba); // returns the rgba values separated by commas
//                                return $rgb; // returns an array with the rgb values
}

?>