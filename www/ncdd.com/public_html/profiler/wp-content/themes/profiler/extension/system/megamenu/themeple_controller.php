<?php


if(! class_exists('themple_controller')){

    /**
     * themeple_controller
     *
     * @package
     * @author roshi
     * @copyright roshi[www.themeforest.net/user/roshi]
     * @version 2012
     * @access public
     */
    class themeple_controller{

        var $base_data;
        var $db_options_prefix;
        var $admin_pages = array();
        var $page_elements = array();
        var $subs = array();
        var $options = array();
        var $current;
        /**
         * themeple_controller::themeple_controller()
         *
         * @param mixed $base_data
         * @return
         */
        function themeple_controller($base_data){

            new themeple_custom_menu($this);


        }

    }




}



?>