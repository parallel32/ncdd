<!-- BEGIN PAGE LEVEL STYLES --> 
<link rel="stylesheet" type="text/css" href="/assets/plugins/gritter/css/jquery.gritter.css"/>
<link rel="stylesheet" type="text/css" href="/assets/plugins/select2/select2_metro.css" />
<link rel="stylesheet" type="text/css" href="/assets/plugins/chosen-bootstrap/chosen/chosen.css" />
<link rel="stylesheet" type="text/css" href="/assets/plugins/jquery-tags-input/jquery.tagsinput.css" />

<? 
   $plugins = explode(',',$this->vars['page-plugin']);
      foreach($plugins as $plugin):

      switch ($plugin) {
         case 'dashboard':
         echo "";
         break;
      case 'datatables':
         echo <<< EOT
            <link rel="stylesheet" href="/assets/plugins/data-tables/DT_bootstrap.css" />

EOT;
         break;
      case 'forms':
         echo <<< EOT
            <link rel="stylesheet" type="text/css" href="/assets/plugins/chosen-bootstrap/chosen/chosen.css" />

EOT;
         break;
      case 'checkboxes':
         echo <<< EOT
            <link rel="stylesheet" type="text/css" href="/assets/plugins/bootstrap-toggle-buttons/static/stylesheets/bootstrap-toggle-buttons.css" />

EOT;
         break;
      case 'fileupload':
         echo <<< EOT
            <link rel="stylesheet" type="text/css" href="/assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" />

EOT;
         break;
      default:
         echo "";
         break;
      } 
      endforeach;
      ?>
<!-- END PAGE LEVEL STYLES -->