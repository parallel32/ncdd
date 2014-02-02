<? $category = $this->vars['category']; ?>
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
            
            <? if(true): ?>
            <!-- BEGIN FILEUPLOAD PAGE CONTENT-->
            <div class="row-fluid uploadView">
               <div class="span12">
                  
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box blue">
                     <div class="portlet-title">
                        <div class="caption"><i class="icon-picture"></i>Edit Topic Image</div>
                       <div class="actions">
                          <a class="btn red image <?=($this->vars['image'] == '/placeholder') ? 'hide' :'' ?>"> Delete This Image</a>
                          <a class="btn yellow image <?=($this->vars['image'] == '/placeholder') ? 'hide' :'' ?>"> Crop This Image</a>
                          <a class="btn back image "> Save & Go Back</a>
                       </div>
                     </div>

                     <div class="portlet-body form">
                       <blockquote>
                          <img id="image" src="<?=$this->vars['image']?>" width="529">
                       </blockquote>
                       <br>
                       <!-- The file upload form used as target for the file upload widget -->
                       <form id="fileupload" action="#" method="POST" enctype="multipart/form-data">
                          <input type="hidden" name="doc[belongsTo]" value="<?=$category['_id']?>">
                          <input type="hidden" name="doc[context]" value="category">
                          <!-- Redirect browsers with JavaScript disabled to the origin page -->
                          <noscript><input type="hidden" name="redirect" value="/image/upload/nojavascript"></noscript>
                          <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                          <div class="row-fluid fileupload-buttonbar">
                             <div class="span7">
                                <!-- The fileinput-button span is used to style the file input field as button -->
                                <span class="btn green fileinput-button">
                                <i class="icon-plus icon-white"></i>
                                <span>Add an image for upload</span>
                                <input type="file" name="file" multiple>
                                </span>
                                <button type="submit" class="btn blue start hide">
                                <i class="icon-upload icon-white"></i>
                                <span>Start upload</span>
                                </button>
                                <button type="reset" class="btn yellow cancel hide">
                                <i class="icon-ban-circle icon-white"></i>
                                <span>Cancel upload</span>
                                </button>
                                <button type="button" class="btn red delete hide">
                                <i class="icon-trash icon-white"></i>
                                <span>Delete</span>
                                </button>
                                <!--<input type="checkbox" class="toggle fileupload-toggle-checkbox">-->
                             </div>
                             <!-- The global progress information -->
                             <div class="span5 fileupload-progress fade">
                                <!-- The global progress bar -->
                                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                   <div class="bar" style="width:0%;"></div>
                                </div>
                                <!-- The extended global progress information -->
                                <div class="progress-extended">&nbsp;</div>
                             </div>
                          </div>
                          <!-- The loading indicator is shown during file processing -->
                          <div class="fileupload-loading"></div>
                          <br>
                          <!-- The table listing the files available for upload/download -->
                          <table role="presentation" class="table table-striped">
                             <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
                          </table>
                       </form>
                       <br>
                       <div class="well">
                          <h3>Upload Information</h3>
                          <ul>
                             <li>The maximum file size for uploads is <strong>20 MB</strong>.</li>
                             <li>Only images are allowed (<strong>JPG, PNG, GIF</strong>) are allowed.</li>
                             <li>You can also <strong>drag &amp; drop</strong> the file from your desktop on this webpage with Google Chrome, Mozilla Firefox and Apple Safari.</li>
                          </ul>
                       </div>
                       <?if(!empty($this->vars['domain']['template'])): ?>
                       <div class="well">
                          <h3>Current Template Information</h3>
                          <ul>
                             <li>uploadedFileName: <strong><?=$this->vars['domain']['template']['uploadedFileName']?></strong></li>
                          </ul>
                          <h4>Page Types</h4>
                          <ul>
                             <?foreach($this->vars['domain']['pageTypes'] as $pageType): ?>
                               <li>name:<strong><?=$pageType['name']?></strong> route:<strong><?=$pageType['route']?></strong><br>fileName:<strong><?=$pageType['fileName']?></strong></li>
                             <? endforeach; ?>
                          </ul>
                       </div>
                       <?endif;?>
                    </div>
                 </div>
                 <div class="row-fluid uploadView">
                    <div class="span12">
                       <script id="template-upload" type="text/x-tmpl">
                          {% for (var i=0, file; file=o.files[i]; i++) { %}
                              <tr class="template-upload fade">
                                  <td class="preview"><span class="fade"></span></td>
                                  <td class="name"><span>{%=file.name%}</span></td>
                                  <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                                  {% if (file.error) { %}
                                      <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
                                  {% } else if (o.files.valid && !i) { %}
                                      <td>
                                          <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
                                      </td>
                                      <td class="start">{% if (!o.options.autoUpload) { %}
                                          <button class="btn">
                                              <i class="icon-upload icon-white"></i>
                                              <span>Start</span>
                                          </button>
                                      {% } %}</td>
                                  {% } else { %}
                                      <td colspan="2"></td>
                                  {% } %}
                                  <td class="cancel">{% if (!i) { %}
                                      <button class="btn red">
                                          <i class="icon-ban-circle icon-white"></i>
                                          <span>Cancel</span>
                                      </button>
                                  {% } %}</td>
                              </tr>
                          {% } %}
                       </script>
                       <!-- The template to display files available for download -->
                       <script id="template-download" type="text/x-tmpl">
                          {% for (var i=0, file; file=o.files[i]; i++) { %}
                              <tr class="template-download fade">
                                  {% if (file.error) { %}
                                      <td></td>
                                      <td class="name"><span>{%=file.name%}</span></td>
                                      <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                                      <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
                                  {% } else { %}
                                       <!--
                                      <td class="preview">
                                      {% if (file.thumbnail_url) { %}
                                          <a class="fancybox-button" data-rel="fancybox-button" href="{%=file.url%}" title="{%=file.name%}">
                                            <img src="{%=file.thumbnail_url%}">
                                          </a>
                                      {% } %}</td>
                                      <td class="name">
                                            <!-- removed from the <a tag below: href="{%=file.url%}" -->
                                          <a title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
                                      </td>
                                      <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
                                      <td colspan="2"></td>-->
                                  {% } %}
                                  <!--
                                  <td class="delete">
                                      <button class="btn red" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                                          <i class="icon-trash icon-white"></i>
                                          <span>Delete</span>
                                      </button>
                                      <input type="checkbox" class="fileupload-checkbox hide" name="delete" value="1">
                                  </td>-->
                              </tr>
                          {% } %}
                       </script>
                     </div>
                  </div>
                  <!-- END VALIDATION STATES-->
              </div>
            </div>
            <!-- END FILEUPLOAD PAGE CONTENT-->
            <? endif; ?>
         </div>
         <!-- END PAGE CONTAINER-->
      </div>
      <!-- END PAGE -->
      <?=$this->element('js/FileUploadClass.js');?>
      <script>
      jQuery(document).ready(function() {   

        $('.yellow.image').click(function(e){
            document.location.href='/category/edit/<?=$category['_id']?>/edit-photo-crop';
        }); 
        $('.back.image').click(function(e){
          document.location.href='/category/edit/<?=$category['_id']?>';
        }); 
        $('.red.image').click(function(e){
          io.saw.FormGet.activate({postUrl:"<?=(array_key_exists('imageDelete',$this->vars)) ? $this->vars['imageDelete']: '';?>"
            ,postOnComplete:function(responseObj,responseStatus){}
            ,postOnSuccess:function(responseObj){
              document.location.href='/category/edit/<?=$category['_id']?>/edit-photo';
            }
          });
        }); 
         io.saw.FileUpload.init({
            fileUploadLimit:1
            ,formId:'#fileupload'
            ,uploadURL:'/image/upload'
            ,onLoad:function(e,data){
               // nothing
            }
            ,onSend:function(e,data){
               //nothing to do
            }
            ,onDone:function(e,data){
               if(data.textStatus == 'success'){
                  $('#image').attr('src',data.result.files[0].thumbnail_url);
                  $('.red.image').removeClass('hide');
                  $('.yellow.image').removeClass('hide');
               }
            }
            ,onFail:function(e,data){
               if(data.textStatus == 'error'){
                  //nothing to do     
               }
            }
            ,onAlways:function(e,data){
               if(data.textStatus == 'success'){
                  //nothing to do
               }else if(data.textStatus == 'error'){
                  //nothing to do
               }
               $('.btn.blue.start').hide();
            }
            ,onFileAddToQueue:function(e,data){
               $('.btn.blue.start').show();
            }
         });

      });
      </script>
