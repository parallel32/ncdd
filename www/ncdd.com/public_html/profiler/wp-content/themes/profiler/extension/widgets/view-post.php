<?php

/*
 * Display posts
 * Widgets display posts by category
 */

class TzViewPost extends WP_Widget{

    /* function construct*/
    function __construct() {
       parent::__construct(
           'tz_view_post',__('View post', TEXT_DOMAIN),
           array('description' => __(' Display post by category ', TEXT_DOMAIN))
       );
    }

    /* function widget */
    function  widget($args,$instance){
        extract($args);
        if(isset($instance['tzcat']) && $instance['tzcat'] !=""):
            $cat = $instance['tzcat'];

            if(isset($instance['tzlimitpost']) && $instance['tzlimitpost']!=""){
                $tzlimit = $instance['tzlimitpost'];
            }else{
                $tzlimit = 5;
            }

            if(isset($instance['tzshowimage']) && $instance['tzshowimage']!=""){
                $tzshowimg = $instance['tzshowimage']    ;
            }else{
                $tzshowimg = "show";
            }
            if(isset($instance['tzshowtitle']) && $instance['tzshowtitle']!=""){
                $tzshowtitle     = $instance['tzshowtitle'];
            }else{
                $tzshowtitle    = "show";
            }

            if(isset($instance['tzshowexcerpt']) && $instance['tzshowexcerpt']!=""){
                $tzshowexcerpt  = $instance['tzshowexcerpt'];
            }else{
                $tzshowexcerpt  = "show";
            }
            if(isset($instance['tzshowinfo']) && $instance['tzshowinfo']!=""){
                $tzshowinfo  = $instance['tzshowinfo'];
            }else{
                $tzshowinfo  = "show";
            }

            $tzargs = array(
                'post_type'         => 'post',
                'posts_per_page'    => $tzlimit,
                'cat'               =>  $cat
            );

    ?>
            <aside class="fearture">
                <h3 class="module-title"><span><?php echo $instance['title']; ?></span></h3>
                <ul>
                    <?php
                        $tz_query = "";
                        $tz_query = new WP_Query($tzargs);
                        if($tz_query->have_posts()):
                            while($tz_query->have_posts()):
                                $tz_query->the_post();

                                $typeitem   =  get_post_meta( get_the_ID(), THEME_PREFIX . '_portfolio_type',true ) ;

                                $excerpt = get_the_excerpt();
                                $excerpt_ex = explode(' ', $excerpt);
                                $excerpt_slice = array_slice($excerpt_ex,0,$instance['limitexcerpt']);
                                $excerpt_content = implode(' ',$excerpt_slice);
                          if($typeitem !='link' && $typeitem !='quote'):
                    ?>
                    <li>
                        <div class="fearture-item">
                            <?php if($tzshowimg=='show'): ?>
                                <div class="tz-fearture-img">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                                </div><!--end class tz-fearture-img-->
                            <?php endif; ?>
                            <?php if($tzshowtitle=='show'): ?><h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6><?php endif; ?>
                            <?php if($tzshowexcerpt=='show'): echo '<p>'.$excerpt_content.'</p>' ; endif; ?>
                            <?php if($tzshowinfo=='show'): ?><span class="tzwginfo"><?php echo get_the_date(); ?> by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>"><?php the_author(); ?></a></span><?php endif; ?>
                        </div><!--end class fearture-item-->
                    </li>
                  <?php
                           endif;
                            endwhile; // end while(have_posts)

                        endif;  // end if(have_posts)
                    ?>
                </ul>
            </aside>
        <?php

        endif; // endif isset(category)

    }

