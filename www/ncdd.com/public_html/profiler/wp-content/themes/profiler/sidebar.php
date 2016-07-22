<section  id="sidebar-left" class="span3 left-sidebar pull-left offset-12 tzblog-sidebar">
        <div class="sidebar-nav sidebar-level1">
            <div class="tz-logo">
                <a class="tz-logoo" href="<?php echo get_home_url(); ?>" title="<?php bloginfo('name'); ?>">
                    <?php
                    $logotype = ot_get_option(THEME_PREFIX . '_logotype','text');
                    $logo_avata = ot_get_option(THEME_PREFIX . '_logo','');
                    if( $logo_avata != '' ){
                        $logo = $logo_avata;
                    }else{
                        $logo = THEME_PATH .'/images/logo.jpg';
                    }

                    if($logotype=='text'){
                        echo ot_get_option(THEME_PREFIX . '_logoText','plazat');
                    }else{
                        echo'<img src="'.$logo .'" alt="'.get_bloginfo('title').'" />';
                    }
                    ?>
                </a><!--end class tz-logoo-->
            </div><!--end class tz-logo-->
            <?php
                if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar left') )  :

                endif;
            ?>
        </div><!--end class sidebar-nav-->
</section><!--end id sidebar-left-->