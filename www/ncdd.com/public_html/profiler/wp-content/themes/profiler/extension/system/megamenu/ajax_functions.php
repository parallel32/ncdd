<?php




if(!function_exists('themeple_custom_change_walker'))

{

	function themeple_custom_change_walker()

	{	

		if ( ! current_user_can( 'edit_theme_options' ) )

		die('-1');



		check_ajax_referer( 'add-menu_item', 'menu-settings-column-nonce' );

	

		require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

	

		$item_ids = wp_save_nav_menu_items( 0, $_POST['menu-item'] );

		if ( is_wp_error( $item_ids ) )

			die('-1');

	

		foreach ( (array) $item_ids as $menu_item_id ) {

			$menu_obj = get_post( $menu_item_id );

			if ( ! empty( $menu_obj->ID ) ) {

				$menu_obj = wp_setup_nav_menu_item( $menu_obj );

				$menu_obj->label = $menu_obj->title; 

				$menu_items[] = $menu_obj;

			}

		}

	

		if ( ! empty( $menu_items ) ) {

			$args = array(

				'after' => '',

				'before' => '',

				'link_after' => '',

				'link_before' => '',

				'walker' => new themeple_custom_menu_backend,

			);

			echo walk_nav_menu_tree( $menu_items, 0, (object) $args );

		}

		

		die('end');

	}

	

	//hook into wordpress admin.php

	add_action('wp_ajax_themeple_custom_change_walker', 'themeple_custom_change_walker');

}

?>