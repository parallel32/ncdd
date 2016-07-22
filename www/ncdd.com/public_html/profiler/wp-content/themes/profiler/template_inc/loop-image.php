<?php
    /*===================================
    * Blog option
    ====================================*/
    $TZBlogDate           =   ot_get_option(THEME_PREFIX . '_TZBlogDate','show');
    $TZBlogAuthor         =   ot_get_option(THEME_PREFIX . '_TZBlogAuthor','show');
    $TZBlogcomment       =   ot_get_option(THEME_PREFIX . '_TZBlogcomment','show');
    $TZBlogTag            =   ot_get_option(THEME_PREFIX . '_TZBlogTag','show');
    $TZBlogimage          =   ot_get_option(THEME_PREFIX . '_TZBlogimage','show');
    $TZBlogexcerpt        =   ot_get_option(THEME_PREFIX . '_TZBlogexcerpt','show');
    $TZBlogTitle          =   ot_get_option(THEME_PREFIX . '_TZBlogTitle','show');
    $TZBlogreadmore       =   ot_get_option(THEME_PREFIX . '_TZBlogreadmore','show');
    $custom_type = get_post_type( get_the_ID() );
    $class_tag = '';
    if ( $custom_type == 'post' ):
        $tags = get_the_tags();
        if ( $tags != false ):
            $count = count($tags);
            $it = 0;
            foreach ( $tags as $tag ):
                $it ++ ;
                $class_tag .= '<a href="'.get_tag_link( $tag -> term_id ).'">'.$tag->name;
                if ( $it < $count ):
                    $class_tag .= ',';
                endif;
                $class_tag .= '</a>';
            endforeach;
        endif;
    elseif( $custom_type == 'portfolio' ):
        $tags = get_the_terms( $post -> ID, 'portfolio-tags' );
        if ( $tags != false ):
            $count = count($tags);
            $it = 0;
            foreach ( $tags as $tag ):
                $it ++ ;
                $tags_link = get_term_link( $tag, 'portfolio-tags' );
                if ( is_wp_error( $tags_link ) )
                    continue ;
                $class_tag .= '<a href="'.$tags_link.'">'.$tag->name;
                if ( $it < $count ):
                    $class_tag .= ',';
                endif;
                $class_tag .= '</a>';
            endforeach;
        endif;
    endif;
?>
<div class="TzLeading leading-0">
    <div class="TzBlogMedia">
        <?php if ( $TZBlogimage == 'show' ) : ?>
            <div class="tz_portfolio_image">
                <a href="<?php the_permalink() ; ?>">
                    <?php the_post_thumbnail() ; ?>
                </a>
            </div><!--end class tz_portfolio_image-->
        <?php endif; ?>
    </div><!--end class TzBlogMedia-->
    <div class="TzArticleBlogInfo">
        <?php if ( $TZBlogDate == 'show' ) : ?>
            <span class="TzBlogCreate">
                <span class="date"><?php echo get_the_date() ; ?></span>
            </span><!--end class TzBlogCreate-->
        <?php endif; ?>
        <?php if ( $TZBlogAuthor == 'show' ) : ?>
            <span class="TzBlogCreatedby">
                <i class="fa fa-user"></i>
                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" ><?php the_author() ; ?></a>
            </span><!--end class TzBlogCreatedby-->
        <?php endif; ?>
        <?php if ( $class_tag != '' && $TZBlogTag == 'show' ): ?>
            <span class="p_tag">
                <i class="fa fa-tags"></i>
                <?php echo $class_tag; ?>
            </span><!--end class p_tag-->
        <?php endif; ?>
        <?php if ( $custom_type == 'post' && $TZBlogcomment == 'show') : ?>
            <span class="TzPortfolioCommentCount">
                <i class="fa fa-comments"></i>
                <?php comments_number('no responses', 'one response', '% responses'); ?>
            </span><!--end class TzPortfolioCommentCount-->
        <?php endif; ?>
    </div><!--end class TzArticleBlogInfo-->
    <?php if ( $TZBlogTitle == 'show' ) : ?>
        <h2 class="TzBlogTitle">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h2><!--end class TzBlogTitle-->
    <?php endif; ?>
    <?php if ( $TZBlogexcerpt == 'show' ) : ?>
        <div class="TzDescription">
            <?php the_excerpt(); ?>
        </div><!--end class TzDescription-->
    <?php endif; ?>
    <?php if ( $TZBlogreadmore == 'show' ): ?><a class="btn-readmore btn btn-primary btn-embossed mlm btn-cyan pull-left" href="<?php the_permalink(); ?>">Read More</a><?php endif; ?>
    <div class="item-separator"></div>
    <div class="clr"></div>
</div><!--end class TzLeading-->