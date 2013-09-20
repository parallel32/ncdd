<? $seminar = $this->vars['seminar']; ?>
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
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box blue">
                     <div class="portlet-title">
                        <h4><i class="icon-facetime-video"></i> Edit Seminar</h4>
                     </div>
                     <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form id="saw-form" class="form-horizontal" novalidate="novalidate">
                           <input type="hidden" name="doc[_id]" value="<?=$seminar['_id']?>">
                           <div class="row-fluid">
                              <div class="span12 ">
                                 
                                 <div class="alert alert-error hide">
                                    <button class="close" data-dismiss="alert"></button>
                                    You have some form errors. Please check below.
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Headline<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[headline]" value="<?=$seminar['headline']?>" data-required="1" class="span6 m-wrap headline">
                                       <span class="help-block" id="headline-slug"></span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Start Date<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[startDate]" value="<?=$seminar['startDate']['detail']?>" data-required="1" class="span6 m-wrap startDate" value="">
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">End Date<span class="required">*</span></label>
                                    <div class="controls">
                                       <input type="text" name="doc[endDate]" value="<?=$seminar['endDate']['detail']?>" data-required="1" class="span6 m-wrap endDate">
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 <div class="control-group">
                                    <label class="control-label">Time Zone<span class="required">*</span></label>
                                    <div class="controls">
                                       <? 
                                          $tz = array('America/New_York'=>'Eastern'
                                                      ,'America/Chicago'=>'Central'
                                                      ,'America/Denver'=>'Mountain'
                                                      ,'America/Los_Angeles'=>'Pacific'
                                                      ,'America/Anchorage'=>'Alaska'
                                                      ,'America/Adak'=>'Hawaii'
                                                );

                                       ?>
                                       <select name="doc[timeZone]" class="span6 m-wrap timeZone" data-placeholder="Choose a Category" tabindex="1">
                                          <? foreach($tz as $key=>$value): ?>
                                             <option value="<?=$key?>" <?=($key == $seminar['timeZone']) ? "selected" : "";?>><?=$value?></option>
                                          <? endforeach; ?>
                                       </select>
                                       <span class="help-block"></span>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>
                           <h3 class="form-section">Description</h3>&nbsp;<button type="button" class="btn blue show-editor">Click To Edit</button><br><br>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 <div class="control-group">
                                    <span id="description" class="help-block "><?=$seminar['description']?></span>
                                    <input id="input-description" type="hidden" name="doc[description]" value="">
                                 </div>
                              </div>
                           </div>


                           <div class="form-actions">
                              <button type="button" class="btn green">Save</button>
                              <button type="button" class="btn cancel">Cancel</button>
                              <button type="button" class="btn blue manage">Manage Agendas</button>
                              <button type="button" class="btn red image <?=($this->vars['image'] == '/noimage') ? 'hide' :'' ?>">Delete Image</button>
                           </div>
                        </form>
                        <form id="saw-slug" class="form-horizontal" novalidate="novalidate">
                           <input type="hidden" id="slug-str" name="slug-str">
                        </form>
                        <!-- END FORM-->

                        <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                              <h3 id="save-success-label">Successful Operation</h3>
                           </div>
                           <div class="modal-body">
                              <p></p>
                           </div>
                           <div class="modal-footer">
                              <button class="btn finished" aria-hidden="true">Finished</button>
                              <button class="btn blue continue" data-insertid="">Edit Again</button>
                           </div>
                        </div>

                     </div>
                  </div>
                  <!-- END VALIDATION STATES-->
               </div>
            </div>
            <!-- END PAGE CONTENT-->
            <? if(true): ?>
            <!-- BEGIN FILEUPLOAD PAGE CONTENT-->
            <div class="row-fluid uploadView">
               <div class="span12">
                  <!-- BEGIN VALIDATION STATES-->
                  <div class="portlet box blue">
                     <div class="portlet-title">
                        <h4><i class="icon-picture"></i> Edit Seminar Image</h4>
                     </div>
                     <div class="portlet-body form">
                       <blockquote>
                          <img id="image" src="<?=$this->vars['image']?>">
                       </blockquote>
                       <br>
                       <!-- The file upload form used as target for the file upload widget -->
                       <form id="fileupload" action="#" method="POST" enctype="multipart/form-data">
                          <input type="hidden" name="doc[belongsTo]" value="<?=$seminar['_id']?>">
                          <input type="hidden" name="doc[context]" value="seminar">
                          <!-- Redirect browsers with JavaScript disabled to the origin page -->
                          <noscript><input type="hidden" name="redirect" value="/image/upload/nojavascript"></noscript>
                          <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                          <div class="row-fluid fileupload-buttonbar">
                             <div class="span7">
                                <!-- The fileinput-button span is used to style the file input field as button -->
                                <span class="btn green fileinput-button">
                                <i class="icon-plus icon-white"></i>
                                <span>Add a file for upload</span>
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

      <?=$this->element('js/Seminar.js');?>
      <?=$this->element('js/FileUploadClass.js');?>
      <?=$this->element('js/FormDatePickerClass.js');?>
      <script src="/assets/plugins/jquery.appear.js" type="text/javascript"></script> 
      <script>
      jQuery(document).ready(function() {    
         io.saw.FormDatePicker.init('range');
         io.saw.Seminar.init('edit');
         io.saw.Seminar.sluggify('headline','headline');
         /*
         Aloha.ready( function() {
            Aloha.jQuery('.description').aloha();
         });
         */

         window.editor = new SnapEditor.InPlace("description", {
              path: "/assets/snapeditor",
             toolbar: {
               items: [
                "styleBlock", "|",
                "bold", "italic", "underline", "|",
                "alignLeft", "alignCentre", "alignRight", "alignJustify", "|",
                "orderedList", "unorderedList", "indent", "outdent", "|",
                "link", "table", "horizontalRule", "|"
              ],
             }
             ,snap: false
             ,onSave: function (e) {
                var isSuccess = true;
                html = e.html;
                io.saw.Seminar.edit();
                return isSuccess || "Error";
             }
             ,onUnsavedChanges: function (e) {
                  e.api.execAction("save");
              }
          });
         $('#description').appear();
         $('#description').on('appear', function(event, $all_appeared_elements) {
            window.editor.api.activate();    
         });
         $('.show-editor').click(function(e){
            window.editor.api.activate();
         })
            
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
