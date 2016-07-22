<?php
/*widget tz_user*/

class tz_user  extends WP_Widget {

    /* *
    * Register widget with WordPress.
    * parent user function class father
    */
    function  __construct() {
        parent::__construct(
            'tz_user', // Base Id
            __('Profile user', TEXT_DOMAIN), // NAME
            array('description' => __('Display profile user', TEXT_DOMAIN)) // args
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
     ?>
        <div class="custombox_profile">
            <?php if ( isset ( $instance['name'] ) && !empty ( $instance['name'] ) ): ?>
                <h3><?php echo $instance['name'] ; ?></h3>
            <?php endif; ?>
            <?php if ( isset ( $instance['email'] ) && !empty ( $instance['email'] ) ) : ?>
                <address><?php echo $instance['email'] ; ?></address>
            <?php endif; ?>
            <?php if ( isset ( $instance['position'] ) && !empty ( $instance['position'] ) ) : ?>
                <p><?php echo $instance['position'] ; ?></p>
            <?php endif; ?>
            <?php if ( isset ( $instance['description'] ) && !empty ( $instance['description'] ) ) : ?>
                <p class="user-description"><?php echo $instance['description'] ; ?></p>
            <?php endif; ?>
        </div><!--end class custombox_profile-->
    <?php
        echo $after_widget ;
    }

    /**
     * Back-end widget form
     */
    public function  form($instrance) {
        // wp_parse_args : set default values
        $instrance = wp_parse_args( $instrance, array(
            'title'          =>  'title',
            'name'           =>  'Name',
            'email'          =>  'in@gmail.com',
            'position'       =>  '',
            'description'    =>  '',


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
        <label for="<?php echo $this -> get_field_id('name') ?>" >
            <?php echo _e('Name','dw') ; ?>
        </label>
        <br>
        <input type="text" name="<?php echo $this -> get_field_name('name') ; ?>" id="<?php echo $this -> get_field_id('name'); ?>" class="widefat" value="<?php echo $instrance['name']; ?>">
    </p>
    <p>
        <label for="<?php echo $this -> get_field_id('email') ?>">
            <?php echo _e('Email','dw') ; ?>
        </label>
        <br>
        <input type="text" name="<?php echo $this -> get_field_name('email') ; ?>" id="<?php echo $this -> get_field_id('email'); ?>" class="widefat" value="<?php echo $instrance['email']; ?>">
    </p>
    <p>
        <label for="<?php echo $this -> get_field_id('position') ?>">
            <?php echo _e('Position','dw') ; ?>
        </label>
        <br>
        <input type="text" name="<?php echo $this -> get_field_name('position') ; ?>" id="<?php echo $this -> get_field_id('position'); ?>" class="widefat" value="<?php echo $instrance['position']; ?>">
    </p>
    <p>
        <label for="<?php echo $this -> get_field_id('description') ; ?>">
            <?php echo _e('Description','dw') ; ?>
        </label>
        <br>
        <textarea type="text" name="<?php echo $this -> get_field_name('description') ; ?>" id="<?php echo $this -> get_field_id('description'); ?>" class="widefat"><?php echo $instrance['description']; ?></textarea>
    </p>



    <?php
    }

    /* *
     * Method update
     */
    function update( $new_instance, $old_instance ) {
        $instance = array() ;
        $instance['title']     = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['name']  = ( ! empty( $new_instance['name'] ) ) ? strip_tags( $new_instance['name'] ) : ''  ;
        $instance['email']    = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : ''  ;
        $instance['position']   = ( ! empty( $new_instance['position'] ) ) ? strip_tags( $new_instance['position'] ) : ''  ;
        $instance['description']   = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : ''  ;
        return $instance ;
    }

}
/*register widget*/
function register_tz_user(){
    register_widget('tz_user');
}
add_action('widgets_init','register_tz_user') ;
?>