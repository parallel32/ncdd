<?php
  $current_path = __FILE__; //absolute path
  $path_arr = explode('wp-content', $current_path);

  require_once($path_arr[0] . '/wp-load.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo __('Dropcap Shortcode', TEXT_DOMAIN); ?></title>

  <link rel="stylesheet" href="<?php echo THEME_PATH; ?>/css/bootstrap.css"/>
  <link rel="stylesheet" href="<?php echo THEME_PATH; ?>/extension/system/assets/css/jquery.miniColors.css"/>
  <link rel="stylesheet" href="<?php echo THEME_PATH; ?>/extension/shortcode/plazart_shortcode.css" type="text/css" media="all"/>

    <script type="text/javascript" src="<?php echo includes_url(); ?>/js/jquery/jquery.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo THEME_PATH; ?>/extension/system/assets/js/jquery.miniColors.js"></script>
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
        <select id="dropcap_type" name="type" class="dropcap-attrs">
          <option value="">Default</option>
          <option value="dark">Drak</option>
          <option value="custom">Custom</option>
        </select>

        <div id="colorpicker">
          <input id="dropcap_text_color" name="color" class="dropcap-attrs" type="minicolors" value="" placeholder="Text Color..."/>
          <input id="dropcap_background_color" class="dropcap-attrs" name="bg_color" type="minicolors" value="" placeholder="Background..."/>
        </div>
        <textarea id="dropcap_content" class="dropcap-attrs" name="text" rows="4" placeholder="Add Content Here..."></textarea>
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
            <span id="shortcode-preview-f">[dropcap]</span>
            <span id="shortcode-preview-m"> </span>
            <span id="shortcode-preview-l">[/dropcap]</span>
          </code>
        </div>
        <!-- end:shorcode-preview-inner -->
      </div>
      <!-- end:shorcode-preview -->

    </div>
    <!-- end:shortcode-content -->

    <div class="shorcode-insert">
      <input id="btn-insert" class="shorcode-btn" value="<?php _e('Insert Shortcode', TEXT_DOMAIN); ?>" type="button">
    </div>
    <!-- end:shorcode-insert -->


  </div>
  <!-- end:shortcode-generator -->

</div>
<!-- end:shortcode-wrap -->
<script type="text/javascript">
  /*global jQuery: false, tinyMCEPopup: false */

  jQuery('#colorpicker').hide();

  jQuery(function () {
    "use strict";
    jQuery('.dropcap-attrs').bind('keyup change paste', function () {
      var ele_name = jQuery(this).attr('name');
      var ele_val = jQuery(this).val();
      var text_default = jQuery('#dropcap_content').val();
      var preview_code = jQuery('#shortcode-preview-f').text();
      if (String(ele_name) === 'type') {
        if (String(ele_val) === 'custom') {
          jQuery('#colorpicker').fadeIn();
        } else {
          jQuery('#colorpicker').hide();
        }
      }
      if (String(ele_name) === 'text') {
        text_default = ele_val;
      } else {
        var options = [];
        jQuery('.dropcap-attrs').each(function () {
          var val = jQuery(this).val();
          var name = jQuery(this).attr('name');
          if (String(name) !== 'text') {
            if (val.length) {
              if (jQuery(this).is(':visible')) {
                options.push(name + '="' + val + '"');
              }
            }
          }
        });
        preview_code = '[dropcap' + (options.length ? ' ' + options.join(' ') : '') + ']';
      }
      jQuery('#shortcode-preview-f').text(preview_code);
      jQuery('#shortcode-preview-m').text(text_default);
    });

    jQuery('#btn-insert').click(function () {

      var shortcode = jQuery('#shortcode-preview-f').text() + jQuery('#shortcode-preview-m').text() + jQuery('#shortcode-preview-l').text();

      tinyMCEPopup.execCommand('mceReplaceContent', false, shortcode);
      tinyMCEPopup.close();

      return false;

    });

    jQuery('INPUT[type=minicolors]').on('change', function () {
      var input = jQuery(this),
          hex = input.val(),
          opacity = input.attr('data-opacity'),
          text;
      // Generate text to show in console
      text = hex ? hex : 'transparent';
      if (opacity) {
        text += ', ' + opacity;
      }
      text += ' / ' + jQuery.minicolors.rgbString(input);
    });
  });
</script>
</body>
</html>