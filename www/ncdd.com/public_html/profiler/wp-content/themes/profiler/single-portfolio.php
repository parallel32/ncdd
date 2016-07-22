<?php get_header(); ?>
<?php get_template_part( 'template/inc', 'gallery' ); ?>
<section id="tz-main">
    <div class="tz-main-body">
        <div class="container-fluid">
            <div class="tz-inner">
                <div class="tz-content-wrap row-fluid">
                    <div id="tz-content" class="span9 offset3">
                        <div id="tz-component" class="row-fluid">
                            <div class="tz-inner-content span ">
                                <div class="TzPortfolioItemPage item-page">
                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post() ; ?>
                                    <?php
                                          $post_type  = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_type', true ) ;
                                          $image      = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_fullsize_image', true ) ;
                                          $slidershow = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_slideshows', true ) ;
                                          $video_type = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_video_type', true ) ;
                                          $youtube_id = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_video', true ) ;

                                    ?>
                                        <div <?php post_class('TzItemPageInner') ?>>
                                            <div class="TzArticleMedia">
                                                <?php if ( $post_type == 'images' ): ?>
                                                        <div class="tz_portfolio_image">
                                                            <img src="<?php echo $image ; ?>" alt="<?php the_title() ; ?>" title="<?php the_title() ; ?>">
                                                        </div><!--end class tz_portfolio_image-->
                                                <?php elseif ( $post_type == 'slideshows' ): ?>
                                                        <div class="tz_blog_image_gallery">
                                                            <?php if ( isset( $slidershow ) && !empty ( $slidershow ) ) : ?>
                                                                <div class="flexslider" id="slider">
                                                                    <ul class="slides">
                                                                        <?php foreach ( $slidershow as $slider ): ?>
                                                                            <li>
                                                                                <img src="<?php echo $slider[THEME_PREFIX . '_portfolio_slideshow_item'] ; ?>" title="<?php the_title(); ?>">
                                                                            </li>
                                                                        <?php endforeach; ?>
                                                                    </ul><!--end class slides-->
                                                                </div><!--end class flexslider-->
                                                            <?php endif; ?>
                                                        </div><!--end class tz_blog_image_gallery-->
                                                <?php elseif( $post_type == 'video' ) : ?>
                                                        <div class="tz_portfolio_video">
                                                            <?php if( $video_type == 'youtube' ) :  ?>
                                                                <iframe  class="tz_portfolio_video_attr"
                                                                         src="http://www.youtube.com/embed/<?php echo $youtube_id; ?>"
                                                                         frameborder="0" allowfullscreen>
                                                                </iframe>
                                                            <?php elseif ( $video_type == 'vimeo' ) : ?>
                                                                <iframe src="http://player.vimeo.com/video/<?php echo $youtube_id ; ?>"
                                                                        class="tz_portfolio_video_attr"
                                                                        frameborder="0" allowFullScreen>
                                                                </iframe>
                                                            <?php endif; ?>
                                                        </div>
                                                <?php else: ?>
                                                         <div class="tz_portfolio_image">
                                                             <?php the_post_thumbnail('full'); ?>
                                                         </div><!--end class tz_portfolio_image-->
                                                <?php endif; ?>
                                            </div><!--end class TzArticleMedia-->
                                            <h1 class="TzArticleTitle"><?php the_title() ; ?></h1>
                                            <div class="TzArticleDescription">
                                               <?php
                                                    the_content() ;
                                                    wp_link_pages();
                                                ?>
                                            </div><!--end class TzArticleDescription-->
                                            <div class="TzArticleInfo">
                                                <span class="TzCreate"><?php the_date() ; ?></span>
                                                <span class="TzCreatedby">
                                                    <i class="fa fa-user"></i>
                                                    <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ; ?>"><?php the_author() ; ?></a>
                                                </span>
                                                <div class="clr"></div>
                                            </div><!--end class TzArticleInfo-->
                                            <div class="tz_portfolio_like_button">
                                                <h3 class="TzRelatedTitle">Related Articles</h3><!--end class TzRelatedTitle-->
                                                <div class="TzLikeButtonInner">
                                                    <span class="TzLikeQuestion"><strong>Share it!</strong></span>
                                                    <!-- Facebook Button -->
                                                    <div class="FacebookButton">
                                                        <div id="fb-root"></div>
                                                        <script type="text/javascript">
                                                        (function(d, s, id) {
                                                        var js, fjs = d.getElementsByTagName(s)[0];
                                                        if (d.getElementById(id)) {return;}
                                                        js = d.createElement(s); js.id = id;
                                                        js.src = "//connect.facebook.net/en_US/all.js#appId=177111755694317&xfbml=1";
                                                        fjs.parentNode.insertBefore(js, fjs);
                                                        }(document, 'script', 'facebook-jssdk'));
                                                        </script>
                                                        <div class="fb-like" data-send="false" data-width="200" data-show-faces="true"
                                                        data-layout="button_count" data-href="<?php the_permalink() ; ?>"></div>
                                                        </div>
                                                        <!-- Twitter Button -->
                                                        <div class="TwitterButton">
                                                        <a href="<?php the_permalink() ; ?>" class="twitter-share-button" data-count="horizontal"  data-via="" data-size="small">
                                                        </a>
                                                    </div>
                                                    <!-- Google +1 Button -->
                                                    <div class="GooglePlusOneButton">
                                                        <!-- Place this tag where you want the +1 button to render. -->
                                                        <div class="g-plusone" data-size="medium" data-href="<?php the_permalink() ; ?>"></div>
                                                        <!-- Place this tag after the last +1 button tag. -->
                                                        <script type="text/javascript">
                                                        (function() {
                                                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                        po.src = 'https://apis.google.com/js/plusone.js';
                                                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                        })();
                                                        </script>
                                                    </div>
                                                    <!-- Pinterest Button -->
                                                    <div class="PinterestButton">
                                                        <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink() ; ?>&media=<?php echo wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>&description=<?php the_title(); ?>" data-pin-do="buttonPin" data-pin-config="beside">
                                                        <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" alt="Aenean mattis venenatis"/>
                                                        </a>
                                                        <script type="text/javascript">
                                                        (function(d){
                                                        var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
                                                        p.type = 'text/javascript';
                                                        p.async = true;
                                                        p.src = '//assets.pinterest.com/js/pinit.js';
                                                        f.parentNode.insertBefore(p, f);
                                                        }(document));
                                                        </script>
                                                    </div>


                                                    <div class="clearfix"></div>
                                                </div><!--end class TzLikeButtonInner-->
                                                <div class="clr"></div>
                                            </div><!--end class tz_portfolio_like_button-->
                                            <div class="TzRelated">
                                                <ul>
                                                    <?php
                                                    $cate   = get_the_terms( $post ->ID, 'portfolio-category' );
                                                        $count = count ( $cate );
                                                        if ( $cate ) :
                                                            $term_id = array() ;
                                                            foreach ( $cate as $cat ):
                                                                $term_id[] = $cat->term_id ;
                                                            endforeach;

                                                            $args = array(
                                                                'post_type'      => 'portfolio',
                                                                'posts_per_page' => 3,
                                                                'post__not_in'    => array( $post->ID ),
                                                                'tax_query'         =>   array(
                                                                    array(
                                                                        'taxonomy'  => 'portfolio-category',
                                                                        'field'     =>  'id',
                                                                        'terms'     =>  $term_id
                                                                    )
                                                                )
                                                            );

                                                            $relate = get_posts( $args );

                                                            foreach ( $relate as $post ):
                                                                setup_postdata( $post );
                                                                $tags = get_the_terms( get_the_ID(), 'portfolio-tags' );
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
                                                    ?>
                                                            <li class="TzItem">
                                                                <span class="related_overlay"></span>
                                                                <div class="TzImage">
                                                                    <a  href="<?php the_permalink() ; ?>">
                                                                        <?php the_post_thumbnail() ; ?>
                                                                    </a>
                                                                </div>
                                                                <h3>
                                                                    <a href="<?php the_permalink(); ?>" class="TzTitle"><?php the_title() ; ?></a>
                                                                    <span class="p_tag">
                                                                        <?php echo $class_tags ; ?>
                                                                    </span>
                                                                </h3>
                                                            </li>
                                                        <?php    endforeach; wp_reset_postdata() ; ?>
                                                    <?php endif; ?>
                                                </ul>
                                                <div class="clr"></div>
                                            </div><!--end class TzRelated-->
                                        </div><!--end class TzItemPageInner-->
                                    <?php endwhile; endif;  ?>
                                </div><!--end class TzPortfolioItemPage-->
                            </div><!--end class tz-inner-content-->
                        </div><!--end id tz-component-->
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