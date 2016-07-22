<?php
  $current_path = __FILE__; //absolute path
  $path_arr = explode('wp-content', $current_path);

  require_once($path_arr[0] . '/wp-load.php');

  #-----------------------------------------------------------------
  # Shortcode Column Field
  #-----------------------------------------------------------------

  $shortcodes = array(
    //Half
    array('id' => 'optgroup', 'title' => __('One column', TEXT_DOMAIN)),
    array('id' => 'one_half', 'title' => __('1/1', TEXT_DOMAIN)),

    //Thirds
    array('id' => 'optgroup', 'title' => __('Two columns', TEXT_DOMAIN)),
    array('id' => 'column2_1', 'title' => __('1/2 - 1/2', TEXT_DOMAIN)),
    array('id' => 'column2_2', 'title' => __('1/3 - 2/3', TEXT_DOMAIN)),
    array('id' => 'column2_3', 'title' => __('2/3 - 1/3', TEXT_DOMAIN)),
    array('id' => 'column2_4', 'title' => __('1/4 - 3/4', TEXT_DOMAIN)),
    array('id' => 'column2_5', 'title' => __('3/4 - 1/4', TEXT_DOMAIN)),

      //Thirds
      array('id' => 'optgroup', 'title' => __('Three columns', TEXT_DOMAIN)),
      array('id' => 'column3_1', 'title' => __('1/3 - 1/3 - 1/3', TEXT_DOMAIN)),
      array('id' => 'column3_2', 'title' => __('1/4 - 2/4 - 1/4', TEXT_DOMAIN)),
      array('id' => 'column3_3', 'title' => __('1/4 - 1/4 - 2/4', TEXT_DOMAIN)),
      array('id' => 'column3_4', 'title' => __('2/4 - 1/4 - 1/4', TEXT_DOMAIN)),

    //Fourth
    array('id' => 'optgroup', 'title' => __('Four columns', TEXT_DOMAIN)),
    array('id' => 'column4_4', 'title' => __('4/4 Column', TEXT_DOMAIN)),

  );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php echo __('Column Shortcode', TEXT_DOMAIN); ?></title>

  <link rel="stylesheet" href="<?php echo THEME_PATH; ?>/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo THEME_PATH; ?>/extension/shortcode/plazart_shortcode.css"/>

    <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/jquery.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
</head>
<body>
<div id="shortcode-wrap" class="bootstrap">

  <div id="shortcode-column">

    <div class="shortcode-content">

      <div class="heading-title">
        <?php echo __('Manage Items', TEXT_DOMAIN); ?>
      </div><!-- end:heading-title -->

      <div class="shorcode-content-inner">
        <select id="column-shortcodes">
          <option value=""><?php echo __('Choose a Shortcode', TEXT_DOMAIN); ?></option>
          <?php
          //Loop through shortcodes
          $options = ''; $loop = 0; $checkoptgroup = false; $total = count($shortcodes);
          foreach ($shortcodes as $shortcode) {
            if ($shortcode['id'] == 'optgroup') {
              if ($loop > 0 && $checkoptgroup) {
                $options .= '</optgroup>';
                $checkoptgroup = false;
              }
              $options .= '<optgroup label="' . $shortcode['title'] . '">';
              $checkoptgroup = true;
            } else {
              $options .= '<option value="' . $shortcode['id'] . '">' . $shortcode['title'] . '</option>';
            }
            $loop++;
            if ($loop == $total) {
              $options .= '</optgroup>';
              $checkoptgroup = false;
            }
          } //endforeach
          echo $options;
          ?>
        </select>

        <div class="clear"></div>
      </div><!-- end:shortcode-content-inner -->

    </div><!-- end:shortcode-content -->

    <div class="shortcode-content">

      <div class="heading-title">
        <?php echo __('Shortcode Preview', TEXT_DOMAIN); ?>
      </div><!-- end:heading-title -->

      <div class="shortcode-preview">
        <code>
          <span id="shortcode-preview-f">[row]</span>
          <span id="shortcode-preview-m"> </span>
          <span id="shortcode-preview-l">[/row]</span>
        </code>
      </div><!-- end:shorcode-preview -->

    </div><!-- end:shortcode-content -->

    <div class="shorcode-insert">
      <input class="shorcode-btn" id="btn-insert" value="<?php _e('Insert Shortcode', TEXT_DOMAIN); ?>" type="button">
    </div><!-- end:shorcode-insert -->
  </div><!-- end:shortcode-generator -->
</div><!-- end:shortcode-wrap -->
<script type="text/javascript">
  /*global jQuery: false, tinyMCEPopup: false */
  jQuery(function () {
    "use strict";
    var shortcode_f = '';
    var shortcode_l = '';

    jQuery('#column-shortcodes').bind('change', function () {
      var $preview_column_item = '';
      if (String(jQuery(this).val()) !== '') {
        var $value  = jQuery(this).val();
          switch ($value){
              case 'one_half':
                  $preview_column_item = '<br />[column span="12"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
              case 'column2_1':
                  $preview_column_item = '<br />[column span="6"] Text [/column]<br />[column span="6"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
              case 'column2_2':
                  $preview_column_item = '<br />[column span="4"] Text [/column]<br />[column span="8"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
              case 'column2_3':
                  $preview_column_item = '<br />[column span="8"] Text [/column]<br />[column span="4"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
              case 'column2_4':
                  $preview_column_item = '<br />[column span="3"] Text [/column]<br />[column span="9"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
              case 'column2_5':
                  $preview_column_item = '<br />[column span="9"] Text [/column]<br />[column span="3"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
              case 'column3_1':
                  $preview_column_item = '<br />[column span="4"] Text [/column]<br />[column span="4"] Text [/column]<br />[column span="4"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
              case 'column3_2':
                  $preview_column_item = '<br />[column span="3"] Text [/column]<br />[column span="6"] Text [/column]<br />[column span="3"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
              case 'column3_3':
                  $preview_column_item = '<br />[column span="3"] Text [/column]<br />[column span="3"] Text [/column]<br />[column span="6"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
              case 'column3_4':
                  $preview_column_item = '<br />[column span="6"] Text [/column]<br />[column span="3"] Text [/column]<br />[column span="3"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
              case 'column4_4':
                  $preview_column_item = '<br />[column span="3"] Text [/column]<br />[column span="3"] Text [/column]<br />[column span="3"] Text [/column]<br />[column span="3"] Text [/column]<br />';
                  jQuery('#shortcode-preview-m').html($preview_column_item);
                  break;
          }

      } else {

        shortcode_f = '';
        shortcode_l = '';
      }
    });



    jQuery('#btn-insert').click(function () {

      var shortcode = jQuery('#shortcode-preview-f').text() + jQuery('#shortcode-preview-m').html() + jQuery('#shortcode-preview-l').text();

      tinyMCEPopup.execCommand('mceReplaceContent', false, shortcode);
      tinyMCEPopup.close();

      return false;

    });
  });
</script>
</body>
</html>