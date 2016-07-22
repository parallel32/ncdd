<?php
    /*
     * Method process option
     * # option 1: config font
     * # option 2: process config theme
    */
    if(!is_admin()):


        add_action('wp_head','portoflio_config_theme');

        function portoflio_config_theme()
        {
            $styles = '';
            $styles .= '/**
 * 1.0 - Reset
 * -----------------------------------------------------------------------------
 */
 ';

            // method body font
            $tzfonttype = ot_get_option(THEME_PREFIX . '_TZFontType', 'TzFontSquirrel');
            $tzfontbodyurl = ot_get_option(THEME_PREFIX . '_TzFontFami');
            $tzbodyfamiy = ot_get_option(THEME_PREFIX . '_TzFontFaminy');
            $bodyselecter = ot_get_option(THEME_PREFIX . '_TzBodySelecter');
            $TzFontDefault = ot_get_option(THEME_PREFIX . '_TzFontDefault', 'Arial');
            $TzbodyfontColor = ot_get_option(THEME_PREFIX . '_TzBodyColor');


            switch ($tzfonttype) {
                case'Tzgoogle':
                    $tzfont = $tzbodyfamiy;
                    break;
                default:
                    $tzfont = $TzFontDefault;
                    break;

            }
            // Method header font
            $tzheadertype = ot_get_option(THEME_PREFIX . '_TZFontTypeHead', 'TzFontDefault');               // type font google or defaul
            $tzheaderurl = ot_get_option(THEME_PREFIX . '_TzFontHeadGoodurl');                            //  url google font
            $tzheaderfamily = ot_get_option(THEME_PREFIX . '_TzFontFaminyHead');                             //  font family google       //  font squireel
            $tzheaderselecter = ot_get_option(THEME_PREFIX . '_TzHeadSelecter');                               //  body selecter
            $TzFHeadDefault = ot_get_option(THEME_PREFIX . '_TzFontHeadDefault', 'Arial');                     //  font standard
            $tzheaderfontcolor = ot_get_option(THEME_PREFIX . '_TzHeaderFontColor');

            switch ($tzheadertype) {
                case'Tzgoogle':
                    $tzheaderfont = $tzheaderfamily;
                    break;
                default:
                    $tzheaderfont = "'" . $TzFHeadDefault . "'";
                    break;
            }
            // Method Menu font
            $tzmenutype = ot_get_option(THEME_PREFIX . '_TZFontTypeMenu', 'TzFontDefault');
            $tzmenuurl = ot_get_option(THEME_PREFIX . '_TzFontMenuGoodurl');
            $tzmenufamily = ot_get_option(THEME_PREFIX . '_TzFontFaminyMenu');
            $tzmenuselecter = ot_get_option(THEME_PREFIX . '_TzMenuSelecter');
            $tzmenudefault = ot_get_option(THEME_PREFIX . '_TzFontMenuDefault', 'Arial');
            $tzmenusecolor = ot_get_option(THEME_PREFIX . '_TzMenuFontColor');
            switch ($tzmenutype) {
                case'Tzgoogle':
                    $tzmenufont = $tzmenufamily;
                    break;
                default:
                    $tzmenufont = "'" . $tzmenudefault . "'";
                    break;

            }
            // Method Custom font
            $tzcustomtype = ot_get_option(THEME_PREFIX . '_TZFontTypeCustom', 'TzFontDefault');
            $tzcustomurl = ot_get_option(THEME_PREFIX . '_TzFontCustomGoodurl');
            $tzcustomfamily = ot_get_option(THEME_PREFIX . '_TzFontFaminyCustom');
            $tzcustomselecter = ot_get_option(THEME_PREFIX . '_TzCustomSelecter');
            $TzFCustomDefault = ot_get_option(THEME_PREFIX . '_TzFontCustomDefault', 'Arial');
            $tzcustomcolor = ot_get_option(THEME_PREFIX . '_TzCustomFontColor');
            switch ($tzcustomtype) {
                case'Tzgoogle':
                    $tzcustomfont = $tzcustomfamily;
                    break;
                default:
                    $tzcustomfont = "'" . $TzFCustomDefault . "'";
                    break;
            }

            // add code css
            $tzcsscode = ot_get_option(THEME_PREFIX . '_TzCustomCss', '');
            // end custom font
            if (isset ($tzfontbodyurl) && $tzfontbodyurl != "") {
                wp_enqueue_style('google-font', $tzfontbodyurl, false);
            }
            if (isset ($tzheaderurl) && $tzheaderurl != "") {
                wp_enqueue_style('header-font', $tzheaderurl, false);
            }
            if (isset ($tzmenuurl) && $tzmenuurl != "") {
                wp_enqueue_style('menu-font', $tzmenuurl, false);
            }
            if (isset ($tzcustomurl) && $tzcustomurl != "") {
                wp_enqueue_style('custom-font', $tzcustomurl, false);
            }


            //Background
            $default_background_type = ot_get_option(THEME_PREFIX . '_background_type');
            $default_color = ot_get_option(THEME_PREFIX . '_TZBackgroundColor', '#ffffff');
            $default_pattern = ot_get_option(THEME_PREFIX . '_background_pattern');
            $default_single_image = ot_get_option(THEME_PREFIX . '_background_single_image');
            $background = '';
            switch ($default_background_type) {
                case 'pattern':
                    $background = 'body#bd {background: url("' . THEME_PATH . '/images/patterns/' . $default_pattern . '") repeat scroll 0 0 transparent !important;}';
                    break;
                case 'single_image':
                    $background = 'body#bd {background: url("' . $default_single_image . '") no-repeat fixed center center / cover transparent !important;}';
                    break;
                case 'none':
                    $background = 'body#bd {background: ' . $default_color . ' !important;}';
                    break;
                default:
                    $background = 'body#bd {background: ' . $default_color . ' !important;}';
                    break;
            }

            // logo
            $colorlogo = ot_get_option(THEME_PREFIX . '_logoTextcolor');


            //  Theme Color
            $themecolor             = ot_get_option(THEME_PREFIX . '_TZThemeColorcustom');

            /* Sidebar Left */
            $sidebarleft_bk                 =   ot_get_option(THEME_PREFIX . '_TZThemeColorsidebarleft_background');
            $sidebarleft_title              =   ot_get_option(THEME_PREFIX . '_TZThemeColorsidebarleft_title');
            $sidebarleft_fontcolor          =   ot_get_option(THEME_PREFIX . '_TZThemeColorsidebarleft_fontcolor');
            $sidebarleft_border             =   ot_get_option(THEME_PREFIX . '_TZThemeColorsidebarleft_bordercolor');
            $sidebarleft_social_bk          =   ot_get_option(THEME_PREFIX . '_TZThemeColorsidebarleft_social_background');
            $sidebarleft_social_fontcolor   =   ot_get_option(THEME_PREFIX . '_TZThemeColorsidebarleft_social_fontcolor');

            /* Menu Color */
            $menu_bk                =   ot_get_option(THEME_PREFIX . '_TZThemeColormenu_bk');
            $menu_items             =   ot_get_option(THEME_PREFIX . '_TZThemeColormenu_items');
            $menu_items_hover       =   ot_get_option(THEME_PREFIX . '_TZThemeColormenu_items_hover');
            $megamenu_bk            =   ot_get_option(THEME_PREFIX . '_TZThemeColormegamenu_bk');
            $megamenu_items         =   ot_get_option(THEME_PREFIX . '_TZThemeColormegamenu_items');
            $megamenu_border        =   ot_get_option(THEME_PREFIX . '_TZThemeColormegamenu_border');


            /* Content Color */
            $content_bk                 =   ot_get_option(THEME_PREFIX . '_TZThemeColorcontent_bk');
            $content_title              =   ot_get_option(THEME_PREFIX . '_TZThemeColorcontent_titlecolor');
            $content_fontcolor          =   ot_get_option(THEME_PREFIX . '_TZThemeColorcontent_fontcolor');
            $content_button_bk          =   ot_get_option(THEME_PREFIX . '_TZThemeColorcontent_button_bk');
            $content_button_text        =   ot_get_option(THEME_PREFIX . '_TZThemeColorcontent_button_textcolor');
            $content_comment            =   ot_get_option(THEME_PREFIX . '_TZThemeColorcontent_comment_border');
            $content_link               =   ot_get_option(THEME_PREFIX . '_TZThemeColorcontent_link_color');

            /* Sidebar Right */
            $sidebarright_bk                 =   ot_get_option(THEME_PREFIX . '_TZThemeColorsidebarright_bk');
            $sidebarright_fontcolor                 =   ot_get_option(THEME_PREFIX . '_TZThemeColorsidebarright_fontcolor');
            $sidebarright_border                 =   ot_get_option(THEME_PREFIX . '_TZThemeColorsidebarright_border');
            $sidebarright_link                 =   ot_get_option(THEME_PREFIX . '_TZThemeColorsidebarright_link');


            if (isset($themecolor) && $themecolor == 'custom') {
                /* Sidebar Left Background Color */
                if (isset($sidebarleft_bk) && $sidebarleft_bk != '') {
                    $styles .= '
                    body #sidebar-left .sidebar-nav{
                        background-color:' . esc_attr($sidebarleft_bk) . '!important;
                    }';
                };
                /* Sidebar Left Title Color */
                if (isset($sidebarleft_title) && $sidebarleft_title != '') {
                    $styles .= '
                    body .custombox_profile h3,
                    body #sidebar-left h3.module-title span{
                        color:' . esc_attr($sidebarleft_title) . '!important;
                    }';
                };
                /* Sidebar Left Font Color */
                if (isset($sidebarleft_fontcolor) && $sidebarleft_fontcolor != '') {
                    $styles .= '
                    body #sidebar-left ul li a,
                    body .custombox_profile address,
                    body #sidebar-left aside p,
                    body .tzcontact-info li i,
                    body section#sidebar-left aside,
                    body #sidebar-left #searchsubmit,
                    body #sidebar-left .Tzsearchform{
                        color:' . esc_attr($sidebarleft_fontcolor) . '!important;
                    }';
                };
                /* Sidebar Left Border Color */
                if (isset($sidebarleft_border) && $sidebarleft_border != '') {
                    $styles .= '
                    body #sidebar-left .tz_social,
                    body #sidebar-left #searchsubmit,
                    body #sidebar-left .Tzsearchform{
                        border-color:' . esc_attr($sidebarleft_border) . '!important;
                    }
                    body #sidebar-left .Tzsearchform{
                        background-color: '. esc_attr($sidebarleft_border) .' !important;
                    }';
                };
                /* Sidebar Left Social Background Color */
                if (isset($sidebarleft_social_bk) && $sidebarleft_social_bk != '') {
                    $styles .= '
                    body #sidebar-left aside .tz_social li a{
                        background-color:' . esc_attr($sidebarleft_social_bk) . '!important;
                    }';
                };
                /* Sidebar Left Social Font Color */
                if (isset($sidebarleft_social_fontcolor) && $sidebarleft_social_fontcolor != '') {
                    $styles .= '
                    body #sidebar-left aside .tz_social li a{
                        color:' . esc_attr($sidebarleft_social_fontcolor) . '!important;
                    }';
                };
                /* Menu Background Color */
                if (isset($menu_bk) && $menu_bk != '') {
                    $styles .= '
                    body #tz_mainmenu,
                    .off-canvas div#off-canvas-nav .plazart-mainnav{
                        background-color:' . esc_attr($menu_bk) . '!important;
                    }';
                };
                /* Menu Items Color */
                if (isset($menu_items) && $menu_items != '') {
                    $styles .= '
                    body #tz_mainmenu #plazart-mainnav ul.level0 > li > a,
                    body .themeple_custom_menu_mega_menu ul li a.mega-group-title,
                    body .themeple_custom_menu_mega_menu li ul li a{
                        color:' . esc_attr($menu_items) . '!important;
                    }';
                };
                /* Menu Items Hover Color */
                if (isset($menu_items_hover) && $menu_items_hover != '') {
                    $styles .= '
                    body #tz_mainmenu #plazart-mainnav ul.level0 > li > a:hover,
                    body .themeple_custom_menu_mega_menu ul li a.mega-group-title:hover,
                    body .themeple_custom_menu_mega_menu li ul li a:hover,
                    body .nav > li > a:hover{
                        color:' . esc_attr($menu_items_hover) . '!important;
                        background: none !important;
                    }';
                };
                /* Mega Menu Background Color */
                if (isset($megamenu_bk) && $megamenu_bk != '') {
                    $styles .= '
                    body .themeple_custom_menu_mega_menu,
                    body .non_mega_menu,
                    body .non_mega_menu ul{
                        background-color:' . esc_attr($megamenu_bk) . '!important;
                    }';
                };
                /* Mega Menu Items Color */
                if (isset($megamenu_items) && $megamenu_items != '') {
                    $styles .= '
                    body .non_mega_menu li a,
                    body nav .themeple_custom_menu_mega_menu ul li a.mega-group-title,
                    body nav .themeple_custom_menu_mega_menu li ul li a,
                    body .non_mega_menu li a:hover,
                    body nav .themeple_custom_menu_mega_menu ul li a.mega-group-title:hover,
                    body nav .themeple_custom_menu_mega_menu li ul li a:hover{
                        color:' . esc_attr($megamenu_items) . '!important;
                    }';
                };
                /* Mega Menu Border Color */
                if (isset($megamenu_border) && $megamenu_border != '') {
                    $styles .= '
                    body .non_mega_menu,
                    body .non_mega_menu li a,
                    body .non_mega_menu li li a,
                    body .themeple_custom_menu_mega_menu,
                    body nav .themeple_custom_menu_mega_menu li ul li a,
                    body .non_mega_menu ul{
                        border-color:' . esc_attr($megamenu_border) . '!important;
                    }
                    body .non_mega_menu li:first-child li a{
                        border-top: 1px solid ' . esc_attr($megamenu_border) . '!important;
                    }
                    body .non_mega_menu li:first-child li:first-child a{
                        border-top: none !important;
                    }';
                };
                /* Content Background */
                if (isset($content_bk) && $content_bk != '') {
                    $styles .= '
                    body #tz-main #tz-content,
                    body .tzskill{
                        background-color:' . esc_attr($content_bk) . '!important;
                    }
                    body .plazart-megamenu ul .current-menu-item:before{
                        border-right-color:' . esc_attr($content_bk) . ';
                    }';
                };
                /* Content Title */
                if (isset($content_title) && $content_title != '') {
                    $styles .= '
                    body #tz-main #tz-component h1.page-title,
                    body #tz-main #tz-component .page-title,
                    body #tz-main #tz-component .TzBlogInner .TzArticleBlogInfo span.TzBlogCreate,
                    body #tz-main #tz-component .TzBlogInner h2.TzBlogTitle a,
                    body h1,body h2,body h3,body h4,body h5,body h6,
                    body .sh-title-contact,
                    body .dl-horizontal dd i,
                    body .dl-horizontal dd span,
                    body div.tz_news .tz_accordion h3.tz_title,
                    body .info_accordion,
                    body .TzItemPage,
                    body #TzContent #tz_options #filter > a,
                    body #tz-main #tz-component .TzLink h2.title,
                    body #tz-main #tz-component .TzLink h2.title a,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner .TzArticleInfo span.TzCreate,
                    body #tz-main #tz-component .TzPortfolioItemPage .TzItemPageInner .TzArticleInfo span.TzCreate,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner h1.TzArticleTitle,
                    body #tz-main #tz-component .TzPortfolioItemPage .TzItemPageInner h1.TzArticleTitle,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner .tz_portfolio_user .AuthorBlock .AuthorDetails h3 a,
                    body #tz-main #tz-component .TzPortfolioItemPage .TzItemPageInner .tz_portfolio_user .AuthorBlock .AuthorDetails h3 a,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner .TzRelated ul li a,
                    body #tz-main #tz-component .TzPortfolioItemPage .TzItemPageInner .TzRelated ul li a,
                    body #reply-title,
                    body .tz_portfolio_comment textarea,
                    body .tz_portfolio_comment input,
                    body .tab-sh-content .tab-pane,
                    body .Shortcode_myTab > li > a,
                    body #tz-mass-bottoms .box h3.header,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner #tz-mass-bottoms .box p{
                        color:' . esc_attr($content_title) . ' !important;
                    }
                    body #TzContent #tz_options #filter > a.selected,
                    body #TzContent #tz_options #filter > a:hover,
                    body .btn-dark,
                    body #TzContent #tz_options #filter > a.selected,
                    body #TzContent #tz_options #filter > a:hover,
                    body .Shortcode_myTab > .active > a,
                    body .Shortcode_myTab > .active > a:hover,
                    body .Shortcode_myTab > .active > a:focus{
                        background-color:' . esc_attr($content_title) . ' !important;
                    }
                    body #TzContent #tz_options #filter > a.selected,
                    body #TzContent #tz_options #filter > a:hover,
                    body #TzContent #tz_options #filter > a,
                    body .Shortcode_myTab > li > a{
                        border-color:' . esc_attr($content_title) . ' !important;
                    }';
                };
                /* Content Background */
                if (isset($content_fontcolor) && $content_fontcolor != '') {
                    $styles .= '
                    body #tz-content p,
                    body .line-block .date span,
                    body textarea,
                    body input[type="text"],
                    body input[type="password"],
                    body input[type="datetime"],
                    body input[type="datetime-local"],
                    body input[type="date"],
                    body input[type="month"],
                    body input[type="time"],
                    body input[type="week"],
                    body input[type="number"],
                    body input[type="email"],
                    body input[type="url"],
                    body input[type="search"],
                    body input[type="tel"],
                    body input[type="color"],
                    body .uneditable-input,
                    body .wpcf7-form-control,
                    body .tzskill,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner #tz-mass-bottom .box p{
                        color:' . esc_attr($content_fontcolor) . ';
                    }';
                };
                /* Content Button Background */
                if (isset($content_button_bk) && $content_button_bk != '') {
                    $styles .= '
                    body .progress .bar,
                    body .wpcf7-form .wpcf7-submit,
                    body .btn.btn-cyan,
                    body .tz_portfolio_comment #commentform #submit,
                    body .btn.btn-primary{
                        background-color:' . esc_attr($content_button_bk) . '!important;
                    }';
                };
                /* Content Button Text */
                if (isset($content_button_text) && $content_button_text != '') {
                    $styles .= '
                    body .wpcf7-form .wpcf7-submit,
                    body .line-block .content-date,
                    body #TzContent #tz_options #filter > a.selected,
                    body #TzContent #tz_options #filter > a:hover,
                    body .btn.btn-cyan,
                    body div#tz_append a:hover,
                    body .tz_portfolio_comment #commentform #submit,
                    body .Shortcode_myTab > .active > a,
                    body .Shortcode_myTab > .active > a:hover,
                    body .Shortcode_myTab > .active > a:focus,
                    body .btn.btn-primary{
                        color:' . esc_attr($content_button_text) . '!important;
                    }
                    body #TzContent #tz_options #filter > a,
                    body .box.box-padding,
                    body .bg-white{
                        background-color:' . esc_attr($content_button_text) . '!important;
                    }
                    body .Shortcode_myTab > .active > a,
                    body .Shortcode_myTab > .active > a:hover,
                    body .Shortcode_myTab > .active > a:focus{
                        border-color:' . esc_attr($content_button_text) . '!important;
                    }';
                };
                /* Content Comment & Border */
                if (isset($content_comment) && $content_comment != '') {
                    $styles .= '
                    body .tz_portfolio_comment textarea,
                    body .tz_portfolio_comment input{
                        background-color:' . esc_attr($content_comment) . '!important;
                    }
                    body .tz_portfolio_comment textarea,
                    body .tz_portfolio_comment input,
                    body .Shortcode_myTab,
                    body .h3content,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner .tz_portfolio_like_button .TzLikeButtonInner,
                    body #tz-main #tz-component .TzPortfolioItemPage .TzItemPageInner .tz_portfolio_like_button .TzLikeButtonInner,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner .TzRelated,
                    body #tz-main #tz-component .TzPortfolioItemPage .TzItemPageInner .TzRelated,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner .tz_portfolio_comment,
                    body #tz-main #tz-component .TzPortfolioItemPage .TzItemPageInner .tz_portfolio_comment,
                    body div.tz_news .tz_accordion h3.tz_title,
                    body .box.box-padding{
                        border-color:' . esc_attr($content_comment) . '!important;
                    }';
                };
                /* Content Link */
                if (isset($content_link) && $content_link != '') {
                    $styles .= '
                    body #tz-main #tz-component .TzBlogInner .TzArticleBlogInfo span a,
                    body #tz-main #tz-component .TzBlogInner .TzArticleBlogInfo span i,
                    body .TZCommentCount, .TzPortfolioCommentCount,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner .TzArticleInfo span i,
                    body #tz-main #tz-component .TzPortfolioItemPage .TzItemPageInner .TzArticleInfo span i,
                    body #tz-main #tz-component .TzItemPage .TzItemPageInner .tz_portfolio_like_button .TzLikeButtonInner .TzLikeQuestion,
                    body #tz-main #tz-component .TzPortfolioItemPage .TzItemPageInner .tz_portfolio_like_button .TzLikeButtonInner .TzLikeQuestion,
                    body .TzItemPage a,
                    body .TzPortfolioItemPage a{
                        color:' . esc_attr($content_link) . '!important;
                    }';
                };
                /* Sidebar Right Background */
                if (isset($sidebarright_bk) && $sidebarright_bk != '') {
                    $styles .= '
                    body #sidebar-right,
                    body #sidebar-right .sidebar-nav{
                        background-color:' . esc_attr($sidebarright_bk) . '!important;
                    }';
                };
                if (isset($sidebarright_fontcolor) && $sidebarright_fontcolor != '') {
                    $styles .= '
                    body #sidebar-right,
                    body .tzblog-sidebar aside ul li a,
                    body .tagcloud a,
                    body .tweet-content{
                        color:' . esc_attr($sidebarright_fontcolor) . '!important;
                    }';
                };
                if (isset($sidebarright_border) && $sidebarright_border != '') {
                    $styles .= '
                    body .tagcloud a{
                        border-color:' . esc_attr($sidebarright_border) . '!important;
                    }';
                };
                if (isset($sidebarright_link) && $sidebarright_link != '') {
                    $styles .= '
                    body a.user,
                    body a.user .name,
                    body a.user .screen_name,
                    body .tweet-item a{
                        color:' . esc_attr($sidebarright_link) . '!important;
                    }';
                };
            };
            ?>
                <style type="text/css">
                        <?php if(!empty($bodyselecter) && !empty($bodyselecter)){  echo $bodyselecter ; ?> { font-family:<?php echo $tzfont; ?> !important; color: <?php echo $TzbodyfontColor; ?> !important;   }
                        <?php } ?>

                        <?php if(!empty($tzheaderselecter) && !empty($tzheaderselecter)){  echo $tzheaderselecter ; ?> { font-family:<?php echo $tzheaderfont; ?> !important; color: <?php echo $tzheaderfontcolor; ?> !important; }
                        <?php }  ?>

                        <?php if(!empty($tzmenuselecter) && !empty($tzmenuselecter)){  echo $tzmenuselecter ; ?> { font-family:<?php echo $tzmenufont; ?> !important ; color: <?php echo $tzmenusecolor; ?> !important ;  }
                        <?php
                        } ?>

                        <?php if(!empty($tzcustomselecter) && !empty($tzcustomselecter)):  echo $tzcustomselecter ; ?> { font-family:<?php echo $tzcustomfont; ?> !important ; color: <?php echo $tzcustomcolor; ?> !important ; }
                        <?php endif; ?>

                    <?php if(isset($colorlogo) && !empty($colorlogo)): echo'.tz-logo-text{ color: '.$colorlogo.' }';  endif; ?>

                    /*social color*/
                    .tzsocialfont{
                        color: <?php echo ot_get_option(THEME_PREFIX . '_social_network_color','#a6a6a6'); ?> !important;
                    }
                    <?php

                        if($background){
                            echo $background;
                        }

                        if(isset($tzcsscode) && !empty($tzcsscode)){
                            echo $tzcsscode;
                        }

                        $css_option               =    ot_get_option(THEME_PREFIX.'_TzGlobalOptionCss','0');
                        if($css_option == '0'){
                            echo $styles;
                        }

                    ?>
                </style>

            <?php

            if(ot_get_option( THEME_PREFIX . '_favicon_onoff','no') == 'yes'){
                $plazart_favicon = ot_get_option(THEME_PREFIX . '_favicon');
                if( $plazart_favicon ){
                    echo '<link rel="shortcut icon" href="' . $plazart_favicon . '" type="image/x-icon" />';
                }
            }
            ?>

        <?php
            $css_option               =    ot_get_option(THEME_PREFIX.'_TzGlobalOptionCss','0');
            if($css_option == '1'){
                profiler_CustomCss($styles,'custom');
            }
        }

    endif

?>