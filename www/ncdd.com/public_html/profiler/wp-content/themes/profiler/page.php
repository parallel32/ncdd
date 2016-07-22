<?php get_header(); ?>

<?php
    get_template_part('template_inc/inc','gallery');
    $tzPage_sidebar = get_post_meta( get_the_ID() , THEME_PREFIX .'_TzPageDefault_Sidebar', true);

?>

<section id="tz-main">
    <div class="tz-main-body">
        <div class="container-fluid">
            <div class="tz-inner">
                <div class="tz-content-wrap row-fluid">
                    <div id="tz-content" class="span9 offset3">
                        <div id="tz-component" class="row-fluid">
                            <div class="tz-inner-content span">
                                <div class="TzItemPage item-page">
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post() ; ?>
                                    <div id=post-<?php the_ID() ?>  <?php post_class('TzItemPageInner') ?>>
                                        <div class="page-title"><?php the_title(); ?></div>
                                        <?php
                                            the_content();
                                            wp_link_pages();
                                        ?>
                                    </div><!--end class TzItemPageInner-->
                                    <?php endwhile; endif; ?>
                                </div><!--end classTzItemPage item-page-->
                            </div><!--end class tz-inner-content-->
                        </div><!--end id tz-component-->
                    </div><!--end idtz-content-->
                    <?php
                    get_sidebar();
                    get_template_part('template_inc/inc','header');
                    if($tzPage_sidebar == 'show'){
                        get_sidebar('right');
                    }
                    ?>
                <div class="clr"></div>
                </div><!--end class tz-content-wrap-->
            </div><!--end class tz-inner-->
        </div><!--end class container-fluid-->
    </div><!--end class tz-main-body-->
</section><!--end id tz-main-->
<?php get_footer(); ?>