<?php
    /*widget social*/

   class tz_social  extends WP_Widget {

       /* *
       * Register widget with WordPress.
       * parent user function class father
       */
       function  __construct() {
           parent::__construct(
                'tz_social', // Base Id
                 __('Profiler Social', TEXT_DOMAIN), // NAME
                array('description' => __('Display soical', TEXT_DOMAIN)) // args
           ) ;
       }

       /**
       * Front-end display of widget
       */
       public function widget( $args, $instance ) {
            extract($args);
           $title = apply_filters('widget_title', $instance['title']);
           echo $before_widget ;
           if ( $title ) :
               echo $before_title.$title.$after_title ;
           endif;
           $arg_social = array(
               array('id'       =>  'facebook'),
               array('id'         =>  'google-plus'),
               array('id'        =>  'twitter'),
               array('id'        =>  'youtube'),
               array('id'          =>  'skype'),
               array('id'       =>  'linkedin'),
               array('id'       =>  'dribbble'),
               array('id'      =>  'pinterest'),
               array('id'         =>  'flickr')

           ) ;
       ?>
           <ul class="tz_social">
                <?php foreach($arg_social as $social):

                        if (!empty($instance[$social['id']])):
               ?>
                    <li>
                        <a href="<?php echo $instance[$social['id']]; ?>" class="fa fa-<?php echo $social['id']; ?>"></a>
                    </li>
                <?php
                        endif;
                        endforeach; ?>

           </ul>
       <?php
           echo $after_widget ;
       }

       /**
       * Back-end widget form
       */
       public function  form($instrance) {
           // wp_parse_args : set default values
           $instrance = wp_parse_args( $instrance, array(
                'title'       =>  'Social',
                'facebook'    =>  '',
                'google-plus'      =>  '',
                'twitter'     =>  '',
                'youtube'      =>  '',
                'skype'        =>  '',
                'linkedin'        =>  '',
                'dribbble'        =>  '',
                'pinterest'        =>  '',
                'flickr'        =>  ''

           ) );
       ?>
           <p>
               <label for="<?php echo $this ->  get_field_id('title'); ?>">
                    <?php echo _e('Title','dw') ; ?>
               </label>
               <br>
               <input type="text" name="<?php echo $this -> get_field_name('title') ; ?>" id="<?php echo $this -> get_field_id('title'); ?>" class="widefat" value="<?php echo $instrance['title']; ?>">
           </p>
           <p>
               <label for="<?php echo $this -> get_field_id('facebook') ?>" >
                   <?php echo _e('Facebook','dw') ; ?>
               </label>
               <br>
               <input type="text" name="<?php echo $this -> get_field_name('facebook') ; ?>" id="<?php echo $this -> get_field_id('facebook'); ?>" class="widefat" value="<?php echo $instrance['facebook']; ?>">
           </p>
       <p>
           <label for="<?php echo $this -> get_field_id('google-plus') ?>">
               <?php echo _e('Google','dw') ; ?>
           </label>
           <br>
           <input type="text" name="<?php echo $this -> get_field_name('google-plus') ; ?>" id="<?php echo $this -> get_field_id('google-plus'); ?>" class="widefat" value="<?php echo $instrance['google-plus']; ?>">
       </p>
       <p>
           <label for="<?php echo $this -> get_field_id('twitter') ?>">
               <?php echo _e('Twitter','dw') ; ?>
           </label>
           <br>
           <input type="text" name="<?php echo $this -> get_field_name('twitter') ; ?>" id="<?php echo $this -> get_field_id('twitter'); ?>" class="widefat" value="<?php echo $instrance['twitter']; ?>">
       </p>
       <p>
           <label for="<?php echo $this -> get_field_id('youtube') ?>">
               <?php echo _e('Youtube','dw') ; ?>
           </label>
           <br>
           <input type="text" name="<?php echo $this -> get_field_name('youtube') ; ?>" id="<?php echo $this -> get_field_id('youtube'); ?>" class="widefat" value="<?php echo $instrance['youtube']; ?>">
       </p>
       <p>
           <label for="<?php echo $this -> get_field_id('skype'); ?>">
               <?php echo _e('Skype','dw') ; ?>
           </label>
           <br>
           <input type="text" name="<?php echo $this -> get_field_name('skype') ; ?>" id="<?php echo $this -> get_field_id('skype'); ?>" class="widefat" value="<?php echo $instrance['skype']; ?>">
       </p>
       <p>
           <label for="<?php echo $this -> get_field_id('linkedin') ?>">
               <?php echo _e('linkedin','dw') ; ?>
           </label>
           <br>
           <input type="text" name="<?php echo $this -> get_field_name('linkedin') ; ?>" id="<?php echo $this -> get_field_id('linkedin'); ?>" class="widefat" value="<?php echo $instrance['linkedin']; ?>">
       </p>
       <p>
           <label for="<?php echo $this -> get_field_id('dribbble') ?>">
               <?php echo _e('Dribbble','dw') ; ?>
           </label>
           <br>
           <input type="text" name="<?php echo $this -> get_field_name('dribbble') ; ?>" id="<?php echo $this -> get_field_id('dribbble'); ?>" class="widefat" value="<?php echo $instrance['dribbble']; ?>">
       </p>
       <p>
           <label for="<?php echo $this -> get_field_id('pinterest') ?>">
               <?php echo _e('Pinterest','dw') ; ?>
           </label>
           <br>
           <input type="text" name="<?php echo $this -> get_field_name('pinterest') ; ?>" id="<?php echo $this -> get_field_id('pinterest'); ?>" class="widefat" value="<?php echo $instrance['pinterest']; ?>">
       </p>
       <p>
           <label for="<?php echo $this -> get_field_id('flickr') ?>">
               <?php echo _e('Flickr','dw') ; ?>
           </label>
           <br>
           <input type="text" name="<?php echo $this -> get_field_name('flickr') ; ?>" id="<?php echo $this -> get_field_id('flickr'); ?>" class="widefat" value="<?php echo $instrance['flickr']; ?>">
       </p>

       <?php
       }

       /* *
        * Method update
        */
       function update( $new_instance, $old_instance ) {
           $instance = array() ;
           $instance['title']     = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
           $instance['facebook']  = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : ''  ;
           $instance['google-plus']    = ( ! empty( $new_instance['google-plus'] ) ) ? strip_tags( $new_instance['google-plus'] ) : ''  ;
           $instance['twitter']   = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : ''  ;
           $instance['youtube']   = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : ''  ;
           $instance['skype']     = ( ! empty( $new_instance['skype'] ) ) ? strip_tags( $new_instance['skype'] ) : ''  ;
           $instance['linkedin']  = ( ! empty( $new_instance['linkedin'] ) ) ? strip_tags( $new_instance['linkedin'] ) : ''  ;
           $instance['dribbble']  = ( ! empty( $new_instance['dribbble'] ) ) ? strip_tags( $new_instance['dribbble'] ) : ''  ;
           $instance['pinterest'] = ( ! empty( $new_instance['pinterest'] ) ) ? strip_tags( $new_instance['pinterest'] ) : ''  ;
           $instance['flickr']    = ( ! empty( $new_instance['flickr'] ) ) ? strip_tags( $new_instance['flickr'] ) : ''  ;
           return $instance ;
       }

   }
   /*register widget*/
   function register_tz_social(){
       register_widget('tz_social');
   }
   add_action('widgets_init','register_tz_social') ;
?>