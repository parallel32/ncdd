   <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
   <!-- BEGIN CORE PLUGINS -->
   <script src="/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
   <!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
   <script src="/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
   <script src="/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
   <!--[if lt IE 9]>
   <script src="/assets/plugins/excanvas.min.js"></script>
   <script src="/assets/plugins/respond.min.js"></script>  
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
      case 'timeline':
         echo <<< EOT
            <script type="text/javascript" src="/assets/plugins/clockface/js/clockface.js"></script>
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
      case 'editor':
         echo <<< EOT
             <script type="text/javascript" src="/assets/snapeditor/snapeditor.js"></script>

EOT;
         break;
      case 'editor-aloha':
         echo <<< EOT
            <script>
            var Aloha = window.Aloha || ( window.Aloha = {} );
            
            Aloha.settings = {
              locale: 'en',
              plugins: {
                format: {
                  config: [  'b', 'i', 'p', 'sub', 'sup', 'del', 'title', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre', 'removeFormat' ],
                    editables : {
                    // no formatting allowed for title
                    '#title'  : [ ]
                    }
                },
                link: {
                  editables : {
                    // No links in the title.
                    '#title'  : [  ]
                    }
                },
                list: {
                  editables : {
                    // No lists in the title.
                    '#title'  : [  ]
                    }
                },
                abbr: {
                  editables : {
                    // No abbr in the title.
                    '#title'  : [  ]
                    }
                },
                image: {
                  'fixedAspectRatio': true,
                  'maxWidth': 1024,
                  'minWidth': 10,
                  'maxHeight': 786,
                  'minHeight': 10,
                  'globalselector': '.global',
                  'ui': {
                    'oneTab': false
                  },
                  editables : {
                    // No images in the title.
                    '#title'  : [  ]
                    }
                }
              },
              sidebar: {
                disabled: true
              },
              contentHandler: {
                  allows: {
                  elements: [
                    'a', 'abbr', 'b', 'blockquote', 'br', 'caption', 'cite', 'code', 'col',
                    'colgroup', 'dd', 'del', 'dl', 'dt', 'em', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
                    'i', 'img', 'li', 'ol', 'p', 'pre', 'q', 'small', 'strike', 'strong',
                    'sub', 'sup', 'table', 'tbody', 'td', 'tfoot', 'th', 'thead', 'tr', 'u',
                    'ul', 'span', 'hr', 'object', 'div'
                  ],

                  attributes: {
                    'a': ['href', 'title', 'id', 'class', 'target', 'data-gentics-aloha-repository', 'data-gentics-aloha-object-id'],
                    'div': [ 'id', 'class'],
                    'abbr': ['title'],
                    'blockquote': ['cite'],
                    'br': ['class'],
                    'col': ['span', 'width'],
                    'colgroup': ['span', 'width'],
                    'img': ['align', 'alt', 'height', 'src', 'title', 'width', 'class'],
                    'ol': ['start', 'type'],
                    'q': ['cite'],
                    'p': ['class'],
                    'table': ['summary', 'width'],
                    'td': ['abbr', 'axis', 'colspan', 'rowspan', 'width'],
                    'th': ['abbr', 'axis', 'colspan', 'rowspan', 'scope', 'width'],
                    'ul': ['type'],
                    'span': ['class','style','lang','xml:lang']
                  },

                  protocols: {
                    'a': {'href': ['ftp', 'http', 'https', 'mailto', '__relative__']},
                    'blockquote': {'cite': ['http', 'https', '__relative__']},
                    'img': {'src' : ['http', 'https', '__relative__']},
                    'q': {'cite': ['http', 'https', '__relative__']}
                  }
                }
              }
            };
             
            </script>
             <script src="/assets/aloha/aloha/lib/require.js"></script>
             <script src="/assets/aloha/aloha/lib/aloha.js" data-aloha-plugins="common/ui,
                common/format,
                            common/table,
                            common/list,
                            common/highlighteditables,
                            common/block,
                            common/undo,
                            common/contenthandler,
                            common/paste,
                            common/commands"></script>

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
         case 'crop':
         echo <<< EOT
            <!-- jcrop -->
            <script src="/assets/plugins/jcrop/js/jquery.Jcrop.min.js"></script>


EOT;
         break;
      default:
         echo "<!-- empty ... -->";
         break;
   
      } 
      endforeach;
      ?>

   <script src="/assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
   <script src="/assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
  <script src="/assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
   <!-- END PAGE LEVEL PLUGINS -->
   <!-- BEGIN PAGE LEVEL SCRIPTS -->
   <script src="/assets/scripts/app.js" type="text/javascript"></script>
   <!-- END PAGE LEVEL SCRIPTS -->  
   <script>
      jQuery(document).ready(function() {    
        //$.fn.modalmanager.defaults.resize = true;
         App.init(); // initlayout and core plugins
      });
   </script>
   <!-- END JAVASCRIPTS -->