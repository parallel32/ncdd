<?php
  $current_path = __FILE__; //absolute path
  $path_arr = explode('wp-content', $current_path);
  require_once($path_arr[0] . '/wp-load.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo __('Tabs Shortcode', TEXT_DOMAIN); ?></title>

    <link rel="stylesheet" href="<?php echo THEME_PATH; ?>/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo THEME_PATH; ?>/extension/shortcode/plazart_shortcode.css" type="text/css" media="all"/>

    <script type="text/javascript" src="<?php echo includes_url(); ?>/js/jquery/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
</head>
<body>
<div id="shortcode-wrap" class="bootstrap">

    <div id="shortcode-column">

        <div class="shortcode-content">

            <div class="heading-title">

              <?php echo __('Manage Items', TEXT_DOMAIN); ?>

            </div>
            <!-- end:heading-title -->

            <div class="shorcode-content-inner">
                <div class="tab-items" id="tab-items">
                    <div class="tab-item">
                        <input type="text" placeholder="Title" class="shortcode-text tab-item-title tab-item-input" value=""/>
                        <textarea placeholder="Add tab content here..." rows="3"
                                  class="shortcode-textarea tab-item-content tab-item-input"></textarea>
                        <a href="#" class="none-remove-item"><img
                                src="<?php echo THEME_PATH; ?>/extension/shortcode/images/minus-circle.png"
                                alt=""/></a>
                    </div>
                    <!-- end:tab-item -->
                </div>
                <input id="add-more-tab-item" class="shorcode-btn" value="<?php _e('Add More Tab', TEXT_DOMAIN); ?>"
                       type="button"/>

            </div>
            <!-- end:shortcode-content-inner -->

        </div>
        <!-- end:shortcode-content -->

        <div class="shortcode-content">

            <div class="heading-title">
              <?php echo __('Shortcode Preview', TEXT_DOMAIN); ?>
            </div>
            <!-- end:heading-title -->

            <div class="shortcode-preview">
                <div class="shortcode-preview-inner">
                    <code>
                        <span id="shortcode-preview-f">[tabs]</span>
                        <span id="shortcode-preview-m"> </span>
                        <span id="shortcode-preview-l">[/tabs]</span>
                    </code>
                </div>
                <!-- end:shorcode-preview-inner -->
            </div>
            <!-- end:shorcode-preview -->

        </div>
        <!-- end:shortcode-content -->

        <div class="shorcode-insert">
            <input id="btn-insert" class="shorcode-btn" value="<?php _e('Insert Shortcode', TEXT_DOMAIN); ?>"
                   type="button">
        </div>
        <!-- end:shorcode-insert -->


    </div>
    <!-- end:shortcode-generator -->

</div>
<!-- end:shortcode-wrap -->
<script type="text/javascript">
  /*global jQuery: false, tinyMCEPopup: false */
  jQuery(function () {
    "use strict";
    jQuery('#add-more-tab-item').bind('click', function () {
      var item_clone = jQuery('.shorcode-content-inner .tab-item').first().clone();
      item_clone.find('.none-remove-item').addClass('remove-item').removeClass('none-remove-item');
      item_clone.find('input').val('');
      jQuery('#tab-items').append(item_clone);
        jQuery('.tab-item-input').on('keyup', function () {
            shortcode_tabs_rebuild_preview();
        });
        jQuery('.remove-item').on('click', function () {
            jQuery(this).parent().remove();
            shortcode_tabs_rebuild_preview();
            return false;
        });
      return false;
    });

    jQuery('.remove-item').on('click', function () {
      jQuery(this).parent().remove();
      shortcode_tabs_rebuild_preview();
      return false;
    });

    jQuery('.tab-item-input').on('keyup', function () {
      shortcode_tabs_rebuild_preview();
    });
    jQuery('#btn-insert').click(function () {

      var shortcode = jQuery('#shortcode-preview-f').text() + jQuery('#shortcode-preview-m').html() + jQuery('#shortcode-preview-l').text();

      tinyMCEPopup.execCommand('mceReplaceContent', false, shortcode);
      tinyMCEPopup.close();

      return false;

    });
  });
  function shortcode_tabs_rebuild_preview() {
    "use strict";
    var $preview_code = '';
    jQuery('#tab-items .tab-item').each(function () {
      var $item_title = jQuery(this).find('.tab-item-title').val();
      var $item_content = String(jQuery(this).find('.tab-item-content').val()) !== '' ? jQuery(this).find('.tab-item-content').val() : ' Add Content Here ';
      if (String($item_title) !== '') {
        $preview_code += '<br />[tab_item title="' + $item_title + '"] ' + $item_content + ' [/tab_item]';
      }
    });
    $preview_code = (String($preview_code) !== '')? $preview_code + '<br />' : $preview_code;
    jQuery('#shortcode-preview-m').html($preview_code);
  }
</script>
</body>
</html>