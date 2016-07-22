<?php
 /* *
  * widgets contact info
  **/
  class tz_contact_info extends WP_Widget{

      /*function construct*/
      public function __construct() {
          parent::__construct(
            'contact_info',__('Contact info',TEXT_DOMAIN),
             array('description'=>__('Display Contact info', TEXT_DOMAIN))
          );
      }

      /**
       * font-end widgets
      */
      public function widget($args, $instance) {
          extract($args);
          $title = apply_filters('widget_title', $instance['title']);

          echo $before_widget;

          if($title) {
              echo $before_title.$title.$after_title;
          }

      ?>
          <ul class="tzcontact-info">
            <?php  if($instance['address']): ?>
            <li>
                <i class="fa fa-map-marker"></i>
                <span><?php  echo $instance['address'];  ?></span>
                <div class="clearfix"></div>
            </li>
            <?php  endif; ?>
            <?php  if($instance['phone']): ?>
            <li>
                <i class="fa fa-phone-square"></i>
                <span><?php echo $instance['phone']; ?></span>
                <div class="clearfix"></div>
            </li>
            <?php  endif; ?>
            <?php if($instance['mobile']): ?>
              <li>
                  <i class="fa fa-mobile"></i>
                  <span><?php   echo $instance['mobile'];  ?></span>
                  <div class="clearfix"></div>
              </li>

            <?php endif; ?>
            <?php if($instance['fax']): ?>
                <li>
                    <i class="fa fa-print""></i>
                    <span><?php echo $instance['fax']; ?></span>
                    <div class="clearfix"></div>
                </li>
            <?php endif; ?>
            <?php if($instance['email']): ?>
                <li>
                    <i class="fa fa-envelope-o"></i>
                    <span><?php echo $instance['email']; ?></span>
                    <div class="clearfix"></div>
                </li>
            <?php endif; ?>
              <?php if($instance['website']): ?>
                <li>
                    <i class="fa fa-chain-broken"></i>
                    <span><?php echo $instance['website']; ?></span>
                    <div class="clearfix"></div>
                </li>
            <?php endif; ?>
          </ul>
      <?php
          echo $after_widget;
      }

      /**
       * Back-end widgets form
      */
      public function form($instance){
          $instance =   wp_parse_args($instance,array(
              'title'   =>  'Contact info',
              'address' =>  '',
              'phone'   =>  '',
              'mobile'  =>  '',
              'fax'     =>  '',
              'email'   =>  '',
              'website' =>  ''
          ));
          ?>
          <p>
              <label for=<?php echo $this->get_field_id('title'); ?>><?php echo _e('Title:',TEXT_DOMAIN) ; ?></label>
              <input type="text" id="<?php echo $this->get_field_id('title'); ?>" class="widefat" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
          </p>
          <p>
              <label for="<?php echo $this->get_field_id('address'); ?>"><?php echo _e('Address:',TEXT_DOMAIN); ?></label>
              <input type="text" id="<?php echo $this->get_field_id('address') ?>" class="widefat" name="<?php echo $this->get_field_name('address') ?>" value="<?php echo $instance['address']; ?>" />
          </p>
          <p>
              <label for="<?php echo $this->get_field_id('phone'); ?>"><?php echo _e( 'Phone:', TEXT_DOMAIN ); ?></label>
              <input type="text" id="<?php echo $this->get_field_id('phone'); ?>" class="widefat" name="<?php echo $this->get_field_name('phone'); ?>" value="<?php echo $instance['phone']; ?>" />
          </p>
          <p>
              <label for="<?php echo $this->get_field_id('mobile'); ?>"><?php echo _e( 'Mobile:', TEXT_DOMAIN ); ?></label>
              <input type="text" id="<?php echo $this->get_field_id('mobile'); ?>" class="widefat" name="<?php echo $this->get_field_name('mobile'); ?>" value="<?php echo $instance['mobile']; ?>" />
          </p>
          <p>
              <label for="<?php echo $this->get_field_id('fax'); ?>"><?php echo _e('Fax:', TEXT_DOMAIN); ?></label>
              <input type="text" id="<?php echo $this->get_field_id('fax'); ?>" name="<?php echo $this->get_field_name('fax'); ?>" class="widefat" value="<?php echo $instance['fax']; ?>" />
          </p>
          <p>
              <label for="<?php echo $this->get_field_id('email') ?>"><?php echo _e('Email:', TEXT_DOMAIN); ?></label>
              <input type="text" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" class="widefat" value="<?php echo $instance['email']; ?>" />
          </p>
          <p>
              <label for="<?php echo $this->get_field_id('website'); ?>"><?php echo _e('Website:', TEXT_DOMAIN); ?></label>
              <input type="text" id="<?php echo $this->get_field_id('website'); ?>" name="<?php echo $this->get_field_name('website'); ?>" class="widefat" value="<?php echo $instance['website']; ?>" />
          </p>
      <?php
      }

      /**
      * function update widget
      */
      public function update( $new_instance, $old_instance ) {
          $instance = $old_instance;
          $instance['title'] = $new_instance['title'];
          $instance['address'] = $new_instance['address'];
          $instance['phone']    =   $new_instance['phone'];
          $instance['mobile'] = $new_instance['mobile'];
          $instance['fax'] = $new_instance['fax'];
          $instance['email']    =   $new_instance['email'];
          $instance['website']    =   $new_instance['website'];
          return $instance;
      }
  }
  function register_tzcontact_info(){
      register_widget('tz_contact_info');
  }
  add_action('widgets_init','register_tzcontact_info');
?>