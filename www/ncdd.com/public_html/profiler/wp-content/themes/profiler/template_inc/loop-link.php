<?php
    /*
     * display post link
     */
?>
<div class="span12">
    <div class="TzItem column-1">
        <div class="TzArticleBlogInfo TzArticleBlogQuoteInfo">
            <span class="TzBlogCreate">
                <span class="date"><?php echo get_the_date(); ?></span>
            </span>
            <div class="clr"></div>
        </div>
        <div class="TzLink">
            <h2 class="title">
                <a href="<?php echo get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_Link_Url', true ) ; ?>" rel="nofollow" target="_blank"><?php echo get_post_meta( $post -> ID, THEME_PREFIX . '_portfolio_Link_Title', true ) ; ?></a>
            </h2>
            <div class="introtext">
                <?php the_content() ; ?>
            </div>
        </div>
        <div class="clr"></div>
    </div>
</div><!--end class span12-->
<span class="row-separator"></span>
<div class="clr"></div>