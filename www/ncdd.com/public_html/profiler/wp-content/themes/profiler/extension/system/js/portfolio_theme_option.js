jQuery(document).ready(function(){

    // method body font
    var FontCheck2 = jQuery("#plazart_TZFontType").attr('value');
    switch (FontCheck2){
        case 'TzFontSquirrel':
            jQuery('#setting_plazart_TzFontSquirrel').css("display","block");
            break;
        case 'TzFontDefault':
            jQuery('#setting_plazart_TzFontDefault').css("display","block");

            break;
        case 'Tzgoogle':

            jQuery('#setting_plazart_TzFontFami').css("display","block");
            jQuery('#setting_plazart_TzFontFaminy').css("display","block");
            break;
    }

    jQuery("#plazart_TZFontType").change(function(){
        var FontCheck = jQuery("#plazart_TZFontType").attr('value');
        switch (FontCheck){
            case 'TzFontDefault':
                jQuery('#setting_plazart_TzFontDefault').slideDown();
                jQuery('#setting_plazart_TzFontSquirrel').slideUp();
                jQuery('#setting_plazart_TzFontFami').slideUp();
                jQuery('#setting_plazart_TzFontFaminy').slideUp();
                break;
            case 'Tzgoogle':
                jQuery('#setting_plazart_TzFontDefault').slideUp();
                jQuery('#setting_plazart_TzFontSquirrel').slideUp();
                jQuery('#setting_plazart_TzFontFami').slideDown();
                jQuery('#setting_plazart_TzFontFaminy').slideDown();
                break;
        }
    });


    // method header font
    var FontCheckHead = jQuery("#plazart_TZFontTypeHead").attr('value');
    switch (FontCheckHead){
        case 'TzFontDefault':
            jQuery('#setting_plazart_TzFontHeadDefault').css("display","block");
            break;
        case 'Tzgoogle':
            jQuery('#setting_plazart_TzFontHeadGoodurl').css("display","block");
            jQuery('#setting_plazart_TzFontFaminyHead').css("display","block");
            break;
    }

    jQuery("#plazart_TZFontTypeHead").change(function(){
        var FontCheckHead2 = jQuery("#plazart_TZFontTypeHead").attr('value');
        switch (FontCheckHead2){
            case 'TzFontDefault':
                jQuery('#setting_plazart_TzFontHeadDefault').slideDown();
                jQuery('#setting_plazart_TzFontHeadSquirrel').slideUp();
                jQuery('#setting_plazart_TzFontHeadGoodurl').slideUp();
                jQuery('#setting_plazart_TzFontFaminyHead').slideUp();
                break;
            case 'Tzgoogle':
                jQuery('#setting_plazart_TzFontHeadDefault').slideUp();
                jQuery('#setting_plazart_TzFontHeadSquirrel').slideUp();
                jQuery('#setting_plazart_TzFontHeadGoodurl').slideDown();
                jQuery('#setting_plazart_TzFontFaminyHead').slideDown();
                break;
        }
    });

    // method Menu font
    var FontCheckMenu= jQuery("#plazart_TZFontTypeMenu").attr('value');
    switch (FontCheckMenu){

        case 'TzFontDefault':
            jQuery('#setting_plazart_TzFontMenuDefault').css("display","block");

            break;
        case 'Tzgoogle':

            jQuery('#setting_plazart_TzFontMenuGoodurl').css("display","block");
            jQuery('#setting_plazart_TzFontFaminyMenu').css("display","block");
            break;
    }

    jQuery("#plazart_TZFontTypeMenu").change(function(){
        var FontCheckMenu2 = jQuery("#plazart_TZFontTypeMenu").attr('value');
        switch (FontCheckMenu2){

            case 'TzFontDefault':
                jQuery('#setting_plazart_TzFontMenuDefault').slideDown();
                jQuery('#setting_plazart_TzFontMenuSquirrel').slideUp();
                jQuery('#setting_plazart_TzFontMenuGoodurl').slideUp();
                jQuery('#setting_plazart_TzFontFaminyMenu').slideUp();
                break;
            case 'Tzgoogle':
                jQuery('#setting_plazart_TzFontMenuDefault').slideUp();
                jQuery('#setting_plazart_TzFontMenuSquirrel').slideUp();
                jQuery('#setting_plazart_TzFontMenuGoodurl').slideDown();
                jQuery('#setting_plazart_TzFontFaminyMenu').slideDown();
                break;
        }
    });

    // method custom font
    var FontCheckCustom= jQuery("#plazart_TZFontTypeCustom").attr('value');
    switch (FontCheckCustom){

        case 'TzFontDefault':
            jQuery('#setting_plazart_TzFontCustomDefault').css("display","block");

            break;
        case 'Tzgoogle':

            jQuery('#setting_plazart_TzFontCustomGoodurl').css("display","block");
            jQuery('#setting_plazart_TzFontFaminyCustom').css("display","block");
            break;
    }

    jQuery("#plazart_TZFontTypeCustom").change(function(){
        var FontCheckCustom2 = jQuery("#plazart_TZFontTypeCustom").attr('value');
        switch (FontCheckCustom2){

            case 'TzFontDefault':
                jQuery('#setting_plazart_TzFontCustomDefault').slideDown();
                jQuery('#setting_plazart_TzFontCustomSquirrel').slideUp();
                jQuery('#setting_plazart_TzFontCustomGoodurl').slideUp();
                jQuery('#setting_plazart_TzFontFaminyCustom').slideUp();
                break;
            case 'Tzgoogle':
                jQuery('#setting_plazart_TzFontCustomDefault').slideUp();
                jQuery('#setting_plazart_TzFontCustomSquirrel').slideUp();
                jQuery('#setting_plazart_TzFontCustomGoodurl').slideDown();
                jQuery('#setting_plazart_TzFontFaminyCustom').slideDown();
                break;
        }
    });




    // method logo type

    var LogoType= jQuery("#plazart_logotype").attr('value');
    if(LogoType==1){
        jQuery('#setting_plazart_logo').slideDown();
        jQuery('#setting_plazart_logoText').slideUp();
        jQuery('#setting_plazart_logoTextcolor').slideUp();
    }else{
        jQuery('#setting_plazart_logo').slideUp();
        jQuery('#setting_plazart_logoText').slideDown();
        jQuery('#setting_plazart_logoTextcolor').slideDown();
    }

    jQuery("#plazart_logotype").change(function(){
        var LogoTypeChange= jQuery("#plazart_logotype").attr('value');
        if(LogoTypeChange==1){
            jQuery('#setting_plazart_logo').slideDown();
            jQuery('#setting_plazart_logoText').slideUp();
            jQuery('#setting_plazart_logoTextcolor').slideUp();
        }else{
            jQuery('#setting_plazart_logo').slideUp();
            jQuery('#setting_plazart_logoText').slideDown();
            jQuery('#setting_plazart_logoTextcolor').slideDown();
        }
    });


    // jquery style option
    jQuery("#tab_TzSyle").toggle(function(){
        jQuery('#tab_TzFontMenu').slideDown();
        jQuery('#tab_TzFontCustom').slideDown();
        jQuery('#tab_TZBody').slideDown();
        jQuery('#tab_TzFontHeader').slideDown();

    },function(){
        jQuery('#tab_TzFontMenu').slideUp();
        jQuery('#tab_TzFontCustom').slideUp();
        jQuery('#tab_TZBody').slideUp();
        jQuery('#tab_TzFontHeader').slideUp();

    });

    // jquery favicon option
    var valuefavicon = jQuery('#plazart_favicon_onoff').attr('value');
    if(valuefavicon=='yes'){
        jQuery('#setting_plazart_favicon').slideDown();
    }else{
        jQuery('#setting_plazart_favicon').slideUp();
    }

    jQuery('#plazart_favicon_onoff').change(function(){
        if(jQuery(this).attr('value')=='yes'){
            jQuery('#setting_plazart_favicon').slideDown();
        }else{
            jQuery('#setting_plazart_favicon').slideUp();
        }
    })



});



