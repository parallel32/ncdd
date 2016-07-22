<?php

// Add button to visual editor
add_action('init', 'add_shortcode_button');
function add_shortcode_button() {
    if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
        add_filter('mce_external_plugins', 'add_shortcode_plugin');
        add_filter('mce_buttons_3', 'register_shortcode_button');
    }
}

function register_shortcode_button($buttons) {
    array_push($buttons,"working","awards","services","download","column","list","skill","accordion","tabs","youtube","vimeo","pricing", "button_p","alert_one","alert_two","title","contact_info");
    return $buttons;
}

function add_shortcode_plugin($plugin_array) {
    $plugin_array['divider'] = THEME_PATH . '/extension/shortcode/plazart_shortcode.js';
    return $plugin_array;
}
/* =========================================================
 * shortcode contact info
 * ========================================================= */
function shortcode_contact_info($attr) {
    extract(shortcode_atts(array(
        'title'       =>  '',
        'address'     =>  '',
        'telephone'   =>  '',
        'mobile'      =>  '',
        'email'       =>  ''
    ),$attr));
    ob_start();
 ?>
        <dl class="contact-address dl-horizontal">
        <span class="contact-info-text sh-title-contact"><?php echo $title ; ?></span>
        <dt>
        <span class="jicons-none" >
        </span>
        </dt>
        <dd>
            <i class="fa fa-location-arrow"></i>
            <span class="contact-street"><?php echo $address ?></span>
        </dd>
        <dt>
            <span class="jicons-none" >
            </span>
        </dt>
        <dd>
            <i class="fa fa-phone-square"></i>
            <span class="contact-telephone"><?php echo $telephone; ?></span>
            <span class="jicons-none" ></span>
            <span class="contact-mobile"><?php echo $mobile; ?></span>
        </dd>
        <dt>
            <span class="jicons-none" >
            </span>
        </dt>
        <dd>
            <i class="fa fa-envelope"></i>
            <span class="contact-emailto">
                <?php echo $email; ?>
            </span>
        </dd>
        </dl>
<?php
    $contact_info = ob_get_contents() ;
    ob_end_clean();
    return $contact_info ;
}
add_shortcode('contact_info','shortcode_contact_info');
/*end contact info*/
// title
function shortcode_title( $atts ) {
    extract(shortcode_atts(array(
        'name' => ''
    ),$atts)) ;
    $html = '' ;
    $html .= '<h3 class="h3content">'.$name.'</h3>';
    return $html;
}
add_shortcode('title','shortcode_title');
/*================================================
Alert 1
=================================================*/
function tzshortcode_alert1($atts,$content = null){
    extract(shortcode_atts(array(
        "background" => 1,
    ),$atts));
    $html ="";
    $html ='<div class="tzalert1 alert-background'.$background.'"><p>'.do_shortcode($content).'</p><i class="fa fa-times tzalert-icon"></i></div>';
    return $html;
}
add_shortcode('alert_one','tzshortcode_alert1');
/*================================================
Alert 2
=================================================*/
function tzshortcode_alert2($atts,$content = null){
    extract(shortcode_atts(array(
        'title'      => 'title',
        'background' => 1,
        'description' => ''
    ),$atts));

    ob_start();
    ?>
            <div class="tzalert2 alert-background<?php echo $background ; ?>">
            <h3 class="alert-title"><?php echo $title; ?></h3>
            <p class="alert2-info">
                <?php echo $description ; ?>
            </p>
            <p class="alert2-icon">
                <?php echo  do_shortcode($content);  ?>
            </p>
            <i class="fa fa-times tzalert2-icon"></i></div>
<?php
    $alert = ob_get_contents();
    ob_end_clean();
    return $alert;
}
add_shortcode('alert_two','tzshortcode_alert2');



/*end Alert2*/
// end alert 1
/* =========================================================
 * shortcode button
 * =========================================================*/
function shortocde_button($atts, $content = null) {
    extract(shortcode_atts(array(
        'size'      =>  'default',
        'color'     =>  'green',
        'embossed'  =>  'embossed',
        'link'      =>  '#',
        'icon'      =>  ''
    ),$atts));
    $html = '';
    $html .= '<a class="btn tzshortcode btn-'.$size.' bg-'.$color.' btn-'.$embossed.' btn-primary" href="'.$link.'">';
    if ( isset ( $icon ) && $icon != '' ):
    $html .= '<i class="fa '.$icon.'"></i>' ;
    endif;
    $html.=$content.'</a> ';
    return $html;
}
add_shortcode('button_p','shortocde_button') ;
/* =========================================================
 * shortcode button
 * =========================================================*/
