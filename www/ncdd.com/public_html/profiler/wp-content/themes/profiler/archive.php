<?php get_header(); ?>
<?php

get_template_part('template_inc/inc','gallery');
?>
<?php
    $spanblog = 'span9';
    if ( ( is_category() || is_tax('portfolio-category') ) && $TZcategorysidebar == 'show' ) :
        $spanblog = 'span6';
    elseif ( ( is_tag() || is_tax('portfolio-tags') ) && $TZtagsidebar == 'show' ):
        $spanblog = 'span6';
    elseif ( is_author() && $TZauthorsidebar == 'show' ):
        $spanblog = 'span6';
    endif;
?>
<section id="tz-main">
    <div class="tz-main-body">
        <div class="container-fluid">
            <div class="tz-inner">
                <div class="tz-content-wrap row-fluid">
                    <div id="tz-content" class="<?php echo $spanblog; ?> offset3">
                        <div id="tz-component" class="row-fluid">
                            <div class="tz-inner-content span">
                                <div class="TzBlog blog">
                                    <div class="TzBlogInner">
                                         <div class="row-fluid">
                                        <?php
                                        if(have_posts()) :
                                            if ( is_author() ) :
                                        ?>
                                            <div class="clr"></div>
                                            <div class="tz_portfolio_user tz_portfolio_clear">
                                                <div class="AuthorBlock">
                                                    <div class="AuthorDetails">
                                                        <div class="AuthorAvatar">
                                                            <?php echo get_avatar(get_the_author_meta('ID'),160); ?>
                                                        </div>
                                                    </div><!--end class AuthorDetails-->
                                                    <div class="TzAuthorInfo">
                                                        <h3 class="AuthorName">
                                                            <?php the_author() ; ?>
                                                        </h3><!--end class AuthorName-->
                                                        <p><?php the_author_meta('description') ; ?></p>
                                                    </div><!--end class TzAuthorInfo-->
                                                    <div class="clr"></div>
                                                </div><!--end class AuthorBlock-->
                                            </div><!--end class tz_portfolio_user-->
                                        <?php rewind_posts() ; ?>
                                        <?php else: ?>

                                                <h1 class="page-title">
                                                    <?php
                                                        if ( is_category() ):
                                                            echo single_cat_title();
                                                        elseif ( is_tag() ):
                                                            echo single_tag_title() ;
                                                        elseif ( is_tax('portfolio-tags') ):
                                                            echo single_tag_title() ;
                                                        elseif ( is_tax('portfolio-category') ):
                                                            echo single_cat_title();
                                                        elseif ( is_day() ):
                                                            printf( __( 'Archives %s', TEXT_DOMAIN ),  get_the_date() );
                                                        elseif ( is_month() ) :
                                                            printf( __( 'Archives %s', TEXT_DOMAIN ),  get_the_date( _x( 'F Y', 'monthly archives date format', THEME_NAME ) )  );
                                                        elseif ( is_year() ) :
                                                            printf( __( 'Archives %s', TEXT_DOMAIN ),  get_the_date( _x( 'Y', 'yearly archives date format', THEME_NAME ) )  );
                                                        else :
                                                            _e( 'Archives', TEXT_DOMAIN );
                                                        endif;
                                                    ?>
                                                </h1>
                                            <?php endif; // endif is_author ?>
                                            <?php
                                                 while( have_posts() ): the_post() ;

                                                    $post_type = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_type', true ) ;

                                            ?>
                                                <div <?php post_class('TzItemsLeading'); ?>>
                                                    <?php
                                                        switch ($post_type):
                                                            case'link':
                                                                get_template_part('template_inc/loop','link');
                                                                break;
                                                            case'quote':
                                                                get_template_part('template_inc/loop','quote');
                                                                break;
                                                            default:
                                                                get_template_part('template_inc/loop','image');
                                                            break;
                                                        endswitch;
                                                    ?>
                                                </div><!--end class TzItemsLeading-->
                                            <?php
                                                endwhile ; // endwhile (have_post)
                                            ?>
                                                <div class="clearfix"></div>
                                                <div class="TzPagination">
                                                    <?php
                                                        if ( function_exists('wp_pagenavi') ):
                                                            wp_pagenavi();
                                                        else:
                                                            plazart_content_nav('bottom-nav');
                                                        endif;
                                                    ?>
                                                </div><!--end class TzPagination-->
                                                <div class="clearfix"></div>
                                            <?php
                                                endif;  // endif ( have_post )
                                            ?>
                                        </div><!--end class row-fluid-->
                                    </div><!--end class TzBlogInner-->
                                </div><!--end class tzblog-->
                            </div><!--end class tz-inner-content-->
                        </div><!--end class tz-component-->
                    </div><!--end idtz-content-->
                    <?php
                    get_sidebar();
                    get_template_part('template_inc/inc','header');
                    if ( is_category() && $TZcategorysidebar == 'show' ) :
                        get_sidebar('right');
                    elseif ( ( is_tag() || is_tax('portfolio-tags') ) && $TZtagsidebar == 'show' ):
                        get_sidebar('right');
                    elseif ( is_author() && $TZauthorsidebar == 'show' ):
                        get_sidebar('right') ;
                    endif;

                    ?>
                    <div class="clr"></div>
                </div><!--end class tz-content-wrap-->
            </div><!--end class tz-inner-->
        </div><!--end class container-fluid-->
    </div><!--end class tz-main-body-->
</section><!--end id tz-main-->
<?php get_footer(); ?>