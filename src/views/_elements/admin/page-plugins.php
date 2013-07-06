   <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
   <!-- BEGIN CORE PLUGINS -->
   <script src="/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
   <!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
   <script src="/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
   <script src="/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
   <!--[if lt IE 9]>
   <script src="assets/plugins/excanvas.min.js"></script>
   <script src="assets/plugins/respond.min.js"></script>  
   <![endif]-->   
   <script src="/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
   <script src="/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
   <script src="/assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
   <script src="/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
   <!-- END CORE PLUGINS -->
   <!-- BEGIN PAGE LEVEL PLUGINS -->
   <?
      $plugins = explode(',',$this->vars['page-plugin']);
      foreach($plugins as $plugin):

      switch ($plugin) {
      case 'dashboard':
         echo "<!-- empty ... -->";
         break;
      case 'datatables':
         echo <<< EOT
            <script type="text/javascript" src="/assets/plugins/select2/select2.min.js"></script>
            <script type="text/javascript" src="/assets/plugins/data-tables/jquery.dataTables.js"></script>
            <script type="text/javascript" src="/assets/plugins/data-tables/DT_bootstrap.js"></script>

EOT;
         break;
      case 'forms':
         echo <<< EOT

EOT;
         break;
      case 'chosen':
         echo <<< EOT
            <script type="text/javascript" src="/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>

EOT;
         break;
      case 'checkboxes':
         echo <<< EOT
             <script type="text/javascript" src="/assets/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>

EOT;
         break;
      case 'fileupload':
         echo <<< EOT
            <!-- BEGIN:File Upload Plugin JS files-->
            <script src="/assets/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
            <!-- The Templates plugin is included to render the upload/download listings -->
            <script src="/assets/plugins/jquery-file-upload/js/vendor/tmpl.min.js"></script>
            <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
            <script src="/assets/plugins/jquery-file-upload/js/vendor/load-image.min.js"></script>
            <!-- The Canvas to Blob plugin is included for image resizing functionality -->
            <script src="/assets/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"></script>
            <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
            <script src="/assets/plugins/jquery-file-upload/js/jquery.iframe-transport.js"></script>
            <!-- The basic File Upload plugin -->
            <script src="/assets/plugins/jquery-file-upload/js/jquery.fileupload.js"></script>
            <!-- The File Upload file processing plugin -->
            <script src="/assets/plugins/jquery-file-upload/js/jquery.fileupload-fp.js"></script>
            <!-- The File Upload user interface plugin -->
            <script src="/assets/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"></script>
            <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
            <!--[if gte IE 8]><script src="/assets/plugins/jquery-file-upload/js/cors/jquery.xdr-transport.js"></script><![endif]-->
            <!-- END:File Upload Plugin JS files-->

            <script type="text/javascript" src="/assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

EOT;
         break;
      default:
         echo "<!-- empty ... -->";
         break;
   
      } 
      endforeach;
      ?>

   <script type="text/javascript" src="/assets/plugins/jquery.pulsate.min.js"></script>
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN PAGE LEVEL SCRIPTS -->
   <script src="/assets/scripts/app.js" type="text/javascript"></script>
   <!-- END PAGE LEVEL SCRIPTS -->  
   <script>
      jQuery(document).ready(function() {    
         App.init(); // initlayout and core plugins
      });
   </script>
   <!-- END JAVASCRIPTS -->