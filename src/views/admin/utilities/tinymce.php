<!-- BEGIN PAGE -->
      <div class="page-content">
         
         <!-- BEGIN PAGE CONTAINER-->
         <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
               <div class="span12">
                  <?=$this->element('page-title-and-bread-crumb');?>
               </div>
            </div>
            <!-- END PAGE HEADER-->
            
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
              <div class="span12">
                         
                <div id="page">
                      <textarea id="_content" name="content" style="height: 200px;"></textarea>
                </div>



























                <!-- EDITOR -->
                <!-- EDITOR -->
                <!-- EDITOR -->
                <script src="<?=SAW_SSL_CDN?>/assets/tinymce2/js/tinymce/tinymce.min.js"></script>
                <script type="text/javascript">
                jQuery(document).ready(function() {  

                  tinymce.PluginManager.add('ncddcustom', function(editor, url) {
                      // Add a button that opens a window
                    editor.addButton('saw-vfl', {
                      title: 'Virtual Forensic Library',
                      text: 'Virtual Forensic Library',
                      icon: true,
                      image: '/assets/img/wysiwyg-toolbar/vfl-25x25.png',
                      onclick: function() {
                        loadPicker();
                      }
                    });

                    editor.addButton('saw-blockquote', {
                      text: 'Block Quote',
                      icon: false,
                      onclick: function() {
                        $('#bq-modal').modal({keyboard: false});
                      }
                    });
                    editor.addButton('saw-well', {
                      text: 'Well',
                      icon: false,
                      onclick: function() {
                        $('#well-modal').modal({keyboard: false});
                      }
                    });
                    editor.addButton('saw-embed-media', {
                      text: 'Embed Media',
                      icon: true,
                      image: '/assets/img/wysiwyg-toolbar/embed-video-25x25.png',
                      onclick: function() {
                        // set the url to that of the image
                        $('#parsing-div').html('');
                        $('#parsing-div').append(tinymce.activeEditor.selection.getContent());
                        $('#media-url').val($('#parsing-div').find("img").attr('data-media-url'));
                        // proceed as normal
                        $('#media-modal-label').html('Embed Media');
                        $('#media-url-label').html('Media Link');
                        $('#media-url').attr('placeholder','Paste the video or sound link here');
                        $('#media-url-help').html('Enter any media link i.e. youtube, vimeo, soundcloud, metacafe, dailymotion, etc.');
                        $('#media-placeholder-text').val('Embedded Media Placeholder');
                        $('#media-placeholder-text').attr('data-img-src','/assets/img/wysiwyg-toolbar/Embedded-Media-Placeholder.gif');/*light blue*/
                        $('#media-placeholder-text').attr('data-img-type','media');
                        $('#media-modal').modal({keyboard: false});
                      }
                    });
                    editor.addButton('saw-embed-website', {
                      text: 'Embed Link',
                      icon: true,
                      image: '/assets/img/wysiwyg-toolbar/embed-website-25x25.png',
                      onclick: function() {
                        // set the url to that of the image
                        $('#parsing-div').html('');
                        $('#parsing-div').append(tinymce.activeEditor.selection.getContent());
                        $('#media-url').val($('#parsing-div').find("img").attr('data-media-url'));
                        //proceed as normal
                        $('#media-modal-label').html('Embed Link');
                        $('#media-url-label').html('Link Address');
                        $('#media-url').attr('placeholder','Paste the link address here');
                        $('#media-url-help').html("Enter any website's page address i.e. http://somedomain.com/interesting/page, etc.");
                        $('#media-placeholder-text').val('Embedded Link Placeholder');
                        $('#media-placeholder-text').attr('data-img-src','/assets/img/wysiwyg-toolbar/Embedded-Link-Placeholder.gif');/*light green*/
                        $('#media-placeholder-text').attr('data-img-type','link');
                        $('#media-modal').modal({keyboard: false});
                      }
                    });
                    editor.addButton('saw-embed-photo', {
                      text: 'Add Photo',
                      icon: true,
                      image: '/assets/img/wysiwyg-toolbar/embed-photo-25x25.png',
                      onclick: function() {
                        $('#add-photo-modal').modal({keyboard: false});
                        $('#add-photo-modal iframe').attr('height',$(window).height()-200);
                      }
                    });
                    editor.addButton('saw-embed-file', {
                      text: 'Add File',
                      icon: true,
                      image: '/assets/img/wysiwyg-toolbar/embed-file-25x25.png',
                      onclick: function() {
                         $('#add-file-modal').modal({keyboard: false});
                        $('#add-file-modal iframe').attr('height',$(window).height()-200);
                      }
                    });
                  });
                  theeditor = tinymce.init({
                      browser_spellcheck:true
                      ,menubar : false
                      ,object_resizing : true
                      ,theme:"modern"
                      ,selector: "textarea"
                      ,content_css: "/assets/plugins/bootstrap/css/bootstrap.min.css,/assets/css/p.css"
                      ,plugins: "ncddcustom code link image textcolor charmap pagebreak fullscreen preview paste autoresize"
                      ,toolbar1: "bold italic strikethrough bullist numlist blockquote saw-blockquote saw-well alignleft aligncenter alignright link unlink code fullscreen preview"
                      ,toolbar2: "undo redo underline alignjustify textcolor removeformat charmap outdent indent formatselect fontsizeselect styleselect cut copy paste"
                      ,toolbar3: "saw-vfl saw-embed-media saw-embed-website saw-embed-photo saw-embed-file"
                      ,plugin_preview_width : $(window).width()-100
                      ,plugin_preview_height : $(window).height()-100
                      ,paste_data_images: false
                      ,paste_word_valid_elements: "b,strong,i,u,em,h1,h2,h3,h4,ul,ol,a,hr"
                      ,paste_preprocess: function(plugin, args) {
                        /*  word processing isn't needed at the moment since it has no real effect 
                          $('#paste-preprocess-datafield').val(args.content);
                          args.content = '';
                          io.saw.FormPost.activate({postUrl:'/content-formatter'
                             ,formName:'#paste-preprocess'
                             ,serializeSelector:':input'
                             ,postOnComplete:function(responseObj,responseStatus){
                                if(responseStatus == 'success'){
                                    tinymce.activeEditor.insertContent(responseObj);
                                }
                             }
                          }); 
                        */
                      }
                      ,paste_postprocess: function(plugin, args) {
                        /*nothing to do*/
                      },setup: function(editor) {
                          editor.on('init', function(e) {
                              //console.log('init event', e);
                          });
                          editor.on('ObjectResizeStart', function(e) {
                            // calculate aspect ratio of original to maintain it
                            window.ratio = e.width / e.height;
                            window.lastW  = e.width;
                            window.lastH  = e.height;
                          });

                          editor.on('ObjectResized', function(e) {
                              //console.log(e.target.id, e.width, e.height);
                              var w = e.width;
                              var h = e.height;
                              var deltaW = Math.abs(window.lastW - w);
                              var deltaH = Math.abs(window.lastH - h);
                              var pctW   = Math.abs(deltaW / lastW);
                              var pctH   = Math.abs(deltaH / lastH);

                              if (deltaW || deltaH) {
                                  if (pctW > pctH) {
                                      // width changed more - use that as the locked point and adjust height
                                      $("#_content_ifr").contents().find("#"+e.target.id).attr('width',w);
                                      $("#_content_ifr").contents().find("#"+e.target.id).attr('height',Math.round(w / ratio));
                                      
                                  } else {
                                      // height changed more - use that as the locked point and adjust width
                                      $("#_content_ifr").contents().find("#"+e.target.id).attr('width',Math.round(h * ratio));
                                      $("#_content_ifr").contents().find("#"+e.target.id).attr('height',h);
                                      
                                      return { width: Math.round(h * ratio), height: h };
                                  }
                              }
                              
                          });
                      }
                  });

                  
                 /* vfl modal functions */                 
                 function loadPicker() {
                    gapi.load('picker', {'callback': createPicker});
                  }
                  function createPicker() {
                    var view = new google.picker.View(google.picker.ViewId.DOCS);
                    var picker = new google.picker.PickerBuilder()
                        .enableFeature(google.picker.Feature.NAV_HIDDEN)
                        .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
                        .setAppId('<?=$this->vars['client_id']?>')
                        .setOAuthToken('<?=$this->vars['access_token']?>')
                        .addView(view)
                        .addView(new google.picker.DocsUploadView())
                        .setCallback(pickerCallback)
                        .build();
                     picker.setVisible(true);
                  }
                  function pickerCallback(data) {
                    if (data.action == google.picker.Action.PICKED) {
                      $.each( data.docs, function( key, value ) {
                          tinymce.activeEditor.insertContent('<p><a href="'+value.embedUrl+'">'+value.name+'</a></p>');
                      });
                     
                    }
                  }
                  /* vfl modal functions - end*/

                  });
                  </script>
                  
                  <script>
                    // non-blocking google api load for VFL
                    window.onload = function() {
                      var s = document.createElement('script');
                      s.type = 'text/javascript';
                      s.setAttribute('src','https://apis.google.com/js/api.js');
                      try {
                        document.body.appendChild(s);
                      } catch (e) {
                        document.body.appendChild(s);
                      }
                    }
                  </script>
                  <script>
                    jQuery(document).ready(function() {  
                      /////////////////
                      // MEDIA MODAL //
                      /////////////////
                      $('#media-modal .btn.view').click(function(){
                        $('#media-modal .media-embed').html('');
                        $('#media-modal .media-embed').remove('script');
                        $(this).html('Verifying URL...');
                        var script = '<scr'+'ipt>'+
                          'var document = window.document;'+
                          '(function(a){'+
                            'var b="embedly-platform",c="script";'+
                            'console.log(a.getElementById(b));'+
                            '/*if(!a.getElementById(b)){*/'+
                            '  var d=a.createElement(c);'+
                            '  d.id=b;'+
                            '  d.async=true;'+
                            '  d.src=("https:"===document.location.protocol?"https":"http")+"://cdn.embedly.com/widgets/platform.js";'+
                            '  var e=a.getElementsByTagName(c)[0];'+
                            '  e.parentNode.insertBefore(d,e)'+
                            '/*}*/'+
                          '})(document);'+
                          '</scr'+'ipt>';
                        $('#media-modal .media-embed').html('<p class="embedly"><a class="embedly-card" data-card-image="0" href="'+$('#media-url').val()+'">Loading Link..</a>'+script+'</p>');      
                        $(this).html('Preview');
                      });
                      $('#media-modal .btn.embed').click(function(){
                        tinymce.activeEditor.insertContent('<p><img id="resize-'+Math.random()+'" data-media-url="'+$('#media-url').val()+'" data-media-type="'+$('#media-placeholder-text').attr('data-img-type')+'" style="padding:20px" src="'+$('#media-placeholder-text').attr('data-img-src')+'"></p>');
                        // clear it and close it
                        $('#media-modal .media-embed').html('');
                        $('#media-url').val('');
                        $('#media-modal').modal('hide');
                      })
                      $('#media-modal .btn.cancel').click(function(){
                        // clear it and close it
                        $('#media-modal .media-embed').html('');
                        $('#media-url').val('');
                        $('#media-modal').modal('hide');
                      });
                      ///////////////////////
                      // BLOCK QUOTE MODAL //
                      ///////////////////////
                      $('#bq-modal .btn.left').click(function(e){
                        e.preventDefault();
                        $('#bq-alignment').attr('data-alignment','left');
                        $('#bq-modal .bq-embed').html('<blockquote style="margin: 10px 20px 10px 20px;"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p><small>Someone famous <cite title="Source Title">Source Title</cite></small></blockquote>');
                      });
                      $('#bq-modal .btn.right').click(function(e){
                        e.preventDefault();
                        $('#bq-alignment').attr('data-alignment','right');
                        $('#bq-modal .bq-embed').html('<blockquote class="pull-right" style="margin: 10px 20px 10px 20px;"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p><small>Someone famous <cite title="Source Title">Source Title</cite></small></blockquote>');
                      });
                      $('#bq-modal .btn.embed').click(function(){
                        if($('#bq-alignment').attr('data-alignment') == 'left'){
                            tinymce.activeEditor.insertContent('<blockquote style="margin: 10px 20px 10px 20px;"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p><small>Someone famous <cite title="Source Title">Source Title</cite></small></blockquote>')                          
                          }else{
                            tinymce.activeEditor.insertContent('<blockquote class="pull-right" style="margin: 10px 20px 10px 20px;"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p><small>Someone famous <cite title="Source Title">Source Title</cite></small></blockquote>')
                          }
                          $('#bq-modal').modal('hide');
                      })
                      $('#bq-modal .btn.cancel').click(function(){
                        $('#bq-modal').modal('hide');
                      });
                      ///////////////////////
                      // WELL QUOTE MODAL //
                      ///////////////////////
                      $('#well-modal .btn.left').click(function(e){
                        e.preventDefault();
                        $('#well-alignment').attr('data-alignment','left');
                        $('#well-modal .well-embed').html('<div class="well" style="margin: 10px 20px 10px 20px;"><h4><b>Some text here</b></h4>Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet. Integer molestie lorem at massa Integer molestie lorem at massa  Integer molestie lorem at massa</div>');
                      });
                      $('#well-modal .btn.right').click(function(e){
                        e.preventDefault();
                        $('#well-alignment').attr('data-alignment','right');
                        $('#well-modal .well-embed').html('<div class="well well-large" style="margin: 10px 20px 10px 20px;"><h3><b>Large text here</b></h3>Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet. Integer molestie lorem at massa Integer molestie lorem at massa  Integer molestie lorem at massa</div>');
                      });
                      $('#well-modal .btn.embed').click(function(){
                        if($('#well-alignment').attr('data-alignment') == 'left'){
                            tinymce.activeEditor.insertContent('<div class="well" style="margin: 10px 20px 10px 20px;"><h4>Some text here</h4>Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet. Integer molestie lorem at massa Integer molestie lorem at massa  Integer molestie lorem at massa</div>')                          
                          }else{
                            tinymce.activeEditor.insertContent('<div class="well well-large" style="margin: 10px 20px 10px 20px;"><h3>Large text here</h3>Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet. Integer molestie lorem at massa Integer molestie lorem at massa  Integer molestie lorem at massa</div>')
                          }
                          $('#well-modal').modal('hide');
                      });
                      $('#well-modal .btn.cancel').click(function(){
                        $('#well-modal').modal('hide');
                      });
                      /////////////////////
                      // ADD PHOTO MODAL //
                      /////////////////////
                      
                      $('#add-photo-modal .btn.cancel').click(function(){
                        $('#add-photo-modal').modal('hide');
                      });
                      $("#add-photo-modal .embed").on("click", function() {
                        tinymce.activeEditor.insertContent('<p><img id="resize-'+Math.random()+'" style="padding:20px" src="'+$("#add-photo-modal iframe").contents().find("#image-"+$("#add-photo-modal iframe")[0].contentWindow.selected_image).attr('src')+'"></p>');
                        $('#add-photo-modal').modal('hide');
                      });
                      ////////////////////
                      // ADD FILE MODAL //
                      ////////////////////
                      
                      $('#add-file-modal .btn.cancel').click(function(){
                        $('#add-file-modal').modal('hide');
                      });
                      $("#add-file-modal .embed").on("click", function() {
                        tinymce.activeEditor.insertContent('<p><a id="resize-'+Math.random()+'" href="'+$("#add-file-modal iframe").contents().find("#file-"+$("#add-file-modal iframe")[0].contentWindow.selected_file).attr('href')+'">'+$("#add-file-modal iframe").contents().find("#file-"+$("#add-file-modal iframe")[0].contentWindow.selected_file).html()+'</a></p>');
                        $('#add-file-modal').modal('hide');
                      });

                    });                   
                  </script>

                <!-- PASTE PREPROCESS DIV -->
                <div class="hide" id="parsing-div">
                  <form id="paste-preprocess" class="horizontal-form portlet">
                     <input id="paste-preprocess-datafield" type="hidden" name="content" placeholder="" value="" class="">
                    </form>
                </div>
                <!--/ PASTE PREPROCESS DIV -->
                <!-- PARSING DIV -->
                <div class="hide" id="parsing-div"></div>
                <!--/ PARSING DIV -->
                <!-- MEDIA MODAL -->
                <div id="media-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="media-modal-label" aria-hidden="true">
                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <h3 id="media-modal-label">Embed Media</h3>
                    </div>
                    <div class="modal-body">
                      <form id="" class="horizontal-form portlet">
                        <div class="row-fluid media-embed">
                          
                        </div>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label id="media-url-label" class="control-label">Media URL</label>
                                 <div class="controls">
                                    <input id="media-url" type="text" name="doc[url]" placeholder="" value="" class="m-wrap span12 url">
                                    <input id="media-placeholder-text" type="hidden" data-image-src="" data-image-type="" value="">
                                    <span id="media-url-help" class="help-inline"></span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                       <button class="btn blue view">Preview</button>
                       <button class="btn green embed">It's good. Embed it.</button>
                       <button class="btn cancel">Cancel</button>
                    </div>
                </div>
                <!--/ MEDIA MODAL -->
                <!-- BQ MODAL -->
                <div id="bq-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="bq-modal-label" aria-hidden="true">
                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <h3 id="bq-modal-label">Custom Block Quote</h3>
                    </div>
                    <div class="modal-body">
                      <form id="" class="horizontal-form portlet">
                        <div class="row-fluid bq-embed">
                          <blockquote style="margin: 10px 20px 10px 20px;"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p><small>Someone famous <cite title="Source Title">Source Title</cite></small></blockquote>
                        </div>
                        <div class="row-fluid">
                           <div class="span12 "><br>
                              <button class="btn left">Align Left</button>&nbsp;&nbsp;<button class="btn right">Align Right</button>
                           </div>
                           <!--/span-->
                        </div>
                        <input id="bq-alignment" type="hidden" data-alignment="left" value="">
                      </form>
                    </div>
                    <div class="modal-footer">
                       <button class="btn green embed">It's good. Embed it.</button>
                       <button class="btn cancel">Cancel</button>
                    </div>
                </div>
                <!--/ BQ MODAL -->
                <!-- WELL MODAL -->
                <div id="well-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="well-modal-label" aria-hidden="true">
                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <h3 id="well-modal-label">Custom Well</h3>
                    </div>
                    <div class="modal-body">
                      <form id="" class="horizontal-form portlet">
                        <div class="row-fluid well-embed">
                          <div class="well" style="margin: 10px 20px 10px 20px;"><h4><b>Some text here</b></h4>Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet. Integer molestie lorem at massa Integer molestie lorem at massa  Integer molestie lorem at massa</div>
                        </div>
                        <div class="row-fluid">
                           <div class="span12 "><br>
                              <button class="btn left">Regular Well</button>&nbsp;&nbsp;<button class="btn right">Large Well</button>
                           </div>
                           <!--/span-->
                        </div>
                        <input id="well-alignment" type="hidden" data-alignment="left" value="">
                      </form>
                    </div>
                    <div class="modal-footer">
                       <button class="btn green embed">It's good. Embed it.</button>
                       <button class="btn cancel">Cancel</button>
                    </div>
                </div>
                <!--/ WELL MODAL -->
                <!-- ADD PHOTO MODAL -->
                <div id="add-photo-modal" class="modal hide fade container" tabindex="-1" role="dialog" aria-labelledby="add-photo-modal-label" aria-hidden="true">
                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <h3 id="add-photo-modal-label">Add Photo</h3>
                    </div>
                    <div class="modal-body">
                      <iframe src="/drive/image/<?=$this->vars['_id']?>" width="100%" height="" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                       <button class="btn green embed">Embed Selected Photo.</button>
                       <button class="btn cancel">Cancel</button>
                    </div>
                </div>
                <!--/ ADD PHOTO MODAL -->
                <!-- ADD FILE MODAL -->
                <div id="add-file-modal" class="modal hide fade container" tabindex="-1" role="dialog" aria-labelledby="add-file-modal-label" aria-hidden="true">
                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                       <h3 id="add-file-modal-label">Add File</h3>
                    </div>
                    <div class="modal-body">
                      <iframe src="/drive/file/<?=$this->vars['_id']?>" width="100%" height="" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                       <button class="btn green embed">Embed Selected File.</button>
                       <button class="btn cancel">Cancel</button>
                    </div>
                </div>
                <!--/ ADD FILE MODAL -->
                
                <!--/ EDITOR -->
                <!--/ EDITOR -->
                <!--/ EDITOR -->


















              </div>
            </div>
            <!-- END PAGE CONTENT-->


         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->