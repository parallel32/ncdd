<?php
/*
 * display post quote
 */
?>
<div class="span12">
    <div class="TzItem column-1">
        <div class="TzArticleBlogInfo TzArticleBlogQuoteInfo">
            <span class="TzBlogCreate">
                <span class="date"><?php echo get_the_date() ; ?></span>
            </span>
            <div class="clr"></div>
        </div>
        <div class="TzQuote">
            <h2 class="text">
                <small class="quote-open"></small>
                    <?php echo get_the_content() ; ?>
                <small class="quote-close"></small>
                <span class="TzBlogCreatedby">
                    <a href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ?>" ><?php the_author(); ?></a>
                </span>
                <span class="author"><?php echo get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_Quote_Autor', true ) ; ?></span>
            </h2>
        </div><!--end class TzQuote-->
        <div class="clr"></div>
    </div><!--end class TzItem-->
</div><!--end class span12-->
<span class="row-separator"></span>
<div class="clr"></div>
