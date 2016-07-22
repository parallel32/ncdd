<?php
  $current_path = __FILE__; //absolute path
  $path_arr = explode('wp-content', $current_path);
  require_once($path_arr[0] . '/wp-load.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo __('Insert List', TEXT_DOMAIN); ?></title>

    <link rel="stylesheet" href="<?php echo THEME_PATH; ?>/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo THEME_PATH; ?>/extension/shortcode/plazart_shortcode.css" type="text/css" media="all"/>

    <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
</head>
<body>
<div id="shortcode-wrap" class="bootstrap">
    <div id="shortcode-column">
        <div class="shortcode-content">
            <div class="heading-title">
              <?php echo __('Plazart Shortcode List type', TEXT_DOMAIN); ?>
            </div><!-- end:heading-title -->
            <div class="shorcode-content-inner">
                <select id="shortcode_list_type" name="type" class="item-list-attrs">
                    <option value="">Default</option>
                    <option value="list-check">Check list</option>
                    <option value="list-arrow">Arrow list</option>
                    <option value="list-star">Star list</option>
                    <option value="list-clip">Clip list</option>
                    <option value="list-comments">Comments list</option>
                    <option value="list-hook">Hook list</option>
                    <option value="list-wheel">Wheel list</option>
                    <option value="list-user">User list</option>
                </select>
                <input id="shortcode_list_class" type="text" value="" name="class" placeholder="Additional classes" class="item-list-attrs"/>
                <div id="list-items">
                    <div class="list-item">
                        <textarea placeholder="Add content here..." rows="3" name="text" class="shortcode-textarea item-list-attrs"></textarea>
                        <a href="#" class="none-remove-item">
                            <img src="<?php echo get_template_directory_uri() ?>/extension/shortcode/images/minus-circle.png" alt=""/>
                        </a>
                    </div><!-- end:accordion-item -->
                </div>
                <input id="add-more-list-item" class="shorcode-btn" value="Add more item" type="button">
                <div class="clear"></div>
            </div><!-- end:shortcode-content-inner -->
        </div><!-- end:shortcode-content -->
        <div class="shortcode-content">
            <div class="heading-title">
              <?php echo __('Shortcode Preview', TEXT_DOMAIN); ?>
            </div><!-- end:heading-title -->
            <div class="shortcode-preview">
                <code>
                    <span id="shortcode-preview-f">[list_items]</span>
                    <span id="shortcode-preview-m"><br/>[list_item] Add content here [/list_item]<br /></span>
                    <span id="shortcode-preview-l">[/list_items]</span>
                </code>
            </div><!-- end:shorcode-preview -->
        </div><!-- end:shortcode-content -->
        <div class="shorcode-insert">
            <input id="btn-insert" class="shorcode-btn" value="<?php _e('Insert Shortcode', TEXT_DOMAIN); ?>" type="button">
        </div><!-- end:shorcode-insert -->
    </div><!-- end:shortcode-generator -->
</div><!-- end:shortcode-wrap -->
<script type="text/javascript">
  /*global jQuery: false, tinyMCEPopup: false */
  jQuery(function () {
    "use strict";
    jQuery('#add-more-list-item').bind('click', function () {
      var item_clone = jQuery('.shorcode-content-inner .list-item').first().clone();
      item_clone.find('.none-remove-item').addClass('remove-item').removeClass('none-remove-item');
      jQuery('#list-items').append(item_clone);
        jQuery('.item-list-attrs').keyup(function () {
            shortcode_item_list_rebuild_preview();
        });
        jQuery('.remove-item').on('click', function () {
            jQuery(this).parent().remove();
            shortcode_item_list_rebuild_preview();
            return false;
        });
      return false;


    });


    jQuery('.item-list-attrs').keyup(function () {
      shortcode_item_list_rebuild_preview();
    });
    jQuery('#btn-insert').click(function () {
      tinyMCEPopup.execCommand(
          'mceReplaceContent',
          false,
          jQuery('#shortcode-preview-f').text() + jQuery('#shortcode-preview-m').html() + jQuery('#shortcode-preview-l').text());
      // Return
      tinyMCEPopup.close();
      return false;

    });
  });
  function shortcode_item_list_rebuild_preview() {
    "use strict";
    var options = [];
    var values = [];
    jQuery('.item-list-attrs').each(function () {
      var val = jQuery(this).val();
      var name = jQuery(this).attr('name');
      if (val.length) {
        if (String(name) === 'text') {
          values.push('[list_item]' + val + '[/list_item]');
        } else {
          options.push(name + '="' + val + '"');
        }
      }
    });
    var preview_code = '[list_items' + (options.length ? ' ' + options.join(' ') : '') + ']';
    var text_default = values.length ? values.join('<br />') : '[list_item] Add content here [/list_item]';
    jQuery('#shortcode-preview-f').text(preview_code);
    jQuery('#shortcode-preview-m').html( '<br />' + text_default + '<br />');
  }
</script>
</body>
</html>