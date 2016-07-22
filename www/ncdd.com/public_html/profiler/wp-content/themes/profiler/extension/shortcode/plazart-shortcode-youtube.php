<?php
  $current_path = __FILE__; //absolute path
  $path_arr = explode('wp-content', $current_path);

  require_once($path_arr[0] . '/wp-load.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo __('Youtube Shortcode', TEXT_DOMAIN); ?></title>
    <?php ?>

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

        <?php echo __('Youtube Video ID', TEXT_DOMAIN); ?>

      </div>
      <!-- end:heading-title -->

      <div class="shorcode-content-inner">
        <input id="youtube_id" type="text" value="" name="text" placeholder="ID" class="youtube-attrs"/>
        <span class="shortcode-eg">Eg: XSGBVzeBUbk</span>
        <input id="youtube_width" name="width" type="text" value="" placeholder="Width" class="youtube-attrs"/>
        <span class="shortcode-eg"></span>
        <input id="youtube_height" type="text" name="height" value="" placeholder="Height" class="youtube-attrs"/>
        <span class="shortcode-eg"></span>
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
            <span id="shortcode-preview-f">[youtube]</span>
            <span id="shortcode-preview-m"> </span>
            <span id="shortcode-preview-l">[/youtube]</span>
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
  jQuery(function () {
    "use strict";
    jQuery('.youtube-attrs').bind('keyup change paste', function () {
      var ele_name = jQuery(this).attr('name');
      var id = jQuery('#youtube_id').val();
      var ele_val = jQuery(this).val();
      var text_default = '';
      var preview_code = jQuery('#shortcode-preview-f').text();
      if (String(ele_name) === 'text') {
        text_default = ele_val;
      } else {
        var options = [];
        jQuery('.youtube-attrs').each(function () {
          var val = jQuery(this).val();
          var name = jQuery(this).attr('name');
          if (String(name) !== 'text') {
            if (val.length) {
              options.push(name + '="' + val + '"');
            }
          }
        });
        preview_code = '[youtube' + (options.length ? ' ' + options.join(' ') : '') + ']';
      }
      jQuery('#shortcode-preview-f').text(preview_code);
      jQuery('#shortcode-preview-m').text(id);
    });
    jQuery('#btn-insert').click(function () {

      var shortcode = jQuery('#shortcode-preview-f').text() + jQuery('#shortcode-preview-m').text() + jQuery('#shortcode-preview-l').text();

      tinyMCEPopup.execCommand('mceReplaceContent', false, shortcode);
      tinyMCEPopup.close();

      return false;

    });
  });
</script>
</body>
</html>