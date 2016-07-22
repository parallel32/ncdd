<?php

get_header();


?>

<div class="error">

    <div class="bug-content">
        <div id="errorboxheader"><?php echo ot_get_option(THEME_PREFIX . '_404_page_content'); ?></div>
        <div id="errorboxbody">
            <ul class="back-to-homepage">
                <li><a href="<?php echo home_url(); ?>" title="<?php echo __('Go to the Home Page', TEXT_DOMAIN); ?>"><?php echo __('Go to the Home Page', TEXT_DOMAIN); ?></a></li>
            </ul>
            <div id="techinfo">
                <p>
                </p>
            </div>
        </div>
    </div>

</div>
</div>

</body>
</html>