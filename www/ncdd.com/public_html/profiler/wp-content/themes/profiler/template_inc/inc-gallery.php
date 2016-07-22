<?php
$status               =    ot_get_option(THEME_PREFIX. '_status_gallery','show');
if ( $status == 'show' ) :
$transition           =    ot_get_option (THEME_PREFIX. '_Tztransition','1');
$horizontalcenter     =    ot_get_option (THEME_PREFIX. '_Tzhorizontal_center','1');
$fitalways            =    ot_get_option (THEME_PREFIX. '_Tzfit_always','0');
$fitportrait          =    ot_get_option (THEME_PREFIX. '_Tzfit_portrait','1');
$fitlandscape         =    ot_get_option (THEME_PREFIX. '_Tzfit_landscape','0');
?>
<section class="tz-slideshow">
    <div class="container-fluid">
        <div class="tz-inner">
            <div class="box">
                <div class="content">
                    <!--get slider-->
                    <script type="text/javascript">
                        jQuery(function(jQuery){
                            jQuery.supersized({

                                // Functionality
                                slideshow               :   1,			// Slideshow on/off
                                autoplay				:	1,			// Slideshow starts playing automatically
                                start_slide             :   1,			// Start slide (0 is random)
                                stop_loop				:	0,			// Pauses slideshow on last slide
                                random					: 	0,			// Randomize slide order (Ignores start slide)
                                slide_interval          :   5000,		// Length between transitions
                                transition              :   <?php echo $transition; ?>,			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                                transition_speed		:	2000,		// Speed of transition
                                new_window				:	1,			// Image links open in new window/tab
                                pause_hover             :   1,			// Pause slideshow on hover
                                keyboard_nav            :   0,			// Keyboard navigation on/off
                                performance				:	0,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
                                image_protect			:	1,			// Disables image dragging and right click with Javascript

                                // Size & Position
                                min_width		        :   0,			// Min width allowed (in pixels)
                                min_height		        :   0,			// Min height allowed (in pixels)
                                vertical_center         :   1,			// Vertically center background
                                horizontal_center       :   <?php echo $horizontalcenter; ?>,		// Horizontally center background
                                fit_always				:	<?php echo $fitalways; ?>,			    // Image will never exceed browser width or height (Ignores min. dimensions)
                                fit_portrait         	:   <?php echo $fitportrait; ?>,			// Portrait images will not exceed browser height
                                fit_landscape			:   <?php echo $fitlandscape; ?>,			// Landscape images will not exceed browser width

                                // Components
                                slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
                                thumb_links				:	0,			// Individual thumb links for each slide
                                thumbnail_navigation    :   0,			// Thumbnail navigation
                                slides 					:  	[
                                <?php
                                    $gallery   =  ot_get_option(THEME_PREFIX . '_gallery');
                                    if ( isset ( $gallery ) && !empty ( $gallery ) ) :
                                    $arr_image =  explode(',',$gallery);
                                    $count = count($arr_image);
                                        for($i = 0 ; $i < $count ; $i ++ ):
                                ?>
                                            <?php if ( $i < $count - 1 ) : ?>
                                                {image : "<?php echo wp_get_attachment_url($arr_image[$i]); ?>"},
                                            <?php else: ?>
                                                {image : "<?php echo wp_get_attachment_url($arr_image[$i]); ?>"}
                                            <?php endif; ?>

                                        <?php endfor; ?>
                                    <?php else: ?>
                                        {image : "<?php echo THEME_PATH.'/images/no-gallery.jpg'; ?>"}
                                    <?php endif; ?>
                                ],
                                // Theme Options
                                progress_bar			:	0,			// Timer for each slide
                                mouse_scrub				:	0
                            });
                        });
                    </script>
                    <div class="tz_slideshow">
                        <div id="tz_fullslide">
                            <div id="prevthumb"></div>
                            <div id="nextthumb"></div>
                            <div class="slide-des"></div>
                            <div id="sitebar_slide"><div class="slider-control"></div></div>
                        </div><!--end id tz_fullslide-->
                    </div><!--end class tz_slideshow-->
                </div><!--end class content-->
            </div><!--end class box-->
        </div><!--end class tz-inner-->
    </div><!--end class container-fluid-->
</section><!--end class tz-slideshow-->

<?php endif; ?>