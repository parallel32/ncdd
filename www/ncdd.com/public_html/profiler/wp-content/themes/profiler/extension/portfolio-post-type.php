<?php
  /*
  *	---------------------------------------------------------------------
  *	This file create and contains the portfolio post_type meta elements
  *	---------------------------------------------------------------------
  */
  add_action('init', THEME_PREFIX . '_create_portfolio');
  function plazart_create_portfolio()
  {
    $labels = array(
      'name'               => _x('Portfolio', 'Portfolio General Name', TEXT_DOMAIN),
      'singular_name'      => _x('Portfolio Item', 'Portfolio Singular Name', TEXT_DOMAIN),
      'add_new'            => _x('Add New', 'Add New Portfolio Name', TEXT_DOMAIN),
      'add_new_item'       => __('Add New Portfolio', TEXT_DOMAIN),
      'edit_item'          => __('Edit Portfolio', TEXT_DOMAIN),
      'new_item'           => __('New Portfolio', TEXT_DOMAIN),
      'view_item'          => __('View Portfolio', TEXT_DOMAIN),
      'search_items'       => __('Search Portfolio', TEXT_DOMAIN),
      'not_found'          => __('Nothing found', TEXT_DOMAIN),
      'not_found_in_trash' => __('Nothing found in Trash', TEXT_DOMAIN),
      'parent_item_colon'  => ''
    );
    $args = array(
      'labels'             => $labels,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'query_var'          => true,
      //'menu_icon' => THEME_PATH . '/plazart/assets/images/portfolio-icon.png',
      'rewrite'            => true,
      'capability_type'    => 'post',
      'hierarchical'       => false,
      'menu_position'      => 5,
      'supports'           => array('title', 'editor','author','excerpt', 'thumbnail', 'custom-fields','comments'), //'editor', 'excerpt', 'comments',
      'rewrite'            => array('slug' => 'portfolio', 'with_front' => false ),
      //'has_archive'        => 'portfolio'
    );
    register_post_type('portfolio', $args);
    register_taxonomy(
      "portfolio-category", array( "portfolio" ), array(
      "hierarchical"   => true,
      "label"          => "Portfolio Categories",
      "singular_label" => "Portfolio Categories",
      "rewrite"        => true ));
    register_taxonomy_for_object_type('portfolio-category', 'portfolio');

      // function tags
      register_taxonomy(
          "portfolio-tags",array("portfolio"), array(
              "hierarchical"   =>   '',
              "label"          =>   "Portfolio Tags",
              "singular_label" =>   "Portfolio Tags",
              "rewrite"        =>   ''
          )
      );
      register_taxonomy_for_object_type('protfolio-tags','portfolio');
  }

  // filter for portfolio first page
  add_filter("manage_edit-portfolio_columns", THEME_PREFIX . "_show_portfolio_column");
  function plazart_show_portfolio_column($columns)
  {
    $columns = array(
      "cb"                 => "<input type=\"checkbox\" />",
      "title"              => "Title",
      "author"             => "Author",
      "portfolio-category" => "Portfolio Categories",
      "portfolio-tags"     => "Portfolio Tags",
      "date"               => "date" );

    return $columns;
  }

  add_action("manage_posts_custom_column", THEME_PREFIX . "_portfolio_custom_columns");
  function plazart_portfolio_custom_columns($column)
  {
    global $post;
    switch ($column) {
      case "portfolio-category":
        echo get_the_term_list($post->ID, 'portfolio-category', '', ', ', '');
        break;
        case "portfolio-tags":
            echo get_the_term_list($post->ID, 'portfolio-tags', '', ', ', '');
            break;
    }
  }

  function get_portfolio_categories(){
    $taxonomy     = 'portfolio-category';
    $orderby      = 'name';
    $show_count   = 0;      // 1 for yes, 0 for no
    $pad_counts   = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no
    $title        = '';
    $empty        = 0;

    $args = array(
      'taxonomy'     => $taxonomy,
      'orderby'      => $orderby,
      'show_count'   => $show_count,
      'pad_counts'   => $pad_counts,
      'hierarchical' => $hierarchical,
      'title_li'     => $title,
      'hide_empty'   => $empty
    );

    $categories = get_categories( $args );

    return $categories;
  }

