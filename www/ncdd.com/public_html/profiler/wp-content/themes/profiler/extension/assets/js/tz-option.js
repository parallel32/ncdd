jQuery(document).ready(function(){
    if ( jQuery('#page_template').val() == 'template-portfolio.php' ) {
        jQuery('#page_meta_box').css("display","block");
    }
    jQuery('#page_template').change(function(){
        if ( jQuery(this).val() == 'template-portfolio.php' ){

            jQuery('#page_meta_box').slideDown();

        }else{
            jQuery('#page_meta_box').slideUp();
        }
    }) ;

    /*  Theme Color  */
    var sidebarleft   = jQuery('#setting_plazart_TZThemeColorsidebarleft_background,#setting_plazart_TZThemeColorsidebarleft_title,#setting_plazart_TZThemeColorsidebarleft_fontcolor,#setting_plazart_TZThemeColorsidebarleft_bordercolor,#setting_plazart_TZThemeColorsidebarleft_social_background,#setting_plazart_TZThemeColorsidebarleft_social_fontcolor');
    var mainmenu        =   jQuery('#setting_plazart_TZThemeColormenu_bk,#setting_plazart_TZThemeColormenu_items,#setting_plazart_TZThemeColormenu_items_hover,#setting_plazart_TZThemeColormegamenu_bk,#setting_plazart_TZThemeColormegamenu_items,#setting_plazart_TZThemeColormegamenu_border');
    var maincontent     =   jQuery('#setting_plazart_TZThemeColorcontent_bk,#setting_plazart_TZThemeColorcontent_titlecolor,#setting_plazart_TZThemeColorcontent_fontcolor,#setting_plazart_TZThemeColorcontent_button_bk,#setting_plazart_TZThemeColorcontent_button_textcolor,#setting_plazart_TZThemeColorcontent_comment_border,#setting_plazart_TZThemeColorcontent_link_color');
    var sidebarright    =   jQuery('#setting_plazart_TZThemeColorsidebarright_bk,#setting_plazart_TZThemeColorsidebarright_fontcolor,#setting_plazart_TZThemeColorsidebarright_border,#setting_plazart_TZThemeColorsidebarright_link');
    var theme_color  = jQuery("#plazart_TZThemeColorcustom").attr('value');
    switch (theme_color){
        case 'default':
            jQuery('#setting_plazart_TZThemeColorbodybk').slideUp();
            jQuery('#setting_plazart_TZThemeColorbody_fontcolor').slideUp();
            jQuery('#setting_plazart_TZThemeColortype').slideUp();
            sidebarleft.slideUp();
            mainmenu.slideUp();
            maincontent.slideUp();
            sidebarright.slideUp();
            break;
        case 'custom':
            jQuery('#setting_plazart_TZThemeColorbodybk').slideDown();
            jQuery('#setting_plazart_TZThemeColorbody_fontcolor').slideDown();
            jQuery('#setting_plazart_TZThemeColortype').slideDown();

            /*  Theme Color Custom */
            var custom_color  = jQuery("#plazart_TZThemeColortype").attr('value');
            switch (custom_color){
                case 'sidebarleft':
                    sidebarleft.slideDown();
                    mainmenu.slideUp();
                    maincontent.slideUp();
                    sidebarright.slideUp();
                    break;
                case 'menu':
                    sidebarleft.slideUp();
                    mainmenu.slideDown();
                    maincontent.slideUp();
                    sidebarright.slideUp();
                    break;
                case 'maincontent':
                    sidebarleft.slideUp();
                    mainmenu.slideUp();
                    maincontent.slideDown();
                    sidebarright.slideUp();
                    break;
                case 'sidebarright':
                    sidebarleft.slideUp();
                    mainmenu.slideUp();
                    maincontent.slideUp();
                    sidebarright.slideDown();
                    break;
            }

            jQuery("#plazart_TZThemeColortype").change(function(){

                var custom_color_change  = jQuery("#plazart_TZThemeColortype").attr('value');
                switch (custom_color_change){
                    case 'sidebarleft':
                        sidebarleft.slideDown();
                        mainmenu.slideUp();
                        maincontent.slideUp();
                        sidebarright.slideUp();
                        break;
                    case 'menu':
                        sidebarleft.slideUp();
                        mainmenu.slideDown();
                        maincontent.slideUp();
                        sidebarright.slideUp();
                        break;
                    case 'maincontent':
                        sidebarleft.slideUp();
                        mainmenu.slideUp();
                        maincontent.slideDown();
                        sidebarright.slideUp();
                        break;
                    case 'sidebarright':
                        sidebarleft.slideUp();
                        mainmenu.slideUp();
                        maincontent.slideUp();
                        sidebarright.slideDown();
                        break;
                }
            });
            break;
    }

    jQuery("#plazart_TZThemeColorcustom").change(function(){

        var theme_color_change  = jQuery("#plazart_TZThemeColorcustom").attr('value');
        switch (theme_color_change){
            case 'default':
                jQuery('#setting_plazart_TZThemeColorbodybk').slideUp();
                jQuery('#setting_plazart_TZThemeColorbody_fontcolor').slideUp();
                jQuery('#setting_plazart_TZThemeColortype').slideUp();
                sidebarleft.slideUp();
                mainmenu.slideUp();
                maincontent.slideUp();
                sidebarright.slideUp();
                break;
            case 'custom':
                jQuery('#setting_plazart_TZThemeColorbodybk').slideDown();
                jQuery('#setting_plazart_TZThemeColorbody_fontcolor').slideDown();
                jQuery('#setting_plazart_TZThemeColortype').slideDown();

                /*  Theme Color Custom */
                var custom_color  = jQuery("#plazart_TZThemeColortype").attr('value');
                switch (custom_color){
                    case 'sidebarleft':
                        sidebarleft.slideDown();
                        mainmenu.slideUp();
                        maincontent.slideUp();
                        sidebarright.slideUp();
                        break;
                    case 'menu':
                        sidebarleft.slideUp();
                        mainmenu.slideDown();
                        maincontent.slideUp();
                        sidebarright.slideUp();
                        break;
                    case 'maincontent':
                        sidebarleft.slideUp();
                        mainmenu.slideUp();
                        maincontent.slideDown();
                        sidebarright.slideUp();
                        break;
                    case 'sidebarright':
                        sidebarleft.slideUp();
                        mainmenu.slideUp();
                        maincontent.slideUp();
                        sidebarright.slideDown();
                        break;
                }

                jQuery("#plazart_TZThemeColortype").change(function(){

                    var custom_color_change  = jQuery("#plazart_TZThemeColortype").attr('value');
                    switch (custom_color_change){
                        case 'sidebarleft':
                            sidebarleft.slideDown();
                            mainmenu.slideUp();
                            maincontent.slideUp();
                            sidebarright.slideUp();
                            break;
                        case 'menu':
                            sidebarleft.slideUp();
                            mainmenu.slideDown();
                            maincontent.slideUp();
                            sidebarright.slideUp();
                            break;
                        case 'maincontent':
                            sidebarleft.slideUp();
                            mainmenu.slideUp();
                            maincontent.slideDown();
                            sidebarright.slideUp();
                            break;
                        case 'sidebarright':
                            sidebarleft.slideUp();
                            mainmenu.slideUp();
                            maincontent.slideUp();
                            sidebarright.slideDown();
                            break;
                    }
                });
                break;
        }
    });



});