function shortocde_button2($atts, $content = null) {
    extract(shortcode_atts(array(
        'size'      =>  'default',
        'color'     =>  'green',
        'embossed'  =>  'embossed',
        'link'      =>  '#',
        'icon'      =>  ''
    ),$atts));
    $html = '';
    $html .= '<a class="btn tzshortcode btn-'.$size.' bg-'.$color.' btn-'.$embossed.' btn-primary" href="'.$link.'">';
    if ( isset ( $icon ) && $icon != '' ):
    $html .= '<i class="fa '.$icon.'"></i>' ;
    endif;
    $html.=$content.'</a> ';
    return $html;
}
add_shortcode('button','shortocde_button2') ;
/* =========================================================
 * shortcode button  social
 * ========================================================= */
function shortocde_button_social($atts, $content = null) {
    extract(shortcode_atts(array(
        'type'  =>  'googleplus',
    ),$atts));
    $html = '';
    $html .= '<button class="btn btn-social-'.$type.' mrs"> <em class="fui-'.$type.'"></em>'.$content.'</button>';
    return $html;
}
add_shortcode('button_social','shortocde_button_social') ;
/*================================================
Pricing
*=================================================*/
function shortcode_pricing($attr, $content = null) {
    extract(shortcode_atts(array(
        'title' => 'title',
        'cost'  => '500',
        'style' => 'none'
    ),$attr));
    global $tz_pricing;
    $tz_pricing = array() ;
    do_shortcode($content);
    $html = '';
    if ( isset($tz_pricing) && !empty($tz_pricing)){
        $pricing_list = array();
        foreach ($tz_pricing as $pris):
            $pricing_list[] = '<li>'.$pris['content'].'</li>';
        endforeach;
        $html .= "\n".'<ul class="tz-price-table price-'.$style.'"><li class="head">'.$title.'</li><li class="price"><span>$</span>'.$cost.'</li>'.implode("\n",$pricing_list).'</ul>'."\n";
        return $html ;
    }
}

add_shortcode('pricing','shortcode_pricing');

function shortcode_pricing_item($attr, $content = null){
    global $tz_pricing  ;
    $tz_pricing[] = array(
        'content' => $content
    );


}
add_shortcode('pricing_item','shortcode_pricing_item');
/*==========================================================
* Shortcode skill
============================================================*/
function shortcode_skill($atts){
    extract(shortcode_atts(array(
        'title'       =>  'title',
        'background'  =>  'gray',
        'progress'    =>  '90'
    ),$atts));
    ob_start();
    ?>
        <div class="row-fluid bg-gray tzskill"><?php echo $title; ?></div>
        <div class="progress progress-info">
            <div class="bg-<?php echo $background ; ?> bar width<?php echo $progress; ?>"></div>
        </div>
    <?php
    $skill = ob_get_contents();
    ob_end_clean();
    return $skill;
}
add_shortcode('skill','shortcode_skill');
// end skill
/*==========================================================
* Shortcode awards
============================================================*/
function shortcode_working_hour($atts) {
    extract(shortcode_atts(array(
        'title'             =>  '',
        'time'              =>  '',
        'excerpt'           =>  '',
        'background_time'   =>  'dark'
    ),$atts)) ;
    ob_start();
    ?>
        <div class="line-block">
            <span class="content-date btn-<?php echo $background_time ?>"><?php echo $time ; ?></span>
            <div class="date">
                <h5 class="h5content"><?php echo $title ?></h5>
                <span><?php echo $excerpt ; ?></span></div>
            <div class="clr"></div>
        </div>
    <?php
    $work = ob_get_contents();
    ob_end_clean();
    return $work;

}
add_shortcode('working','shortcode_working_hour');
/*==========================================================
* Shortcode awards
============================================================*/
function shortcode_awards($attr, $content = null ){
    global $tz_awards_item;
    $tz_awards_item = array();
    do_shortcode($content);
    ob_start();
    ?>
    <div class="tz_awards">
        <?php
        $j = 1;
        $counts = count($tz_awards_item);
        foreach( $tz_awards_item as  $sawards_it ):

            if($j == 1 ||$j % 3 == 1):
                echo '<div class="row-fluid">';
            endif;
            ?>
            <div class="span4">
                <div class="bg-awards" style="  background: url(<?php echo $sawards_it['images']; ?>)  no-repeat center top / contain ;">
                    <p><?php echo $sawards_it['content'] ?></p>
                </div>
            </div>

            <?php
            if($j % 3 == 0 ):
                echo '</div>';
            endif;
            $j ++ ;
            endforeach ;
            if($counts ==1 || $counts ==2 || $counts % 3 == 1 || $counts %3 == 2 ){
                echo '</div>';
            }
        ?>

    </div><!--end id tz_awards-->
<?php
    $content_awards = ob_get_contents();
    ob_end_clean();
    return $content_awards;
}
add_shortcode('awards','shortcode_awards');

