<?php

/*
 *constants
 */

define('THEME_PREFIX', 'plazart');
define('THEME_NAME', 'profiler');
define('TEXT_DOMAIN', 'profiler');
define('THEME_VERSION', '1.0');
define('THEME_PATH', get_template_directory_uri());
define('SERVER_PATH', get_template_directory());

/**
 * Optional: set 'ot_show_pages' filter to false.
 * This will hide the settings & documentation pages.
 */
add_filter( 'ot_show_pages', '__return_false' );

/**
 * Optional: set 'ot_show_new_layout' filter to false.
 * This will hide the "New Layout" section on the Theme Options page.
 */
add_filter( 'ot_show_new_layout', '__return_false' );

/**
 * Required: set 'ot_theme_mode' filter to true.
 */
add_filter( 'ot_theme_mode', '__return_true' );


/**
 * Required: include OptionTree.
 */

load_template( trailingslashit( SERVER_PATH ) . 'option-tree/ot-loader.php' );

/**
 * Required: include Theme Options
 */
load_template( trailingslashit( SERVER_PATH ) . 'extension/theme-options.php' );

/**
 * Required: include custom post type
 */
load_template( trailingslashit( SERVER_PATH ) . 'extension/portfolio-post-type.php' );

/**
 * Required: include meta box for portfolio and post
 */
load_template( trailingslashit( SERVER_PATH ) . 'extension/portfolio-meta-boxes.php' );

/**
 * Required: include theme-functions
 */
load_template( trailingslashit( SERVER_PATH ) . 'extension/theme-functions.php' );

/**
 * Required: include plugin Aqua Resizer
 */
load_template( trailingslashit( SERVER_PATH ) . 'extension/system/aq_resizer.php' );

/**
 * Required: include plugin theme scripts
 */
load_template( trailingslashit( SERVER_PATH  ) . 'extension/system/theme-scripts.php' );
/**
 * Required: include plugin theme scripts
 */
load_template( trailingslashit( SERVER_PATH  ) . 'extension/ct-theme-scripts.php' );

/**
 * Required: include plugin theme sidebars
 */
load_template( trailingslashit( SERVER_PATH  ) . 'extension/theme-sidebars.php' );

/*
 * Required: include Shorcode
 */
load_template( trailingslashit( SERVER_PATH  ) . 'extension/shortcode.php' );

/*
 * Required: include Shorcode
 */
load_template( trailingslashit( SERVER_PATH  ) . 'extension/theme_support.php' );


/*
 * Required: include plugin theme scripts
 */
load_template( trailingslashit( SERVER_PATH  ) . 'extension/tz-process-option.php' );

/*
 * Required: widget contact info
 */
load_template( trailingslashit( SERVER_PATH  ) . 'extension/widgets/contact-info.php' );

/*
 * Required: widget view post
 */
load_template( trailingslashit( get_template_directory()  ) . 'extension/widgets/view-post.php' );
/*
 * Required: widget social
 */
load_template( trailingslashit( get_template_directory()  ) . 'extension/widgets/social.php' );
/*
 * Required: widget profile user
 */
load_template( trailingslashit( get_template_directory()  ) . 'extension/widgets/profile-user.php' );

/*
 * Required: megamenu
 */
require_once ('extension/system/megamenu/themeple_init.php');



/*
 * method load  portfolio-meta-boxes Scripts
 */
add_action('admin_head', 'portfolio_scripts');
function portfolio_scripts()
{
    if(is_admin()):
        ?>

    <style type="text/css">
        #portfolio_meta_box .format-setting-label {
            border: none;
            margin: 0;
        }
        #portfolio_meta_box .ot-metabox-wrapper .format-settings {
            margin-bottom: 15px;
        }
    </style>

    <?php
    endif;

}
/*
 *  method add global javascript variable THEME_PREFIX to admin_head
 */
function theme_prefix_addto_header() {
    ?>
<script type="text/javascript">
    var themeprefix = '<?php echo THEME_PREFIX ?>';
</script>
<?php
}
add_action('admin_head', 'theme_prefix_addto_header');
add_action('wp_head', 'theme_prefix_addto_header');


/*method activie plugin*/
require_once dirname( __FILE__ ) . '/plugins/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );
function my_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin pre-packaged with a theme

        // This is an example of how to include a plugin from the WordPress Plugin Repository
        array(
            'name'    => 'WP Pagenavi Plugin',
            'slug'    => 'wp-pagenavi',
            'required'  => true,
        ),
        array(
            'name'    => 'Contact Form 7',
            'slug'    => 'contact-form-7',
            'required'  => false,
        ),
        array(
            'name'    => 'Dw Twitter',
            'slug'    => 'dw-twitter',
            'required'  => false,
        ),

    );

    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'tgmpa';

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
        'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
        'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
        'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
        'menu'         		=> 'install-required-plugins', 	// Menu slug
        'has_notices'      	=> true,                       	// Show admin notices or not
        'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
        'message' 			=> '',							// Message to output right before the plugins table
        'strings'      		=> array(
            'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
            'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
            'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
            'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
            'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
            'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
            'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
            'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );

    tgmpa( $plugins, $config );

}
?>