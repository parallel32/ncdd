<?php

do_action('themeple_action_before_initialization');

require('config.inc.php');

require('themeple_controller.php');
$themeple_base_data = '';

$themeple_base_data = apply_filters('themeple_filter_base_data', $themeple_base_data);

$controller = new themeple_controller($themeple_base_data);

?>