function shortcode_awards_item($attr, $content = null) {
    global $tz_awards_item ;
    extract( shortcode_atts( array(
        'image'   => '',
    ), $attr ) ) ;
    $tz_awards_item[] = array(
        'content'     =>  $content,
        'images'    =>  $image,
    ) ;
}
add_shortcode('awards_item','shortcode_awards_item');
/*==========================================================
* Shortcode download
============================================================*/
function shortcode_download($atts, $content = null) {
    extract( shortcode_atts(array(
        'title'        => 'download',
        'button_name'  => 'click',
        'button_link'  => '#'
    ),$atts) ) ;
    ob_start();
    ?>
        <div id="tz-mass-bottoms" class="tz-download">
            <div class="box box-padding bg-white">
                <h3 class="header"><?php echo $title ?></h3>
                <div class="content">
                    <div class="custombox-padding bg-white">
                        <p class="pull-right"><a href="<?php echo $button_link ?>" class="btn btn-primary btn-embossed mlm"><?php echo $button_name ?></a></p>
                        <p class="download-content"><?php echo $content; ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php
    $tzdownload = ob_get_contents();
    ob_end_clean() ;
    return $tzdownload;

}
add_shortcode('download','shortcode_download');
/*==========================================================
* Shortcode service
============================================================*/
function shortcode_services($attr, $content = null ){
    global $tz_service_item;
    $tz_service_item = array();
    do_shortcode($content);
    ob_start();
    ?>
    <div id="tz-mass-bottom">
        <div class="box">
            <div class="content">
                <div class="weblinks TzServices">
                    <?php
                    $j = 1;
                    $counts = count($tz_service_item);
                        foreach( $tz_service_item as  $service_it ):

                                if( $j == 1 || $j % 2 == 1 ):
                                    echo '<div class="row-fluid">';
                                endif;
                    ?>
                                    <div class="span6">
                                        <div class="image">
                                            <span style="background-image: url( <?php echo $service_it['url'] ; ?>);"></span>
                                        </div>
                                        <h3 class="title"><?php echo $service_it['name'] ; ?></h3>
                                        <div class="description">
                                            <p><?php echo $service_it['content'] ; ?></p>
                                        </div>
                                    </div>

                    <?php
                                if( $j % 2 == 0 ):
                                    echo '</div>';
                                endif;
                        $j ++ ;
                        endforeach ;
                        if( $counts == 1 || $counts % 2 == 1 ):
                            echo '</div>';
                        endif;
                    ?>
                </div><!--end class TzServices-->
            </div><!--end class content-->
        </div><!--end class box-->
    </div><!--end id tz-mass-bottom-->
    <?php
    $content_services = ob_get_contents();
    ob_end_clean();
    return $content_services;
}
add_shortcode('services','shortcode_services');

function shortcode_service_item($attr, $content = null) {
    global $tz_service_item ;
    extract( shortcode_atts( array(
        'image'   => '',
        'title'   => '',
    ), $attr ) ) ;
    $tz_service_item[] = array(
        'url'     =>  $image,
        'name'    =>  $title,
        'content' =>  $content
    ) ;
}
add_shortcode('service_item','shortcode_service_item');
/*end shortcode service*/

/* =========================================================
* shortcode for Youtube embed.
* ========================================================= */
// Youtube.
function shortcode_youtube($attrs, $content) {
    $attrs = shortcode_atts(array(
        'width' => '',
        'height' => '',
    ), $attrs);
    return '<iframe class="youtube-player" type="text/html" width="' . (!empty($attrs['width']) ? $attrs['width'] : '640') . '" height="' . (!empty($attrs['height']) ? $attrs['height'] : '480') . '" src="http://www.youtube.com/embed/' . $content . '" frameborder="0"></iframe>';
}

add_shortcode('youtube', 'shortcode_youtube');


/* =========================================================
* shortcode for Vimeo embed.
* ========================================================= */
// Vimeo.
function shortcode_vimeo($attrs, $content) {
    $attrs = shortcode_atts(array(
        'width' => '',
        'height' => '',
    ), $attrs);
    return '<iframe src="http://player.vimeo.com/video/' . $content . '" width="' . (!empty($attrs['width']) ? $attrs['width'] : '640') . '" height="' . (!empty($attrs['height']) ? $attrs['height'] : '480') . '" frameborder="0"></iframe>';
}

add_shortcode('vimeo', 'shortcode_vimeo');

/* =========================================================
 * shortcode for column
 * ========================================================= */
