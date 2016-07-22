<?php
/*
 * Initialize the options before anything else.
 */

add_action('admin_init','plazat_theme_options',1);

/*
 * Build the custom settings & update OptionTree.
*/

function plazat_theme_options()
{

    /**
     * Get a copy of the saved settings array.
     */
    $saved_settings = get_option('option_tree_settings', array());

    // Pattern
    $patterns = array();
    if ($dir = opendir(SERVER_PATH . '/images/patterns/')) {
        while (false !== ($file = readdir($dir))) {
            if ($file != '..' && $file != '.') {
                $patterns[] = array(
                    'value' => trim($file),
                    'label' => 'Click on pattern to preview',
                    'src'   => THEME_PATH . '/images/patterns/' . $file, 40, 40, true
                );
            }
        }
        // Close directory handle
        closedir($dir);
    }

    /**
     * Custom settings array that will eventually be
     * passes to the OptionTree Settings API Class.
     */
    $custom_settings = array(
        'contextual_help' => array(
            'content' => array(
                array(
                    'id'      => 'general_help',
                    'title'   => 'General',
                    'content' => '<p>Help content goes here!</p>'
                ),
            ),
            'sidebar' => '<p>Sidebar content goes here!</p>'
        ),
        'sections'        => array(
            array(
                'id'    => 'logo',
                'title' => 'Logo & Favicon',
            ),
            array(
                'id'    => '404',
                'title' => '404 Page',
            ),
            array(
                'id'    =>  'google_analytics',
                'title' =>  'Google Analytics',
            ),
            array(
                'id'    =>  'TzGlobalOption',
                'title' =>  'General Options',
            ),
            array(
                'id'    =>  'TzSyle',
                'title' =>  'Font Option',
            ),
            array(
                'id'    =>  'TZBody',
                'title' =>  'Body Style',
            ),

            array(
                'id'    =>  'TzFontHeader',
                'title' =>  'Header Style',
            ),
            array(
                'id'    =>  'TzFontMenu',
                'title' =>  'Menu Style',
            ),

            array(
                'id'    =>  'TzFontCustom',
                'title' =>  'Custom Style',
            ),
            array(
                'id'    =>  'TzCustomCss',
                'title' =>  'Custom CSS',
            ),
            array(
                'id'    =>  'TZBackground',
                'title' =>  'Background',
            ),
            array(
                'id'    =>  'TZGallery',
                'title' =>  'Gallery',
            ),
            array(
                'id'    =>  'TZBlogSiderbar',
                'title' =>  'Sidebar Option',
            ),
            array(
                'id'    =>  'TZBlog',
                'title' =>  'Blog Option',
            ),
            array(
                'id'    =>  'TZSingleBlog',
                'title' =>  'Single Blog Option',
            ),
            array(
                'id'    =>  'TZPortfolio',
                'title' =>  'Portfolio Option',
            ),
            array(
                'id'    =>  'TZThemeColor',
                'title' =>  'Theme Color',
            ),




        ),

        'settings'        => array(

            array(
                'id'        => THEME_PREFIX . '_logotype',
                'label'     => 'Logo Type',
                'desc'      => 'select type for logo text or image',
                'std'       => '1',
                'type'      => 'select',
                'section'   => 'logo',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => '',
                'choices'   => array(
                    array(
                        'value' => '1',
                        'label' => 'Logo image',
                    ),
                    array(
                        'value' => '0',
                        'label' => 'Logo text',
                    ),
                ),
            ),

            array(
                'id'        => THEME_PREFIX . '_logoText',
                'label'     => 'Logo Name',
                'desc'      => '',
                'std'       => 'logo',
                'type'      => 'text',
                'section'   => 'logo',
            ),

            array(
                'id'        => THEME_PREFIX . '_logoText',
                'label'     => 'Logo Text',
                'desc'      => 'logo name for your website',
                'std'       => '',
                'type'      => 'text',
                'section'   => 'logo',
            ),

            array(
                'id'        =>  THEME_PREFIX. '_logoTextcolor',
                'label'     => 'Color logo',
                'desc'      => ' logo text color',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'logo',
            ),

            array(
                'id'        => THEME_PREFIX . '_logo',
                'label'     => 'Upload Logo',
                'desc'      => 'Please choose an image  to use for logo.',
                'std'       => '',
                'type'      => 'upload',
                'section'   => 'logo',
            ),

            array(
                'id'        => THEME_PREFIX . '_favicon_onoff',
                'label'     => 'Enable Favicon',
                'desc'      => 'Show or hide Favicon',
                'std'       => 'no',
                'type'      => 'select',
                'section'   => 'logo',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => '',
                'choices'   => array(
                    array(
                        'value' => 'yes',
                        'label' => 'Yes',
                        'src'   => ''
                    ),
                    array(
                        'value' => 'no',
                        'label' => 'No',
                        'src'   => ''
                    )
                ),
            ),

            array(
                'id'        => THEME_PREFIX . '_favicon',
                'label'     => 'Upload Favicon Icon',
                'desc'      => 'Please choose an image  to use for favicon.',
                'std'       => '',
                'type'      => 'upload',
                'section'   => 'logo',
            ),

            array(
                'id'        => THEME_PREFIX . '_404_page_content',
                'label'     => '404 Page Content',
                'desc'      => '',
                'std'       => '<h2>We\'re sorry..</h2><p>The page or journal you are looking for cannot be found</p>',
                'type'      => 'textarea',
                'section'   => '404',
                'rows'      => '15',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            // Google Analytics
            array(
                'id'        => THEME_PREFIX . '_google_analytics',
                'label'     => 'Google Analytics',
                'desc'      => 'Place the code you get from google here. This should be something like:<br /><br /><code>   // Google analytics <br /> var _gaq = _gaq || []; <br />_gaq.push(["_setAccount", "UA-XXXXXXX-XX"]); <br /> ...</code>',
                'std'       => '',
                'type'      => 'textarea-simple',
                'section'   => 'google_analytics',
                'rows'      => '4',
            ),

            // style option
            array(
                'id' =>  THEME_PREFIX.'_TzSyle',
                'label'     => 'StyleConfig',
                'desc'      => '<p>Config for body style, header style, menu style, custom style, background</p>',
                'std'       => '',
                'type'      => 'textblock-titled',
                'section'   => 'TzSyle',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            // font style body -----------------------------------------------------------------------
            array(
                'id'        =>  THEME_PREFIX. '_TZFontType',
                'label'     =>  'Font Type',
                'desc'      =>  'option font type',
                'std'       =>  '',
                'type'      =>  'select',
                'section'   =>  'TZBody',
                'rows'      =>  '',
                'post_type' =>  '',
                'taxonomy'  =>  '',
                'class'     =>  'btn-group',
                'choices'   =>  array(

                    array(
                        'value' =>  'Tzgoogle',
                        'label' =>  'Goole Font',
                    ),
                    array(
                        'value' =>  'TzFontDefault',
                        'label' =>  'Standard Font',
                    ),


                ),
            ),

            //  font
            array(
                'id'       =>   THEME_PREFIX.'_TzFontDefault',
                'label'    =>   'Select Standard Font ',
                'desc'     =>   'Select a font to use font-family',
                'type'     =>   'select',
                'section'  =>   'TZBody',
                'class'    =>   'TzFontStylet',
                'choices'  =>   array(
                    array(
                        'value'  =>  'Arial',
                        'label'  =>  'Arial',
                    ),
                    array(
                        'value'  =>  'Tahoma',
                        'label'  =>  'Tahoma',
                    ),
                    array(
                        'value'  =>  'Verdana',
                        'label'  =>  'Verdana',
                    ),
                    array(
                        'value'  =>  'Georgia',
                        'label'  =>  'Georgia',
                    ),
                    array(
                        'value'  =>  'Impact',
                        'label'  =>  'Impact',
                    ),
                    array(
                        'value'  =>  'Times',
                        'label'  =>  'Times',
                    ),
                )
            ),



            // google url
            array(
                'id'    =>  THEME_PREFIX. '_TzFontFami',
                'label' =>  'Google Url',
                'desc'  =>  'import google font URL Eg: http://fonts.googleapis.com/css?family=Monsieur+La+Doulaise',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TZBody'
            ),

            // body font
            array(
                'id'    =>  THEME_PREFIX. '_TzFontFaminy',
                'label' =>  'Font Family',
                'desc'  =>  'importeg google font-family Eg: Monsieur La Doulaise',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TZBody',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TzBodySelecter',
                'label'     =>  'Body Selectors',
                'desc'      =>  'you can specify a selector for font used in the document body eg: div#description',
                'std'       =>  '',
                'type'      =>  'textarea-simple',
                'section'   =>  'TZBody',
                'rows'      =>  '10',
            ),
            // color code

            array(
                'id'        =>  THEME_PREFIX. '_TzBodyColor',
                'label'     => 'Color code',
                'desc'      => 'Color for text',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZBody',
            ),
            // end font style body


            // font style Header -----------------------------------------------------------------------
            array(
                'id'        =>  THEME_PREFIX. '_TZFontTypeHead',
                'label'     =>  'Font Type',
                'desc'      =>  'option font type',
                'std'       =>  '',
                'type'      =>  'select',
                'section'   =>  'TzFontHeader',
                'rows'      =>  '',
                'post_type' =>  '',
                'taxonomy'  =>  '',
                'class'     =>  '',
                'choices'   =>  array(

                    array(
                        'value' =>  'Tzgoogle',
                        'label' =>  'Goole Font',
                    ),
                    array(
                        'value' =>  'TzFontDefault',
                        'label' =>  'Standard Font',
                    ),


                ),
            ),

            // Squirrel font
            array(
                'id'       =>   THEME_PREFIX.'_TzFontHeadDefault',
                'label'    =>   'Select Standard Font ',
                'desc'     =>   'Select a font to use font-family',
                'type'     =>   'select',
                'section'  =>   'TzFontHeader',
                'choices'  =>   array(
                    array(
                        'value'  =>  'Arial',
                        'label'  =>  'Arial',
                    ),
                    array(
                        'value'  =>  'Tahoma',
                        'label'  =>  'Tahoma',
                    ),
                    array(
                        'value'  =>  'Verdana',
                        'label'  =>  'Verdana',
                    ),
                    array(
                        'value'  =>  'Georgia',
                        'label'  =>  'Georgia',
                    ),
                    array(
                        'value'  =>  'Impact',
                        'label'  =>  'Impact',
                    ),
                    array(
                        'value'  =>  'Times',
                        'label'  =>  'Times',
                    ),
                )
            ),



            // google url
            array(
                'id'    =>  THEME_PREFIX. '_TzFontHeadGoodurl',
                'label' =>  'Google Url',
                'desc'  =>  'import google font URL Eg: http://fonts.googleapis.com/css?family=Monsieur+La+Doulaise',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TzFontHeader'
            ),

            // body font
            array(
                'id'    =>  THEME_PREFIX. '_TzFontFaminyHead',
                'label' =>  'Font Family',
                'desc'  =>  'importeg google font-family Eg: Monsieur La Doulaise',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TzFontHeader',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TzHeadSelecter',
                'label'     =>  'Header Selecter',
                'desc'      =>  'You can specify a selector for font used in the document Header Eg: div#description',
                'std'       =>  '',
                'type'      =>  'textarea-simple',
                'section'   =>  'TzFontHeader',
                'rows'      =>  '10',
            ),

            array(
                'id'    =>  THEME_PREFIX. '_TzHeaderFontColor',
                'label'     => 'Color code',
                'desc'      => 'Color for text',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TzFontHeader',
            ),
            // end font header

            // font  Menu -----------------------------------------------------------------------

            array(
                'id'        =>  THEME_PREFIX. '_TZFontTypeMenu',
                'label'     =>  'Font Type',
                'desc'      =>  'option font type',
                'std'       =>  '',
                'type'      =>  'select',
                'section'   =>  'TzFontMenu',
                'rows'      =>  '',
                'post_type' =>  '',
                'taxonomy'  =>  '',
                'class'     =>  '',
                'choices'   =>  array(
                    array(
                        'value' =>  'Tzgoogle',
                        'label' =>  'Goole Font',
                    ),
                    array(
                        'value' =>  'TzFontDefault',
                        'label' =>  'Standard Font',
                    ),


                ),
            ),

            // Squirrel font
            array(
                'id'       =>   THEME_PREFIX.'_TzFontMenuDefault',
                'label'    =>   'Select Standard Font ',
                'desc'     =>   'Select a font to use font-family',
                'type'     =>   'select',
                'section'  =>   'TzFontMenu',
                'choices'  =>   array(
                    array(
                        'value'  =>  'Arial',
                        'label'  =>  'Arial',
                    ),
                    array(
                        'value'  =>  'Tahoma',
                        'label'  =>  'Tahoma',
                    ),
                    array(
                        'value'  =>  'Verdana',
                        'label'  =>  'Verdana',
                    ),
                    array(
                        'value'  =>  'Georgia',
                        'label'  =>  'Georgia',
                    ),
                    array(
                        'value'  =>  'Impact',
                        'label'  =>  'Impact',
                    ),
                    array(
                        'value'  =>  'Times',
                        'label'  =>  'Times',
                    ),
                )
            ),



            // google url
            array(
                'id'    =>  THEME_PREFIX. '_TzFontMenuGoodurl',
                'label' =>  'Google Url',
                'desc'  =>  'import google font URL Eg: http://fonts.googleapis.com/css?family=Monsieur+La+Doulaise',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TzFontMenu'
            ),

            // Font Family
            array(
                'id'    =>  THEME_PREFIX. '_TzFontFaminyMenu',
                'label' =>  'Font Family',
                'desc'  =>  'importeg google font-family Eg: Monsieur La Doulaise',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TzFontMenu',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TzMenuSelecter',
                'label'     =>  'Menu Selectors',
                'desc'      =>  'you can specify a selector for font used in the document body eg: div#menu',
                'std'       =>  '',
                'type'      =>  'textarea-simple',
                'section'   =>  'TzFontMenu',
                'rows'      =>  '10',
            ),

            array(
                'id'    =>  THEME_PREFIX. '_TzMenuFontColor',
                'label'     => 'Color code',
                'desc'      => 'Color for text',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TzFontMenu',
            ),

            /*---end menu font--*/
            // font style custom -----------------------------------------------------------------------
            array(
                'id'        =>  THEME_PREFIX. '_TZFontTypeCustom',
                'label'     =>  'Font Type',
                'desc'      =>  'option font type',
                'std'       =>  '',
                'type'      =>  'select',
                'section'   =>  'TzFontCustom',
                'rows'      =>  '',
                'post_type' =>  '',
                'taxonomy'  =>  '',
                'class'     =>  '',
                'choices'   =>  array(
                    array(
                        'value' =>  'Tzgoogle',
                        'label' =>  'Goole Font',
                    ),
                    array(
                        'value' =>  'TzFontDefault',
                        'label' =>  'Standard Font',
                    ),

                ),
            ),

            // Squirrel font
            array(
                'id'       =>   THEME_PREFIX.'_TzFontCustomDefault',
                'label'    =>   'Select Standard Font ',
                'desc'     =>   'Select a font to use font-family',
                'type'     =>   'select',
                'section'  =>   'TzFontCustom',
                'choices'  =>   array(
                    array(
                        'value'  =>  'Arial',
                        'label'  =>  'Arial',
                    ),
                    array(
                        'value'  =>  'Tahoma',
                        'label'  =>  'Tahoma',
                    ),
                    array(
                        'value'  =>  'Verdana',
                        'label'  =>  'Verdana',
                    ),
                    array(
                        'value'  =>  'Georgia',
                        'label'  =>  'Georgia',
                    ),
                    array(
                        'value'  =>  'Impact',
                        'label'  =>  'Impact',
                    ),
                    array(
                        'value'  =>  'Times',
                        'label'  =>  'Times',
                    ),
                )
            ),



            // google url
            array(
                'id'    =>  THEME_PREFIX. '_TzFontCustomGoodurl',
                'label' =>  'Google Url',
                'desc'  =>  'import google font URL Eg: http://fonts.googleapis.com/css?family=Monsieur+La+Doulaise',
                'std'   =>  '',
                'type'  =>  'text',
                'section'=> 'TzFontCustom'
            ),

            // body font
            array(
                'id'       =>  THEME_PREFIX. '_TzFontFaminyCustom',
                'label'    =>  'Font Family',
                'desc'     =>  'importeg google font-family Eg: Monsieur La Doulaise',
                'std'      =>  '',
                'type'     =>  'text',
                'section'  => 'TzFontCustom',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TzCustomSelecter',
                'label'     =>  'Custom Selecter',
                'desc'      =>  'you can specify a selector for font used in the document body eg: div#custom',
                'std'       =>  '',
                'type'      =>  'textarea-simple',
                'section'   =>  'TzFontCustom',
                'rows'      =>  '10',
            ),

            array(
                'id'        =>  THEME_PREFIX. '_TzCustomFontColor',
                'label'     =>  'Color code',
                'desc'      =>  'Color for text',
                'std'       =>  '',
                'type'      => 'colorpicker',
                'section'   => 'TzFontCustom',
            ),
            // end font custom

            /*-------custom css-------*/
            array(
                 'id'        =>  THEME_PREFIX. '_TzCustomCss',
                 'label'     =>  'Code CSS',
                 'desc'      =>  'Paste your CSS code, do not include any tags or HTML in thie field. Any custom CSS entered here will override the theme CSS. In some cases, the !important tag may be needed.',
                 'std'       =>  '',
                 'type'      => 'textarea-simple',
                 'section'   => 'TzCustomCss',
            ),
            // end custom css

            /* Background */
            array(
                'id'        => 'cbackground',
                'label'     => 'Background',
                'desc'      => '<p>Default background for Post, Page, Portfolio, Category, Archive, Seach page.</p>',
                'std'       => '',
                'type'      => 'textblock-titled',
                'section'   => 'TZBackground',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),
            array(
                'id'        => THEME_PREFIX . '_background_type',
                'label'     => 'Background Type',
                'desc'      => 'You can choose the background you want between our pre-provided pattern and your custom image.',
                'std'       => 'none',
                'type'      => 'select',
                'section'   => 'TZBackground',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => '',
                'choices'   => array(
                    array(
                        'value' => 'none',
                        'label' => 'Default',
                    ),
                    array(
                        'value' => 'pattern',
                        'label' => 'Pattern',
                    ),
                    array(
                        'value' => 'single_image',
                        'label' => 'Single image',
                    ),
                ),
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZBackgroundColor',
                'label'     => 'Color code',
                'desc'      => 'Background color code',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZBackground',
            ),
            array(
                'id'        => THEME_PREFIX . '_background_pattern',
                'label'     => 'Choose Pattern',
                'desc'      => '',
                'std'       => '',
                'type'      => 'radio-image',
                'section'   => 'TZBackground',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => 'background_pattern',
                'choices'   => $patterns
            ),
            array(
                'id'        => THEME_PREFIX . '_background_single_image',
                'label'     => 'Single Image Background',
                'desc'      => '',
                'std'       => '',
                'type'      => 'upload',
                'section'   => 'TZBackground',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            /* End Background */
            /*---------------------end themestyle--------------------*/


            // OptionAdmin
            array(
                'id'        =>  THEME_PREFIX.'_TzGlobalOptionAdmin',
                'label'     =>  'Show toolbar admin',
                'desc'      =>  'Show or hide toolbar admin',
                'std'       =>  '0',
                'type'      =>  'select',
                'section'   =>  'TzGlobalOption',
                'choices'   =>  array(
                    array(
                        'value' =>  '1',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  '0',
                        'label' =>  'Hide',
                    ),

                ),
            ),
            // limit excerpt
            array(
                'label'     => 'Limit excerpt',
                'id'        => THEME_PREFIX . '_porlimitexcerpt',
                'type'      => 'text',
                'desc'      => 'Limit text for excerpt',
                'std'       => '',
                'section'   => 'TzGlobalOption',
            ),

            // OptionAdmin
            array(
                'id'        =>  THEME_PREFIX.'_TzGlobalOptionCss',
                'label'     =>  'Custom Css Option',
                'desc'      =>  'Create file css or add css custom to head',
                'std'       =>  '0',
                'type'      =>  'select',
                'section'   =>  'TzGlobalOption',
                'choices'   =>  array(
                    array(
                        'value' =>  '0',
                        'label' =>  'Add Css To Head',
                    ),
                    array(
                        'value' =>  '1',
                        'label' =>  'Create File Css',
                    ),
                ),
            ),

            /*TZGallery*/

             array(
                 'label'     => 'Upload Gallery',
                 'id'        => THEME_PREFIX . '_gallery',
                 'type'      => 'gallery',
                 'desc'      => '',
                 'std'       => '',
                 'section'   => 'TZGallery',
             ),
            array(
                'id'        =>  THEME_PREFIX. '_status_gallery',
                'label'     =>  'Status Gallery',
                'desc'      =>  '',
                'type'      =>  'select',
                'section'   =>  'TZGallery',
                'choices'   =>  array(
                    array(
                        'value' => 'show',
                        'label' => 'Show',
                    ),
                    array(
                        'value' => 'hide',
                        'label' => 'hide',
                    ),
                ),
            ),
            array(
                'id'        =>  THEME_PREFIX. '_Tztransition',
                'label'     =>  'Controls effect slides.',
                'desc'      =>  'Controls which effect is used to transition between slides.',
                'type'      =>  'select',
                'section'   =>  'TZGallery',
                'choices'    => array(
                    array(
                        'value' => '1',
                        'label' => 'Fade effect (Default)'
                    ),
                    array(
                        'value' => '2',
                        'label' => 'Slide in from top'
                    ),
                    array(
                        'value' => '3',
                        'label' => 'Slide in from right'
                    ),
                    array(
                        'value' => '4',
                        'label' => 'Slide in from bottom'
                    ),
                    array(
                        'value' => '5',
                        'label' => 'Slide in from left'
                    ),
                    array(
                        'value' => '6',
                        'label' => 'Carousel from right to left'
                    ),
                    array(
                        'value' => '7',
                        'label' => 'Carousel from left to right'
                    ),
                    array(
                        'value' => '0',
                        'label' => ' No transition effect'
                    ),
                ),
            ),
            array(
                'id'        =>  THEME_PREFIX. '_Tzhorizontal_center',
                'label'     =>  'Horizontally center background',
                'desc'      =>  'Centers image horizontally. When turned off, the images resize/display from the left of the page.',
                'type'      =>  'select',
                'section'   =>  'TZGallery',
                'choices'   =>  array(
                    array(
                        'value' => '1',
                        'label' => 'On',
                    ),
                    array(
                        'value' => '0',
                        'label' => 'Off',
                    ),
                ),
            ),
            array(
                'id'        =>  THEME_PREFIX. '_Tzfit_always',
                'label'     =>  'Prevents the image from ever being cropped',
                'desc'      =>  '',
                'type'      =>  'select',
                'section'   =>  'TZGallery',
                'choices'   =>  array(
                    array(
                        'value' => '0',
                        'label' => 'Image will never exceed browser width or height (Default)',
                    ),
                    array(
                        'value' => '1',
                        'label' => 'Image will exceed browser width or height',
                    ),
                ),
            ),
            array(
                'id'        =>  THEME_PREFIX. '_Tzfit_portrait',
                'label'     =>  'Prevents the image from being cropped by locking it at 100% height.',
                'desc'      =>  '',
                'type'      =>  'select',
                'section'   =>  'TZGallery',
                'choices'   =>  array(
                    array(
                        'value' => '1',
                        'label' => 'Portrait images will not exceed browser height (Default)',
                    ),
                    array(
                        'value' => '0',
                        'label' => 'Portrait images will exceed browser height',
                    ),
                ),
            ),
            array(
                'id'        =>  THEME_PREFIX. '_Tzfit_landscape',
                'label'     =>  'Prevents the image from being cropped by locking it at 100% width.',
                'desc'      =>  '',
                'type'      =>  'select',
                'section'   =>  'TZGallery',
                'choices'   =>  array(
                    array(
                        'value' => '0',
                        'label' => 'Landscape images will not exceed browser width (Default)',
                    ),
                    array(
                        'value' => '1',
                        'label' => 'Landscape images will exceed browser width',
                    ),
                ),
            ),

            /*=================================
            * TZBlogSiderbar
            ===================================*/
            array(
                'id'        => 'TZBlog',
                'label'     => 'Option',
                'desc'      => '<p>Option show or hide Right Sidebar for page blog and tag and search and author</p>',
                'std'       => '',
                'type'      => 'textblock-titled',
                'section'   => 'TZBlogSiderbar',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            // Show or hide Category siderbar
            array(
                'id'        => THEME_PREFIX . '_sidebarcat',
                'label'     => 'Category sidebar',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlogSiderbar',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),
              // Show or hide tags siderbar
            array(
                'id'        => THEME_PREFIX . '_sidebartag',
                'label'     => 'Tag sidebar',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlogSiderbar',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),
            // Show or hide Author siderbar
            array(
                'id'        => THEME_PREFIX . '_sidebarauthor',
                'label'     => 'Author sidebar',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlogSiderbar',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),
           // Show or hide search sidebar
            array(
                'id'        => THEME_PREFIX . '_sidebasearch',
                'label'     => 'Search sidebar',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlogSiderbar',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),

            /*=================================
            * Option Blog and Tag and Serach and Author
            ===================================*/

            array(
                'id'        => 'TZBlog',
                'label'     => 'Option',
                'desc'      => '<p>Option for page blog and tag and search and author</p>',
                'std'       => '',
                'type'      => 'textblock-titled',
                'section'   => 'TZBlog',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            // Show or hide Date
            array(
                'id'        => THEME_PREFIX . '_TZBlogDate',
                'label'     => 'Show Date',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),

            // Show or hide Category
            array(
                'id'        => THEME_PREFIX . '_TZBlogcomment',
                'label'     => 'Show Comment',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),

            // Show or hide author
            array(
                'id'        => THEME_PREFIX . '_TZBlogAuthor',
                'label'     => 'Show Author',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),

            // Show or hide Category
            array(
                'id'        => THEME_PREFIX . '_TZBlogTag',
                'label'     => 'Show Tag',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),

            // Show or hide image
            array(
                'id'        => THEME_PREFIX . '_TZBlogimage',
                'label'     => 'Show Image',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),

            // Show or hide excerpt
            array(
                'id'        => THEME_PREFIX . '_TZBlogexcerpt',
                'label'     => 'Show Excerpt',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),

            // Show or hide comment
            array(
                'id'        => THEME_PREFIX . '_TZBlogTitle',
                'label'     => 'Show Title',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),
            // Show or hide readmore
            array(
                'id'        => THEME_PREFIX . '_TZBlogreadmore',
                'label'     => 'Show Readmore',
                'type'      => 'select',
                'desc'      => '',
                'std'       => '',
                'section'   => 'TZBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),

            ),

            /*=================================
            * Single Blog Option
            ===================================*/

            array(
                'id'        => 'TZSingleBlog',
                'label'     => 'Option',
                'desc'      => '<p>Option for page single blog.</p>',
                'std'       => '',
                'type'      => 'textblock-titled',
                'section'   => 'TZSingleBlog',
                'rows'      => '',
                'post_type' => '',
                'taxonomy'  => '',
                'class'     => ''
            ),

            // Show or hide media
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_media',
                'label'     => 'Show Media',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),
            // Show or hide date
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_date',
                'label'     => 'Show Date',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),

            // Show or hide author
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_author',
                'label'     => 'Show Author',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),

            // Show or hide tag
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_tag',
                'label'     => 'Show Tag',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),

            // Show or hide comment
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_comment',
                'label'     => 'Show Comment',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),

            // Show or hide title
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_title',
                'label'     => 'Show Title',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),

            // Show or hide content
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_content',
                'label'     => 'Show Content',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),

            // Show or hide share
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_share',
                'label'     => 'Show Share',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),

            // Show or hide info author
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_info_author',
                'label'     => 'Show Info Author',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),

            // Show or hide relate
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_relate',
                'label'     => 'Show Relate',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),

            // Show or hide form comment
            array(
                'id'        => THEME_PREFIX . '_TZSingleBlog_form_comment',
                'label'     => 'Show Form Comment',
                'type'      => 'select',
                'desc'      => '',
                'std'       => 'show',
                'section'   => 'TZSingleBlog',
                'choices'   =>  array(
                    array(
                        'value' =>  'show',
                        'label' =>  'Show',
                    ),
                    array(
                        'value' =>  'hide',
                        'label' =>  'Hide',
                    ),
                ),
            ),


            /*-------------Portfolio----------------*/


            array(
                'id'         =>  THEME_PREFIX .'_TZPortfoliowidth',
                'label'      =>  'Portfolio width',
                'type'       =>  'text',
                'std'        =>   350,
                'desc'       =>  'Config width for portfolio',
                'section'    =>  'TZPortfolio'
            ),
            array(
                'id'         =>   THEME_PREFIX .'_TZPortfolioimage',
                'label'      =>   'Image loadmore',
                'type'       =>   'upload',
                'desc'       =>   'Changle image load',
                'std'        =>   '',
                'section'    =>   'TZPortfolio'
            ),
            array(
                'id'         =>   THEME_PREFIX .'_TZPortfolioendload',
                'label'      =>   'text end loadmore',
                'type'       =>   'text',
                'desc'       =>   'Changle text loadmore',
                'std'        =>   'No more pages to load',
                'section'    =>   'TZPortfolio'
            ),
            /*-------------Theme Color----------------*/

            array(
                'id'         =>   THEME_PREFIX .'_TZThemeColorcustom',
                'label'      =>   'Theme Color',
                'type'       =>   'select',
                'desc'       =>   '',
                'std'        =>   'default',
                'section'    =>   'TZThemeColor',
                'choices'   =>  array(
                    array(
                        'value' =>  'default',
                        'label' =>  'Default',
                    ),
                    array(
                        'value' =>  'custom',
                        'label' =>  'Custom',
                    ),
                ),
            ),
            array(
                'id'         =>   THEME_PREFIX .'_TZThemeColortype',
                'label'      =>   'Color Type',
                'type'       =>   'select',
                'desc'       =>   '',
                'std'        =>   'sidebarleft',
                'section'    =>   'TZThemeColor',
                'choices'   =>  array(
                    array(
                        'value' =>  'sidebarleft',
                        'label' =>  'Left Sidebar Color',
                    ),
                    array(
                        'value' =>  'menu',
                        'label' =>  'Menu Color',
                    ),
                    array(
                        'value' =>  'maincontent',
                        'label' =>  'Main Content Color',
                    ),
                    array(
                        'value' =>  'sidebarright',
                        'label' =>  'Right Sidebar Color',
                    ),
                ),
            ),
            //  Left Sidebar
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorsidebarleft_background',
                'label'     => __('Background Left Sidebar',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorsidebarleft_title',
                'label'     => __('Title Left Sidebar Color',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorsidebarleft_fontcolor',
                'label'     => __('Left Sidebar Font Color',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorsidebarleft_bordercolor',
                'label'     => __('Left Sidebar Border Color',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorsidebarleft_social_background',
                'label'     => __('Social Background Color',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorsidebarleft_social_fontcolor',
                'label'     => __('Social Icon Color',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            //  Menu
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColormenu_bk',
                'label'     => __('Menu Background',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColormenu_items',
                'label'     => __('Menu Items Color',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColormenu_items_hover',
                'label'     => __('Menu Items Hover Color',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColormegamenu_bk',
                'label'     => __('Sub Menu Background Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColormegamenu_items',
                'label'     => __('Sub Menu Items Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColormegamenu_border',
                'label'     => __('Sub Menu Boder Color',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            //  Content
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorcontent_bk',
                'label'     => __('Content Background Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorcontent_titlecolor',
                'label'     => __('Content Heading Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorcontent_fontcolor',
                'label'     => __('Content Font Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorcontent_button_bk',
                'label'     => __('Button Background Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorcontent_button_textcolor',
                'label'     => __('Button Text Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorcontent_comment_border',
                'label'     => __('Comment Background Color And Border Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorcontent_link_color',
                'label'     => __('Link Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            //  Right Sidebar
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorsidebarright_bk',
                'label'     => __('Right Sidebar Background Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorsidebarright_fontcolor',
                'label'     => __('Right Sidebar Font Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorsidebarright_border',
                'label'     => __('Right Sidebar Border Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),
            array(
                'id'        =>  THEME_PREFIX. '_TZThemeColorsidebarright_link',
                'label'     => __('Right Sidebar Link Color ',TEXT_DOMAIN),
                'desc'      => '',
                'std'       => '',
                'type'      => 'colorpicker',
                'section'   => 'TZThemeColor',
            ),


        ) // end settings
    );

    /* allow settings to be filtered before saving */

    $custom_settings = apply_filters('option_tree_settings_args', $custom_settings);

    /* settings are not the same update the DB */
    if ($saved_settings !== $custom_settings) {
        update_option('option_tree_settings', $custom_settings);
    }

}


?>
