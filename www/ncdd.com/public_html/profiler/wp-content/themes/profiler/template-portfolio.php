<?php
    /*
     * Template Name: template portfolio
     */
?>
<?php get_header(); ?>

<?php

get_template_part('template_inc/inc','gallery');
$tzPage_sidebar      =    get_post_meta( get_the_ID() , THEME_PREFIX .'_TzPageDefault_Sidebar', true);
$tzcat               =    get_post_meta( get_the_ID(), THEME_PREFIX . '_TZcategory', true );
$tzfilter            =    get_post_meta( get_the_ID(), THEME_PREFIX . '_TZPortfoliofilter', true );
$tzfiltertype        =    get_post_meta( get_the_ID(), THEME_PREFIX . '_TZPorfiltertype', true );
$tzorderby           =    get_post_meta( get_the_ID(), THEME_PREFIX . '_TZPortfolioOrderby', true );
$tzorder             =    get_post_meta( get_the_ID(), THEME_PREFIX . '_TZPortfolioOrder', true );
$tzlimit             =    get_post_meta( get_the_ID(), THEME_PREFIX . '_TZPortfoliolimit', true );
$tzdate              =    get_post_meta( get_the_ID(), THEME_PREFIX . '_TZPortfolioshowdate', true );
$tztags              =    get_post_meta( get_the_ID(), THEME_PREFIX . '_TZPortfolioshowtags', true );

