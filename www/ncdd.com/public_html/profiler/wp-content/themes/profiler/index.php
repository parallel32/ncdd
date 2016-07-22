<?php get_header(); ?>
<?php

get_template_part('template_inc/inc','gallery');
?>

<section id="tz-main">
    <div class="tz-main-body">
        <div class="container-fluid">
            <div class="tz-inner">
                <div class="tz-content-wrap row-fluid">
                    <div id="tz-content" class="span9 offset3">
                        <div id="tz-component" class="row-fluid">
                            <div class="tz-inner-content span">
                                <div class="TzBlog blog">
                                    <div class="TzBlogInner">
                                        <div class="row-fluid">
                                            <?php
                                            if(have_posts()) :
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
                    ?>
                    <div class="clr"></div>
                </div><!--end class tz-content-wrap-->
            </div><!--end class tz-inner-->
        </div><!--end class container-fluid-->
    </div><!--end class tz-main-body-->
</section><!--end id tz-main-->
<?php get_footer(); ?>