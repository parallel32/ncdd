<?php
/*
 * The Header for our theme.
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="HandheldFriendly" content="true" />
    <meta name="apple-mobile-web-app-capable" content="YES" />
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <title><?php
        /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;

        wp_title( '|', true, 'right' );

        // Add the blog name.
        bloginfo( 'name' );

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) )
            echo " | $site_description";

        // Add a page number if necessary:
        if ( $paged >= 2 || $page >= 2 )
            echo ' | ' . sprintf( __( 'Page %s', TEXT_DOMAIN ), max( $paged, $page ) );

        ?>
    </title>


    <!--[if IE 8]>
    <link rel="stylesheet" href="<?php echo THEME_PATH.'/css/ie8.css' ?>" type="text/css" />
    <![endif]-->

    <!--[if lte IE 7]>
    <script src="<?php echo THEME_PATH.'/js/icon-font-ie7.js' ?>"></script>
    <![endif]-->

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="<?php echo THEME_PATH.'/js/html5.js' ?>"></script>
    <![endif]-->
    <!--[if IE]><script src="<?php echo THEME_PATH.'/js/html5.js' ?>"></script><![endif]-->

    <!-- For IE6-8 support of media query -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo THEME_PATH.'/js/respond.min.js' ?>"></script>
    <![endif]-->

    <?php wp_head(); ?>
</head>
<body id="bd" <?php body_class(); ?>>
<div id="ja">