?>
<section id="tz-main">
    <div class="tz-main-body">
        <div class="container-fluid">
            <div class="tz-inner">
                <div class="tz-content-wrap row-fluid">
                    <div id="tz-content" class="span9 offset3">
                        <div id="tz-component" class="row-fluid">
                            <div class="tz-inner-content span ">
                                <div id="TzContent">
                                    <h1 class="page-title"><?php the_title(); ?></h1>
                                    <?php if ( $tzfilter == 'show' ) : ?>
                                        <div id="tz_options" class="clearfix">
                                            <div class="option-combo">
                                                <div id="filter" class="option-set clearfix" data-option-key="filter">
                                                    <a href="#show-all" data-option-value="*" class="tag-filter selected">Show all</a>
                                                    <?php
                                                        if ( $tzfiltertype == 'tags' ):
                                                            $tags = get_terms('portfolio-tags', 'orderby=count%hide_empty=0');
                                                            if ($tags != false):
                                                                foreach ( $tags as $tag ):
                                                                ?>
                                                                    <a class="tzhide" id="<?php echo THEME_PREFIX. '-' .$tag->slug ; ?>" href="#<?php $tag->name; ?>" class="tag-filter" data-option-value=".<?php echo THEME_PREFIX. '-'. $tag -> slug ; ?>"><?php echo $tag -> name; ?></a>
                                                                <?php
                                                                endforeach;
                                                            endif;
                                                        elseif ( $tzfiltertype == 'category' ):
                                                             $category = get_portfolio_categories();
                                                                if ( isset($category) && !empty ($category) ):
                                                                    foreach ( $category as $catf ):
                                                                        ?>
                                                                            <a class="tzhide" id="<?php echo THEME_PREFIX. '-' .$catf->slug ; ?>" href="#<?php $catf->name; ?>" class="tag-filter" data-option-value=".<?php echo THEME_PREFIX. '-'. $catf -> slug ; ?>"><?php echo $catf -> name; ?></a>
                                                                        <?php
                                                                    endforeach;
                                                                endif;
                                                        endif;
                                                    ?>
                                                </div><!--end id filter-->
                                            </div><!--end class option-combo-->
                                        </div><!--end id tz_options-->
                                    <?php endif; ?>
                                    <div id="portfolio" class="super-list variable-sizes clearfix">
                                        <?php
                                            if ( get_query_var('paged') ):
                                                $paged = get_query_var('paged');
                                            elseif ( get_query_var('page') ):
                                                $paged = get_query_var('page');
                                            else:
                                                $paged = 1 ;
                                            endif;


                                            if ( isset( $tzcat ) && !empty( $tzcat )):
                                                $tz = array();
                                                if(is_array($tzcat)){
                                                    sort($tzcat);
                                                    $count_cat  =   count($tzcat);
                                                    for( $i=0 ; $i< $count_cat ; $i++ ){
                                                        $tz[]  =   (int)$tzcat[$i];
                                                    }

                                                }else{
                                                    $tz[]    = (int)$tzcat;
                                                }
                                                $args =  array(
                                                    'post_type'      =>  'portfolio',
                                                    'posts_per_page' =>  $tzlimit,
                                                    'paged'          =>  $paged ,
                                                    'orderby'        =>  $tzorderby,
                                                    'order'          =>  $tzorder,
                                                    'tax_query'      =>  array(
                                                        array(
                                                            'taxonomy' =>  'portfolio-category',
                                                            'field'    =>  'id',
                                                            'terms'    =>  $tz
                                                        )
                                                    )
                                                );
                                            else:
                                                $args =  array(
                                                    'post_type'      =>  'portfolio',
                                                    'posts_per_page' =>  $tzlimit,
                                                    'paged'          =>  $paged ,
                                                    'orderby'        =>  $tzorderby,
                                                    'order'          =>  $tzorder
                                                );
                                            endif;


                                            $portfolio_query = '';
                                            $portfolio_query = new WP_Query( $args ) ;
                                            if ( $portfolio_query ->have_posts() ): while ( $portfolio_query -> have_posts() ): $portfolio_query -> the_post() ;
                                                $tags = get_the_terms($post -> ID , 'portfolio-tags' );
                                                $categorys = get_the_terms($post -> ID , 'portfolio-category' );
                                                $featured = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_featured', true ) ;
                                                $class_featured = '';
                                                if ( $featured == 'yes' ) :
                                                    $class_featured = 'tz_feature_item';
                                                endif;
                                                if(has_post_thumbnail($post->ID)==true){
                                                    $src_att      = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                                                    $imageWidth   =     $src_att[1] ;
                                                    $imageHeight  =     $src_att[2];
                                                    $ratio        =     $imageWidth/$imageHeight;
                                                    $imagetype    =     '' ;
                                                    $landscape    =     '' ;
                                                    $portrait     =     '' ;
                                                    if($ratio <= 0.75){
                                                        $imagetype = 'tz_image_portrait';
                                                        $portrait  = 'tz-media-portrait' ;
                                                    }
                                                    if($ratio > 1.75){
                                                        $imagetype = 'tz_image_landscape tz_feature_item';
                                                        $landscape = 'TZPortfolioMedium';
                                                    }
                                                }
                                                // tags
                                                $class_tags = '' ;
                                                if ( $tags != false ):
                                                    $count = count($tags);
                                                    $it = 0;
                                                    foreach ( $tags as $tag ):
                                                        $it ++ ;
                                                        $tags_link = get_term_link( $tag , 'portfolio-tags' );
                                                        if( is_wp_error( $tags_link ) )
                                                        continue ;
                                                        $class_tags .='<a href="'.$tags_link.'">'.$tag->name;
                                                        if ( $it < $count ):
                                                            $class_tags .=',';
                                                        endif;
                                                        $class_tags .= ' </a>' ;
                                                    endforeach;
                                                endif;
                                                // tags filter
                                                $class_filter = '';
                                                if ( $tzfiltertype == 'tags' ):
                                                     if ( $tags != false ):
                                                        foreach ( $tags as $tag_item ) :
                                                            $class_filter .= THEME_PREFIX. '-' .$tag->slug . '';
                                                            $class_filter .= " ";
                                                        endforeach ;
                                                     endif;
                                                elseif ( $tzfiltertype == 'category' ):
                                                    if ( $categorys != '' ):
                                                        foreach ( $categorys as $cat_item ) :
                                                            $class_filter .= THEME_PREFIX. '-' .$cat_item->slug ;
                                                            $class_filter .= " ";
                                                        endforeach ;
                                                    endif;
                                                endif;
                                        ?>
                                                <div id="tzelement<?php the_ID() ; ?>" <?php post_class("element tz_item $class_featured $imagetype $class_filter") ; ?>>
                                                    <div class="TzInner">

                                                        <div class="tz-media-content <?php echo $portrait.' '.$class_featured; ?>-media">
                                                            <div class="TzPortfolioMedia <?php echo $landscape ?>">
                                                                <div class="tz_portfolio_image">
                                                                    <a href="<?php the_permalink() ; ?>"><?php the_post_thumbnail() ; ?></a>
                                                                </div><!--end class tz_portfolio_image-->
                                                            </div><!--end class TzPortfolioMedia-->
                                                           <div class="bg-portfolio-item"></div>
                                                           <div class="Center-Container-feature is-Table Clear">
                                                                <div class="Table-Cell">
                                                                    <a href="<?php the_permalink() ?>" class="portfolio-hover"></a>
                                                                    <div class="Center-Block">
                                                                        <div class="TzPortfolioDescription">
                                                                            <a href="<?php the_permalink() ?>" class="portfolio-hover"></a>
                                                                            <h3 class="TzPortfolioTitle name">
                                                                                <a href="<?php the_permalink() ; ?>"><?php the_title() ; ?>                                                                               </a>
                                                                            </h3>
                                                                            <div class="TzArticle-info">
                                                                                <?php if ( $tzdate == 'show' ) : ?>
                                                                                    <div class="TzPortfolioDate">
                                                                                        <?php echo get_the_date() ?>
                                                                                    </div><!--end class TzPortfolioDate-->
                                                                                <?php endif; ?>
                                                                                <?php if ( $tztags == 'show' ) : ?>
                                                                                    <div class="des-tags">
                                                                                        <span class="tagName">
                                                                                            <?php echo $class_tags; ?>
                                                                                        </span>
                                                                                    </div><!--end class des-tags-->
                                                                                <?php endif; ?>
                                                                            </div><!--end class TzArticle-info-->
                                                                        </div><!--end class TzPortfolioDescription-->
                                                                    </div><!--end class Center-Block-->
                                                                </div><!--end class Table-Cell-->

                                                            </div><!--end class is-Table-->
                                                        </div><!--end class tz-media-content-->
                                                    </div><!--Inner-->
                                                </div><!--end class element-->
                                            <?php
                                                    endwhile;
                                                endif;
                                            wp_reset_postdata();
                                            ?>
                                    </div><!--end id portfolio-->
                                    <div id="tz_append"></div>
                                    <div id="loadaj">
                                        <?php
                                            if ( function_exists( 'wp_pagenavi' )):
                                                wp_pagenavi( array('query' => $portfolio_query) ) ;
                                            endif;
                                        ?>
                                    </div>
                                </div><!--end idcontent -->
                                <div class="loadering">
                                    <div class="bubblingG">
                                        <span id="bubblingG_1">&nbsp;</span>
                                        <span id="bubblingG_2">&nbsp;</span>
                                        <span id="bubblingG_3">&nbsp;</span>
                                    </div>
                                </div>
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