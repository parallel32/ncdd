<?php get_header(); ?>
<?php
get_template_part('template_inc/inc','gallery');
$tzpost_sidebar         = get_post_meta( get_the_ID() , THEME_PREFIX . '_portfolio_sidebar', true);
$TZBlogMedia            =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_media','show');
$TZBlogDate             =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_date','show');
$TZBlogAuthor           =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_author','show');
$TZBlogTag              =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_tag','show');
$TZBlogComment          =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_comment','show');
$TZBlogTitle            =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_title','show');
$TZBlogContent          =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_content','show');
$TZBlogShare            =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_share','show');
$TZBlogInfoAuthor       =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_info_author','show');
$TZBlogRelate           =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_relate','show');
$TZBlogFormComment      =   ot_get_option(THEME_PREFIX . '_TZSingleBlog_form_comment','show');

$span_class = 'span6';
if ( $tzpost_sidebar == 'no' ){
    $span_class = 'span9';
}
?>
<section id="tz-main">
    <div class="tz-main-body">
        <div class="container-fluid">
            <div class="tz-inner">
                <div class="tz-content-wrap row-fluid">
                    <div id="tz-content" class="<?php echo $span_class; ?> offset3">
                        <div id="tz-component" class="row-fluid">
                            <div class="tz-inner-content span ">
                                <div class="TzItemPage item-page">

                                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post() ; ?>
                                        <?php
                                        $post_type  = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_type', true ) ;
                                        $image      = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_fullsize_image', true ) ;
                                        $slidershow = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_slideshows', true ) ;
                                        $video_type = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_video_type', true ) ;
                                        $youtube_id = get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_video', true ) ;
                                        $tags       = get_the_tags();
                                        $sound_id   = get_post_meta ( $post->ID, THEME_PREFIX . '_portfolio_soundCloud_id', true ) ;

                                        ?>
                                        <div class="TzItemPageInner">
                                            <?php
                                            if($TZBlogMedia == 'show'){
                                                ?>
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
                                                                         src="http://www.youtube.com/embed/<?php echo $youtube_id; ?>?hd=1&amp;wmode=opaque&amp;autoplay=1"
                                                                         frameborder="0" allowfullscreen>
                                                                </iframe>
                                                            <?php elseif ( $video_type == 'vimeo' ) : ?>
                                                                <iframe src="http://player.vimeo.com/video/<?php echo $youtube_id ; ?>"
                                                                        class="tz_portfolio_video_attr"
                                                                        frameborder="0" allowFullScreen>
                                                                </iframe>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php elseif( $post_type == 'audio' ) : ?>
                                                        <div class="tz_audio">
                                                            <iframe frameborder="0" allowfullscreen="" src="http://w.soundcloud.com/player/?url=http://api.soundcloud.com/tracks/<?php echo $sound_id; ?>&amp;show_artwork=true&amp;auto_play=false&amp;sharing=true&amp;buying=true&amp;download=true&amp;show_user=true&amp;show_playcount=true&amp;show_comments=true">
                                                            </iframe>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="tz_portfolio_image">
                                                            <?php the_post_thumbnail('full'); ?>
                                                        </div><!--end class tz_portfolio_image-->
                                                    <?php endif; ?>
                                                </div><!--end class TzArticleMedia-->
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if($TZBlogDate == 'show' || $TZBlogAuthor =='show' || $TZBlogTag == 'show' || $TZBlogComment == 'show' ){
                                                ?>
                                                <div class="TzArticleInfo">
                                                    <?php
                                                    if($TZBlogDate == 'show'){
                                                        ?>
                                                        <span class="TzCreate"><?php the_date(); ?></span>
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if($TZBlogAuthor =='show'){
                                                        ?>
                                                        <span class="TzCreatedby">
                                                        <i class="fa fa-user"></i>
                                                        <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ?>"><?php the_author() ; ?></a>
                                                    </span><!--end class TzCreatedby-->
                                                        <?php
                                                    }
                                                    ?>

                                                    <?php if ( $tags != false && $TZBlogTag == 'show' ) : ?>
                                                        <span class="TzArticleTag">
                                                    <i class="fa fa-tags"></i>
                                                            <?php the_tags('') ; ?>
                                                    </span><!--end class TzArticleTag-->
                                                    <?php endif; ?>

                                                    <?php
                                                    if($TZBlogComment == 'show'){
                                                        ?>
                                                        <span class="TZCommentCount">
                                                        <i class="fa fa-comments"></i>
                                                            <?php comments_number( 'no responses', 'one response', '% responses' ); ?>
                                                    </span><!--end class TZCommentCount-->
                                                        <?php
                                                    }
                                                    ?>
                                                    <div class="clr"></div>
                                                </div><!--end class TzArticleInfo-->
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if($TZBlogTitle == 'show'){
                                                ?>
                                                <h1 class="TzArticleTitle"><?php the_title() ; ?></h1>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if($TZBlogContent == 'show'){
                                                ?>
                                                <div class="TzArticleDescription">
                                                    <?php
                                                    the_content() ;
                                                    wp_link_pages();
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if($TZBlogShare == 'show'){
                                                ?>
                                                <div class="tz_portfolio_like_button">
                                                    <div class="TzLikeButtonInner">
                                                        <span class="TzLikeQuestion">Share it!</span>
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
                                                </div><!--end class link button-->
                                                <?php
                                            }
                                            ?>

                                            <div class="clr"></div>

                                            <?php
                                            if($TZBlogInfoAuthor == 'show'){
                                                ?>
                                                <div class="tz_portfolio_user tz_portfolio_clear">
                                                    <div class="AuthorBlock">
                                                        <div class="AuthorDetails">
                                                            <div class="AuthorAvatar">
                                                                <?php echo get_avatar( get_the_author_meta('ID'), 160 ) ; ?>
                                                            </div><!--end class AuthorAvatar-->
                                                            <h3 class="AuthorName" >
                                                                <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ; ?>"><?php the_author(); ?></a></h3>
                                                        </div>
                                                        <div class="TzAuthorInfo">
                                                            <?php the_author_meta('description'); ?>
                                                        </div>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div><!--end class tz_portfolio_user-->
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if($TZBlogRelate == 'show'){
                                                ?>
                                                <div class="TzRelated">
                                                    <h3 class="TzRelatedTitle">Related Articles</h3>
                                                    <ul>
                                                        <?php
                                                        if ( is_single() ) {
                                                            $categories = get_the_category();
                                                            if ($categories) {
                                                                foreach ($categories as $category) {

                                                                    $cat = $category->cat_ID;
                                                                    $args=array(
                                                                        'cat'               => $cat,
                                                                        'post__not_in'      => array($post->ID),
                                                                        'posts_per_page'=>10,
                                                                        'orderby'           =>   'date',
                                                                        'order'             =>   'desc',
                                                                    );
                                                                    $my_query = null;
                                                                    $my_query = new WP_Query($args);
                                                                    if( $my_query->have_posts() ) {
                                                                        while ($my_query->have_posts()) : $my_query->the_post();
                                                                            ?>
                                                                            <li class="TzItem last">
                                                                                <a class="TzTitle" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                                                            </li>
                                                                            <?php
                                                                        endwhile;
                                                                    } //if ($my_query)
                                                                } //foreach ($categories
                                                            } //if ($categories)
                                                            wp_reset_query();  // Restore global post data stomped by the_post().
                                                        } //if (is_single())
                                                        ?>
                                                    </ul>
                                                </div><!--end class TzRelated-->
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if($TZBlogFormComment == 'show'){
                                                ?>
                                                <div class="tz_portfolio_comment">
                                                    <?php comments_template( '', true ); ?>
                                                </div><!--end class tz_portfolio_comment-->
                                                <?php
                                            }
                                            ?>
                                        </div><!--end class TzItemPageInner-->
                                    <?php endwhile; endif;  ?>
                                </div><!--end class TzPortfolioItemPage-->
                            </div><!--end class tz-inner-content-->
                        </div><!--end id tz-component-->
                    </div><!--end idtz-content-->
                    <?php
                    get_sidebar();
                    get_template_part('template_inc/inc','header');
                    if ( $tzpost_sidebar == 'yes' ):  get_sidebar('right'); endif;
                    ?>
                    <div class="clr"></div>
                </div><!--end class tz-content-wrap-->
            </div><!--end class tz-inner-->
        </div><!--end class container-fluid-->
    </div><!--end class tz-main-body-->
</section><!--end id tz-main-->
<?php get_footer(); ?>