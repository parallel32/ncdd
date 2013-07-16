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
            <script>
            ( function ( window, undefined ) {
  var Aloha = window.Aloha || ( window.Aloha = {} );

  Aloha.settings = {
    logLevels: { 'error': true, 'warn': true, 'info': true, 'debug': false, 'deprecated': true },
    errorhandling: false,
    ribbon: {enable: true},
    locale: 'en',
    //waitSeconds: 300, // This can be turned on to avoid requirejs timeouts if Aloha startup code needs to be debugged
    placeholder: {
      '#placeholder-test': '<img src="http://aloha-editor.org/logo/Aloha%20Editor%20HTML5%20technology%20class%2016.png" alt="Aloha Editor"/>&nbsp;Placeholder Image'
    },
    repositories: {
      linklist: {
        data: [
          { name: 'Aloha Editor Developers Wiki', url:'https://github.com/alohaeditor/Aloha-Editor/wiki', type:'website', weight: 0.50 },
          { name: 'Aloha Editor - The HTML5 Editor', url:'http://aloha-editor.com', type:'website', weight: 0.90 },
          { name: 'Aloha Editor Demo', url:'http://www.aloha-editor.com/demos.html', type:'website', weight: 0.75 },
          { name: 'Aloha Editor Wordpress Demo', url:'http://www.aloha-editor.com/demos/wordpress-demo/index.html', type:'website', weight: 0.75 },
          { name: 'Aloha Editor Logo', url:'http://www.aloha-editor.com/images/aloha-editor-logo.png', type:'image', weight: 0.10 }
        ]
      }
    },
    plugins: {
      format: {
        // all elements with no specific configuration get this configuration
        //config: [  'b', 'i', 'p', 'sub', 'sup', 'del', 'title', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'pre', 'removeFormat' ],
        editables: {
          // no formatting allowed for title
          '#top-text': []
        }
      },
      list: {
        // all elements with no specific configuration get an UL, just for fun :)
        config: [ 'ul', 'ol' ],
        editables: {
          // Even if this is configured it is not set because OL and UL are not allowed in H1.
          '#top-text': []
        }
      },
      listenforcer: {
        editables: [ '.aloha-enforce-lists' ]
      },
      /*metaview: {
        editables: {
          '#top-text': ['metaview','enabled']
        }
      },*/
      abbr: {
        // all elements with no specific configuration get an UL, just for fun :)
        config: [ 'abbr' ],
        editables: {
          // Even if this is configured it is not set because OL and UL are not allowed in H1.
          '#top-text': []
        }
      },
      hints: {
        fallback: 'fallback text',
        trigger: 'hover'
      },
      link: {
        // all elements with no specific configuration may insert links
        config: [ 'a' ],
        hotKey: {
          // use ctrl+l instead of ctrl+k as hotkey for inserting a link
          //insertLink: 'ctrl+l'
        },
        editables: {
          // No links in the title.
          '#top-text': []
        },
        // all links that match the targetregex will get set the target
      // e.g. ^(?!.*aloha-editor.com).* matches all href except aloha-editor.com
        targetregex: '^(?!.*aloha-editor.com).*',
        // this target is set when either targetregex matches or not set
        // e.g. _blank opens all links in new window
        target: '_blank',
        // the same for css class as for target
        cssclassregex: '^(?!.*aloha-editor.com).*',
        cssclass: 'aloha',
        // use all resources of type website for autosuggest
        objectTypeFilter: ['website'],
        // handle change of href
        onHrefChange: function ( obj, href, item ) {
          var jQuery = Aloha.require( 'jquery' );
          if ( item ) {
            jQuery( obj ).attr( 'data-name', item.name );
          } else {
            jQuery( obj ).removeAttr( 'data-name' );
          }
        }
      },
      table: {
        // all elements with no specific configuration are not allowed to insert tables
        config: [ 'table' ],
        editables: {
          // Don't allow tables in top-text
          '#top-text': [ '' ]
        },
        summaryinsidebar: true,
          // [{name:'green', text:'Green', tooltip:'Green is cool', iconClass:'GENTICS_table GENTICS_button_green', cssClass:'green'}]
        tableConfig: [
          { name: 'hor-minimalist-a' },
          { name: 'box-table-a' },
          { name: 'hor-zebra' },
        ],
        columnConfig: [
          { name: 'table-style-bigbold',  iconClass: 'aloha-button-col-bigbold' },
          { name: 'table-style-redwhite', iconClass: 'aloha-button-col-redwhite' }
        ],
        rowConfig: [
          { name: 'table-style-bigbold',  iconClass: 'aloha-button-row-bigbold' },
          { name: 'table-style-redwhite', iconClass: 'aloha-button-row-redwhite' }
        ],
        cellConfig: [
          { name: 'table-style-bigbold',  iconClass: 'aloha-button-row-bigbold' },
          { name: 'table-style-redwhite', iconClass: 'aloha-button-row-redwhite' }
        ],
        // allow resizing the table width (default: false)
        tableResize: true,
        // allow resizing the column width (default: false)
        colResize: true,
        // allow resizing the row height (default: false)
        rowResize: true
      },
      image: {
        config:{
          'fixedAspectRatio' : false,
          'maxWidth'         : 600,
          'minWidth'         : 20,
          'maxHeight'        : 600,
          'minHeight'        : 20,
          'globalselector'   : '.global',
          'ui': {
            'oneTab': true
          }
        },
        'fixedAspectRatio' : false,
        'maxWidth'         : 600,
        'minWidth'         : 20,
        'maxHeight'        : 600,
        'minHeight'        : 20,
        'globalselector'   : '.global',
        'ui': {
          'oneTab' : true,
          'align'  : false,
          'margin' : false
        }
      },
      cite: {
        referenceContainer: '#references'
      },
      formatlesspaste :{
        formatlessPasteOption : true,
        strippedElements : [
        "em",
        "strong",
        "small",
        "s",
        "cite",
        "q",
        "dfn",
        "abbr",
        "time",
        "code",
        "var",
        "samp",
        "kbd",
        "sub",
        "sup",
        "i",
        "b",
        "u",
        "mark",
        "ruby",
        "rt",
        "rp",
        "bdi",
        "bdo",
        "ins",
        "del"]
      },
      'numerated-headers': {
        config: {
          // default true
          // numeratedactive will also accept "true" and "1" as true values
          // false and "false" for false
          numeratedactive: false,
          // if the headingselector is empty, the button will not be shown at all
          headingselector: 'h1, h2, h3, h4, h5, h6', // default: all
          baseobjectSelector: 'body'                 // if not set: Aloha.activeEditable
        }
      },
      'wai-lang': {
        flags: true
      },
      'textcolor': {
        // configure a set of colors for all editables
        config: ['#FFEE00', 'rgb(255,0,0)', '#FFFF00', '#FFFFFF', 'greenborder'],
        editables: {
          // configure a different set of colors for editable #one
          '#top-text' : []
        }
      }
    }
  };
} )( window );
            </script>
             <script src="/assets/aloha/aloha/lib/require.js"></script>
             <script src="/assets/aloha/aloha/lib/aloha.js" data-aloha-plugins="common/ui,
                common/format,
                            common/table,
                            common/list,
                            common/link,
                            common/highlighteditables,
                            common/block,
                            common/undo,
                            common/image,
                            extra/imagebrowser,
                            extra/linkbrowser,
                            common/contenthandler,
                            common/paste,
                            common/commands,
                            common/abbr"></script>

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
/*          <!-- jcrop -->
            <script src="/assets/plugins/jcrop/js/jquery.Jcrop.min.js"></script>*/
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