    /* function form */
    function form($instance) {
        $instance = wp_parse_args( $instance, array(
            'title'             => 'Title',
            'tzlimitpost'       =>  5,
            'tzshowimage'       => 'show',
            'tzshowtitle'       =>  'show',
            'tzshowexcerpt'     =>  'show',
            'tzshowinfo'        =>  'show',
            'tzcat'             =>  '',
            'limitexcerpt'      =>  30
        ) );

    ?>
         <p>
             <label for="<?php echo $this->get_field_id('title'); ?>">
                 <?php echo _e('Title','dw'); ?>
             </label>
             <br>
             <input type="text" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" class="widefat" value="<?php echo $instance['title']; ?>" >
         </p>
         <p>
             <label for="<?php echo $this->get_field_id('tzcat'); ?>">
                 <?php echo _e('Category','dw'); ?>
             </label>

             <?php  wp_dropdown_categories( array( 'name' => $this->get_field_name("tzcat"),'show_count' => 1, 'selected' => $instance["tzcat"] ) ); ?>
         </p>
         <p>
             <label for="<?php echo $this->get_field_id('tzlimitpost'); ?>">
                <?php echo _e('Limit post','dw'); ?>
             </label>
             <input type="text" class="widefat"  id="<?php echo $this->get_field_id('tzlimitpost'); ?>" name="<?php echo $this->get_field_name('tzlimitpost'); ?>" value="<?php echo $instance['tzlimitpost']; ?>" >
         </p>
          <p>
             <label for="<?php echo $this->get_field_id('limitexcerpt'); ?>">
                <?php echo _e('Limit text excerpt','dw'); ?>
             </label>
             <input type="text" class="widefat"  id="<?php echo $this->get_field_id('limitexcerpt'); ?>" name="<?php echo $this->get_field_name('limitexcerpt'); ?>" value="<?php echo $instance['limitexcerpt']; ?>" >
         </p>
         <p>
             <label for="<?php echo $this->get_field_id('tzshowimage'); ?>">
                 <?php echo _e('Show Image','dw'); ?>
             </label>
             <select class="widefat"  name="<?php echo $this->get_field_name('tzshowimage'); ?>">
                 <option value="show" <?php if($instance['tzshowimage']=='show'){ echo 'selected="true"'; } ?>>Show</option>
                 <option value="hide" <?php if($instance['tzshowimage']=='hide'){ echo 'selected="true"'; } ?>>Hide</option>
             </select>
         </p>
         <p>
             <label for="<?php echo $this->get_field_id('tzshowtitle'); ?>">
                <?php echo _e('Show Title','dw'); ?>
             </label>
             <select class="widefat"  name="<?php echo $this->get_field_name('tzshowtitle'); ?>">
                <option value="show" <?php if($instance['tzshowtitle']=='show'){ echo 'selected="true"'; } ?>>Show</option>
                 <option value="hide" <?php if($instance['tzshowtitle']=='hide'){ echo 'selected="true"'; } ?>>Hide</option>
             </select>
         </p>
         <p>
             <label for="<?php echo $this->get_field_id('tzshowexcerpt'); ?>">
                <?php echo _e('Show excerpt','dw'); ?>
             </label>
             <select class="widefat"  name="<?php echo $this->get_field_name('tzshowexcerpt'); ?>">
                <option value="show" <?php if($instance['tzshowexcerpt']=='show'){ echo 'selected="true"'; } ?>>Show</option>
                 <option value="hide" <?php if($instance['tzshowexcerpt']=='hide'){ echo 'selected="true"'; } ?>>Hide</option>
             </select>
         </p>
         <p>
             <label for="<?php echo $this->get_field_id('tzshowinfo'); ?>">
                <?php echo _e('Show Info','dw'); ?>
             </label>
             <select class="widefat"  name="<?php echo $this->get_field_name('tzshowinfo'); ?>">
                <option value="show" <?php if($instance['tzshowinfo']=='show'){ echo 'selected="true"'; } ?>>Show</option>
                 <option value="hide" <?php if($instance['tzshowinfo']=='hide'){ echo 'selected="true"'; } ?>>Hide</option>
             </select>
         </p>
       <?php
    }

    /* function update */
    function update($new_instance,$old_instance){
        $instance = $old_instance ;
        $instance['title']          =   $new_instance['title'];
        $instance['tzlimitpost']    =   $new_instance['tzlimitpost'];
        $instance['tzcat']          =   $new_instance['tzcat'];
        $instance['tzshowtitle']    =   $new_instance['tzshowtitle'];
        $instance['tzshowexcerpt']  =   $new_instance['tzshowexcerpt'];
        $instance['tzshowimage']    =   $new_instance['tzshowimage'];
        $instance['tzshowinfo']    =   $new_instance['tzshowinfo'];
        $instance['limitexcerpt']    =   $new_instance['limitexcerpt'];
        return $instance;
    }
}
add_action('widgets_init',create_function('','return register_widget("TzViewPost");'));

?>