<div id="tz_mainmenu">
    <div class="scrollbar">
        <div class="track">
            <div class="thumb">
                <div class="end"></div><!--end class end-->
            </div><!--end class thumb-->
        </div><!--end class track-->
    </div><!--end class scrollbar-->
    <div class="viewport">
        <div class="overview">
            <nav id="plazart-mainnav" class="wrap plazart-mainnav navbar-collapse-fixed-top vertical-nav">
                <div class="navbar">
                    <div class="navbar-inner">
                        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                        <div class="nav-collapse collapse always-show">
                            <div class="plazart-megamenu">
                                <?php
                                    if ( has_nav_menu('primary')) :
                                        wp_nav_menu(array(
                                            'theme_location'    =>  'primary',
                                            'menu_class'        =>  'nav level0',
                                            'container'         =>  false

                                        ));
                                    endif;
                                ?>
                            </div><!--end class plazart-megamenu-->
                        </div><!--end class nav-collapse-->
                    </div><!--end class navbar-inner-->
                </div><!--end class navbar-->
            </nav><!--end id plazart-mainnav-->
            <div class="btn_open_sidebar"><i class="fa fa-chevron-circle-right"></i> Sidebar</div>
            <div class="btn_close_sidebar"><i class="fa fa-chevron-circle-left"></i> Sidebar</div>
        </div><!--end class overview-->
    </div><!--end class viewport-->
</div><!--end id tz_mainmenu-->

<div class="mobile-header">
    <div class="logo-mobile"><?php  bloginfo('name') ; ?></div>
    <span class="mobile-open">&nbsp;</span>
    <span class="mobile-close">&nbsp;</span>
</div><!--end class mobile-header-->