// Background Type Event

jQuery('#' + themeprefix + '_background_type').live('change', function () {
    "use strict";

    var value = jQuery(this).val();
    if (String(value) === 'none') {
        jQuery('#setting_' + themeprefix + '_background_pattern, ' +
            '#setting_' + themeprefix + '_background_single_image').slideUp();
        jQuery('#setting_' + themeprefix + '_TZBackgroundColor').slideDown();
    }else if (String(value) === 'pattern') {
        jQuery('#setting_' + themeprefix + '_background_pattern').slideDown();
        jQuery('#setting_' + themeprefix + '_background_single_image').slideUp();
        jQuery('#setting_' + themeprefix + '_TZBackgroundColor').slideUp();
    }else {
        jQuery('#setting_' + themeprefix + '_background_pattern').slideUp();
        jQuery('#setting_' + themeprefix + '_background_single_image').slideDown();
        jQuery('#setting_' + themeprefix + '_TZBackgroundColor').slideUp();
    }
});

var background_type = jQuery('#' + themeprefix + '_background_type').val();
if (String(background_type) === 'none') {
    jQuery('#setting_' + themeprefix + '_background_pattern, ' +
        '#setting_' + themeprefix + '_background_single_image').slideUp();
    jQuery('#setting_' + themeprefix + '_TZBackgroundColor').slideDown();
}else if (String(background_type) === 'pattern') {
    jQuery('#setting_' + themeprefix + '_background_pattern').slideDown();
    jQuery('#setting_' + themeprefix + '_background_single_image').slideUp();
} else {
    jQuery('#setting_' + themeprefix + '_background_pattern').slideUp();
    jQuery('#setting_' + themeprefix + '_background_single_image').slideDown();

}

// Background Pattern Preview
jQuery('#setting_' + themeprefix + '_background_pattern .background_pattern').live('click', function () {
    "use strict";
    if (jQuery('#wpcontent').length > 0) {
        jQuery('#wpcontent').css('background', 'url("' + jQuery(this).attr('src') + '") repeat');
    }
});