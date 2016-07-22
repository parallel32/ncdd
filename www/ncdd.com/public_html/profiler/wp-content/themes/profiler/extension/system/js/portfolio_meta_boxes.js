/*global jQuery: false, themeprefix: false */

jQuery(function(){
  "use strict";
  jQuery('#portfolio_meta_box .btn-group .btn').click(function () {
    jQuery(this).parent().find('> input').attr('checked', false);
    jQuery('#' + jQuery(this).attr('value')).attr('checked', true);
  });


  jQuery('.portfolio-slideshow-item').parent().parent().addClass('width100');
  jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().hide();
  jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().hide();
  jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().hide();
  jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().hide();
  jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().hide();
  jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().hide();
  jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().hide();
  jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().hide();

  jQuery('#' + themeprefix + '_portfolio_type').live('change', function(){
    switch(jQuery(this).val()){
      case 'images':
        jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideDown();
        jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
      case 'slideshows':
        jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideDown();
        jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
      case 'video':
          jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideDown();
        jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideDown();
        jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
      case 'audio':
        jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideDown();
          jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
    case 'quote':
        jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideDown();
        jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
    case 'link':
        jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideDown();
        jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideDown();
        break;
      case 'none':
        jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
        jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();
        break;
    }
  });

  jQuery('#' + themeprefix + '_portfolio_type').each(function(){
    if(jQuery(this).find('option').is(':checked')){

      switch(jQuery(this).val()){
        case 'images':
          jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideDown();
          jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();

          break;
        case 'slideshows':
          jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideDown();
          jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();

          break;
        case 'video':
          jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideDown();
          jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
          jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideDown();
            jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
            jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();
          break;
          case 'audio':
              jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideDown();
              jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();
              break;
          case 'quote':
              jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideDown();
              jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();
              break;
          case 'link':
              jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideDown();
              jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideDown();
              break;
          case 'none':
              jQuery('#' + themeprefix + '_portfolio_fullsize_image').parent().parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_slideshows_settings_array').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_video').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_video_type').parent().parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_soundCloud_id').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_Quote_Autor').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_Link_Title').parent().parent().parent().slideUp();
              jQuery('#' + themeprefix + '_portfolio_Link_Url').parent().parent().parent().slideUp();
              break;
      }
    }
  });



});