function shortcode_row($attrs,$content=''){
    global $tz_column_arr;
    $tz_column_arr = array();

    do_shortcode($content);
    $return = '';
    if (isset($tz_column_arr) && $tz_column_arr!=='') {
        $column_item = array();
        foreach ($tz_column_arr as $column) {
            $column_item[] = '<div class="span'.$column['span2'].'">' . $column['content'] .'</div>';
        }
        $return = "\n" . '<div class="row-fluid">' . implode("\n", $column_item) . "\n" . '<div class="clearfix"></div></div>' . "\n";

    }
    return $return;

}
add_shortcode('row','shortcode_row');

// 1/1 column
function shortcode_column($atts, $content = null) {
    global $tz_column_arr;
    extract(shortcode_atts(array(
        'span'    =>  '12'
    ),$atts));
    $tz_column_arr[] = array(
        'span2' => $span,
        'content' => do_shortcode($content),
    );

}
add_shortcode('column', 'shortcode_column');

/* =========================================================
* shortcode for Items list.
* ========================================================= */
// Items list.
function shortcode_list_items($attrs, $content) {
    global $tz_list_items_arr;
    $tz_list_items_arr = array();
    $attrs = shortcode_atts(array(
        'type' => 'list-default',
        'class' => '',
    ), $attrs);
    do_shortcode($content);
    $return = '';
    if (!empty($tz_list_items_arr)) {
        $list_items = array();
        foreach ($tz_list_items_arr as $list_item) {
            $list_items[] = '<li>' . $list_item['content'] . '</li>';
        }
        $return = "\n" . '<!-- the items list --><ul class="plazart-list ' . $attrs['type'] . ' ' . $attrs['class'] . '">' . implode("\n", $list_items) . '</ul>' . "\n";
    }
    return $return;
}

add_shortcode('list_items', 'shortcode_list_items');
// Item list.
function shortcode_list_item($attrs, $content) {
    global $tz_list_items_arr;
    $tz_list_items_arr[] = array(
        'content' => $content,
    );
}

add_shortcode('list_item', 'shortcode_list_item');

/* =========================================================
* shortcode for accordion.
* ========================================================= */
function shortcode_accordion($attrs, $content) {
    global $tz_accs_arr;
    $tz_accs_arr = array();
    do_shortcode($content);
    $return = '';
    if (!empty($tz_accs_arr)) {
        $acc_items = array();
        foreach ($tz_accs_arr as $acc) {
            $acc_items[] = '<div class="tz_accordion"><h3 class="tz_title">' . $acc['title'] . '</h3> <div class="info_accordion">' . $acc['content'] . '</div></div>';
        }
        $return = "\n" . '<!-- the accordion --><div class="tz_news">' . implode("\n", $acc_items) . "\n" . '</div>' . "\n";
    }
    return $return;
}

add_shortcode('accordion', 'shortcode_accordion');
// Accordion item.
function shortcode_accordion_item($attrs, $content) {
    global $tz_accs_arr;
    $attrs = shortcode_atts(array(
        'title' => '',
    ), $attrs);
    $tz_accs_arr[] = array(
        'title' => $attrs['title'],
        'content' => do_shortcode($content),
    );
}
add_shortcode('acc_item', 'shortcode_accordion_item');



/* =========================================================
* shortcode for tab.
* ========================================================= */
function shortcode_tabs($attrs, $content) {
    global $tz_tabs_arr;
    $tz_tabs_arr = array();
    do_shortcode($content);
    $return = '';
    if (!empty($tz_tabs_arr)) {
        $count = 0;
        $tab_items = array();
        $tab_contents = array();
        foreach ($tz_tabs_arr as $tab) {
            $count++;
            $tab_items[] = '<li><a href="#tab_' . strtolower(str_replace(" ", "_", $tab['title'])) . '">' . $tab['title'] . '</a></li>';
            $tab_contents[] = '<div class="tab-pane" id="tab_' . strtolower(str_replace(" ", "_", $tab['title'])) . '">' . $tab['content'] . '</div>';
        }
        $return = "\n" . '<!-- the tabs --><ul class="nav nav-tabs Shortcode_myTab">' . implode("\n", $tab_items) . '</ul>' . "\n" . '<!-- tab "content" --><div class="tab-content tab-sh-content">' . implode("\n", $tab_contents) . '</div>' . "\n";
    }
    return $return;
}

add_shortcode('tabs', 'shortcode_tabs');
// Tab item.
function shortcode_tab_item($attrs, $content) {
    global $tz_tabs_arr;
    $attrs = shortcode_atts(array(
        'title' => '',
    ), $attrs);
    $tz_tabs_arr[] = array(
        'title' => $attrs['title'],
        'content' => do_shortcode($content),
    );
}
add_shortcode('tab_item', 'shortcode_tab_item');


// Enable Shortcodes in excerpts and widgets
add_filter('widget_text', 'do_shortcode');
add_filter('the_excerpt', 'do_shortcode');
add_filter('get_the_excerpt', 'do_shortcode');