<!-- BEGIN PAGE LEVEL STYLES --> 
<link rel="stylesheet" type="text/css" href="<?=SAW_SSL_CDN?>/assets/plugins/gritter/css/jquery.gritter.css"/>
<link rel="stylesheet" type="text/css" href="<?=SAW_SSL_CDN?>/assets/plugins/select2/select2_metro.css" />
<link rel="stylesheet" type="text/css" href="<?=SAW_SSL_CDN?>/assets/plugins/chosen-bootstrap/chosen/chosen.css" />
<link rel="stylesheet" type="text/css" href="<?=SAW_SSL_CDN?>/assets/plugins/jquery-tags-input/jquery.tagsinput.css" />
<link rel="stylesheet" type="text/css" href="<?=SAW_SSL_CDN?>/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css"/>

<? 
$SAW_SSL_CDN = SAW_SSL_CDN;
if(array_key_exists('page-plugin', $this->vars)):
   $plugins = explode(',',$this->vars['page-plugin']);
      foreach($plugins as $plugin):

      switch ($plugin) {
         case 'dashboard':
         echo "";
         break;
      case 'datatables':
         echo <<< EOT
            <link rel="stylesheet" href="{$SAW_SSL_CDN}/assets/plugins/data-tables/DT_bootstrap.css" />

EOT;
         break;
      case 'timeline':
         echo <<< EOT
            <link rel="stylesheet" href="{$SAW_SSL_CDN}/assets/css/pages/timeline.css" />
            <link rel="stylesheet" type="text/css" href="{$SAW_SSL_CDN}/assets/plugins/clockface/css/clockface.css" />

EOT;
         break;
      case 'forms':
         echo <<< EOT
            <link rel="stylesheet" type="text/css" href="{$SAW_SSL_CDN}/assets/plugins/chosen-bootstrap/chosen/chosen.css" />

EOT;
         break;
      case 'checkboxes':
         echo <<< EOT
            <link rel="stylesheet" type="text/css" href="{$SAW_SSL_CDN}/assets/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />

EOT;
         break;
      case 'editor-aloha':
         echo <<< EOT
            <link rel="stylesheet" href="{$SAW_SSL_CDN}/assets/aloha/aloha/css/aloha.css" type="text/css">
EOT;
      case 'editor':
         echo <<< EOT
        
EOT;
         break;
      case 'fileupload':
         echo <<< EOT
            <link rel="stylesheet" type="text/css" href="{$SAW_SSL_CDN}/assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" />
EOT;
         break;
      case 'crop':
         echo <<< EOT
            <link rel="stylesheet" type="text/css" href="{$SAW_SSL_CDN}/assets/plugins/jcrop/css/jquery.Jcrop.css" />
EOT;

         break;
      case 'invoice':
         echo <<< EOT
            <link href="{$SAW_SSL_CDN}/assets/css/pages/invoice.css" rel="stylesheet" type="text/css"/>
EOT;

         break;
      case 'datepicker':
         echo <<< EOT
            <link rel="stylesheet" type="text/css" href="{$SAW_SSL_CDN}/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css" />

EOT;

         break;
      case 'multi-select':
         echo <<< EOT
            <link rel="stylesheet" type="text/css" href="{$SAW_SSL_CDN}/assets/plugins/jquery-multi-select/css/multi-select-metro.css" />

EOT;
         break;
      default:
         echo "";
         break;
      } 
      endforeach;
endif;
      ?>
<!-- END PAGE LEVEL STYLES -->