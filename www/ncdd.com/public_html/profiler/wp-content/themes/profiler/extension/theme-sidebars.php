<?php
  // enable and register custom sidebar
  if (function_exists('register_sidebar')) {
    // default sidebar array
    $sidebar_attr = array(
      'name'          => '',
      'id'            => '',
      'description'   => '',
      'before_widget' => '<aside id="%1$s" class="%2$s widget">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3 class="module-title"><span>',
      'after_title'   => '</span></h3>'
    );

    $id = 0;
    $sidebars = array(
                       "Sidebar left"=>"Display sidebar on all page",
                        "Sidebar right"=>"Display sidebar on all page"
                     );
      foreach ($sidebars as $key=>$value) {
          $sidebar_attr['name'] = $key;
          $sidebar_attr['description']=$value;
          $sidebar_attr['id'] = THEME_PREFIX . '-sidebar-' . $id++;
          register_sidebar($sidebar_attr);
      }


  }



