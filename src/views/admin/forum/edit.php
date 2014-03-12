<? $user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$this->app); 
$accessLevel = $user['accessLevel'];
$user_id = $user['user_id'];

$isOwner =  ( array_key_exists('topic',$this->vars) && array_key_exists('forum',$this->vars['topic']) && array_key_exists('owner',$this->vars['topic']['forum']) && array_key_exists('_id',$this->vars['topic']['forum']['owner']) && (string)$user_id == (string)$this->vars['topic']['forum']['owner']['_id']) ? true: false ;
?>
<?
   $show = 'yes';
   if(!empty($this->vars['topic']) && array_key_exists('currentStatus',$this->vars['topic'])): 
      $status = \Saw\Model\Topic::$statusReversed[$this->vars['topic']['currentStatus']];
      switch ($status) {
         case 'REVIEW':
            if($accessLevel == MEMBER){
               $show = 'yes';
            } else if ($accessLevel >= EDITOR || $isOwner){
               $show = 'yes';
            }
            break;
         case 'SCHEDULE':
            if ($accessLevel >= EDITOR || $isOwner){
               $show = 'yes';
               break;
            }else{
               $show = 'no';
            }
         case 'PUBLISH':
            if ($accessLevel >= EDITOR || $isOwner){
               $show = 'yes';
            }else{
               $show = 'no';
            }
            break;
         case 'UNPUBLISH':
            if ($accessLevel >= EDITOR || $isOwner){
               $show = 'yes';
            }else{
               $show = 'no';
            }
            break;
      }
   endif;
?>

         <link rel="stylesheet" type="text/css" href="/assets/plugins/jquery-multi-select/css/multi-select-metro.css" />
         <script type="text/javascript" src="/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>   

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
                     <form id="saw-form" class="horizontal-form portlet">
                        <input id="add" type="hidden" name="doc[add]" value="<?=$this->vars['add']?>">
                        <input id="currentStatus" type="hidden" name="doc[currentStatus]" value="<?=$this->vars['topic']['currentStatus']?>">
                        <input id="_id" type="hidden" name="doc[_id]" value="<?=(array_key_exists('topic',$this->vars)) ? $this->vars['topic']['_id'] : '' ?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h2>Draft a topic here.  Save it as a draft or submit it for publishing.</h2>
                        
                        <h3 class="form-section text-info"><strong>Forum</strong></h3>
                        <p>Select a forum to publish this topic to.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <select name="doc[forum]" <?=($show=='no') ? 'readonly=""' : ''?> class="span10 m-wrap forum" data-placeholder="Choose a Forum" tabindex="1">
                                       <? foreach($this->vars['forums'] as $forum):
                                       $selected = ((!empty($this->vars['topic']) && array_key_exists('forum',$this->vars['topic']) && array_key_exists('_id',$this->vars['topic']['forum']) && (string)$this->vars['topic']['forum']['_id'] == (string)$forum['_id']) || (!empty($this->vars['forumId']) &&  $this->vars['forumId'] == (string)$forum['_id']) ) ? 'selected' : '';
                                       ?>
                                       <option <?=$selected?> value="<?=$forum['_id']?>"><?=$forum['name']?></option>
                                       <? endforeach; ?>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <h3 class="form-section text-info"><strong>Headline</strong></h3>
                        <p>Create a short yet descriptive headline for your post.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input <?=($show=='no') ? 'readonly=""' : ''?> type="text" name="doc[headline]" value="<?=(!empty($this->vars['topic']) && array_key_exists('headline',$this->vars['topic'])) ? $this->vars['topic']['headline']: ''?>" class="m-wrap span10 headline">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <h3 class="form-section text-info"><strong>Picture (optional)</strong></h3>
                        <p>You can upload a picture to make your topic more appealing.  From an SEO perspective, topics with a picture are much better received by search engines.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                     <? if($show=='yes'):?>
                                    <a href="#" class="btn blue manage-picture">Click here to manage the picture</a><br><br>
                                    <? endif; ?>
                                    <img id="image" src="<?=$this->vars['image']?>" width="329">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>

                        <h3 class="form-section text-info"><strong>Files (optional)</strong></h3>
                        <input type="hidden" name="doc[files]" value="" id="files">
                        <p>Select files from the Virtual Forensic Library to attach to your topic for reference.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <!-- BEGIN EXAMPLE TABLE PORTLET-->
                              <div class="portlet box grey">
                                 <div class="portlet-title" id="draft">
                                    <div class="caption"><i class="icon-legal"></i>Files attached to this Topic</div>
                                    <div class="actions">
                                       <a id="add-vfl" href="" class="btn green draft-post" data-id=""><i class="icon-plus"></i> Add Files from the Virtual Forensic Library.</a>
                                    </div>
                                 </div>
                                 <div class="portlet-body">
                                    <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <table class="table table-striped table-bordered table-hover dataTable" id="drafts" aria-describedby="sample_1_info">
                                       <thead>
                                          <tr role="row">
                                             <th class="">File Name</th>
                                             <th class="">File Link</th>
                                             <th class=""></th>
                                          </tr>
                                       </thead>
                                       <tbody id="vfl-body" role="alert" aria-live="polite" aria-relevant="all">
                                          <td colspan="5">No Files.</td>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <!-- END EXAMPLE TABLE PORTLET-->
                           </div>
                           <!--/span-->
                        </div>

                        <h3 class="form-section text-info"><strong>Content</strong>&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.activeEditor.focus();">Click to Edit</a></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                           <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                           <div id="body" class="span12 editable" style="margin-left:0px;">
                              <?=(!empty($this->vars['topic']) && array_key_exists('body',$this->vars['topic'])) ? $this->vars['topic']['body'] : '<br>'?>
                           </div>
                           <input id="input-body" type="hidden" name="doc[body]" value="">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        


                        <? if($accessLevel >= EDITOR || $isOwner && (array_key_exists('topic',$this->vars) && array_key_exists('currentStatus',$this->vars['topic']) && $this->vars['topic']['currentStatus'] <=  \Saw\Model\Topic::$status['SCHEDULE'])): ?>
                           <h3 class="form-section text-info"><strong>Schedule for Publishing</strong></h3>
                           <p>This is optional.  You can go ahead and publish it now by clicking the "Publish Now" button below.</p>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 <div class="control-group ">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                       <div class="input-append date " data-date="" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                          <input placeholder="click to enter date" class="m-wrap m-ctrl-medium date-picker span10 scheduleDate" name="doc[scheduleDate]" readonly="" type="text" value="<?=(!empty($this->vars['topic']) && array_key_exists('scheduleDate',$this->vars['topic']) && is_array($this->vars['topic']['scheduleDate']) && array_key_exists('detail',$this->vars['topic']['scheduleDate'])) ? $this->vars['topic']['scheduleDate']['detail']: ''?>">
                                          <span class="add-on"><i class="icon-calendar"></i></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!--/span-->
                           </div>
                        <? endif; ?>
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <div class="form-actions text-center">
                           <? 
                              
                              $buttons = "<button type='button' class='btn green save'><i class='icon-pencil'></i> Save draft for later editing.</button>
                                          <button type='button' class='btn yellow review'><i class='icon-ok'></i> It's ready. Submit for publishing.</button>
                                          <button type='button' class='btn cancel'>Cancel</button>";
                              if(!empty($this->vars['topic']) && array_key_exists('author',$this->vars['topic']) && (string)$user_id == (string)$this->vars['topic']['author']['_id']){
                                 $buttons.=" <button type='button' class='btn red delete'>Delete</button>";
                              }
                              
                              if(!empty($this->vars['topic']) && array_key_exists('currentStatus',$this->vars['topic'])): 
                                 $status = \Saw\Model\Topic::$statusReversed[$this->vars['topic']['currentStatus']];
                                 switch ($status) {
                                    case 'REVIEW':
                                       if ($accessLevel >= EDITOR || $isOwner){
                                          $buttons = "<button type='button' class='btn green publish'><i class='icon-ok'></i> Publish now.</button>
                                                      <button type='button' class='btn yellow schedule'><i class='icon-pencil'></i> Schedule for publishing.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>
                                                      <button type='button' class='btn red delete'>Delete</button>";
                                       } else if($accessLevel == MEMBER){
                                          $buttons = "<button type='button' class='btn green save-draft'><i class='icon-pencil'></i> Save and take out of the approval queue.</button>
                                                      <button type='button' class='btn yellow save'><i class='icon-ok'></i> Save and leave in the approval queue.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>";

                                          if(!empty($this->vars['topic']) && array_key_exists('author',$this->vars['topic']) && (string)$user_id == (string)$this->vars['topic']['author']['_id']){
                                             $buttons.=" <button type='button' class='btn red delete'>Delete</button>";
                                          }
                                       }
                                       break;
                                    case 'SCHEDULE':
                                       if ($accessLevel >= EDITOR || $isOwner){
                                          $buttons = "<button type='button' class='btn green schedule'><i class='icon-pencil'></i> Save </button>
                                                      <button type='button' class='btn yellow review'><i class='icon-ok'></i> Save and remove from publishing schedule.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>
                                                      <button type='button' class='btn red delete'>Delete</button>";
                                          break;
                                       }else{
                                          $buttons = '';
                                       }
                                    case 'PUBLISH':
                                       if ($accessLevel >= EDITOR || $isOwner){
                                          $buttons = "<button type='button' class='btn green save'><i class='icon-pencil'></i> Save.</button>
                                                      <button type='button' class='btn yellow unpublish'><i class='icon-ok'></i> Save and un-publish.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>
                                                      <button type='button' class='btn red delete'>Delete</button>";
                                       }else{
                                          $buttons = '';
                                       }
                                       break;
                                    case 'UNPUBLISH':
                                       if ($accessLevel >= EDITOR || $isOwner){
                                          $buttons = "<button type='button' class='btn green publish'><i class='icon-ok'></i> Publish now.</button>
                                                      <button type='button' class='btn yellow schedule'><i class='icon-pencil'></i> Schedule for publishing.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>
                                                      <button type='button' class='btn red delete'>Delete</button>";
                                       }else{
                                          $buttons="";
                                       }
                                       break;
                                 }
                              endif;
                              echo $buttons;
                           ?>
                        </div>
                     </form>
                     <!-- SUCCESSFUL SAVE MODAL -->
                     <div id="save-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="save-modal-label">Successful Operation.</h3>
                        </div>
                        <div class="modal-body">
                           <p></p>
                        </div>
                        <div class="modal-footer">
                           <button class="btn green continue edit">Continue Editing</button>
                           <? if($accessLevel >= EDITOR): ?>
                              <button class="btn blue all-posts">Go to All Topics</button>
                           <? else: ?>
                              <button class="btn blue my-posts">Go to My Topics</button>
                           <? endif; ?>
                           <button class="btn blue dashboard">Go to Dashboard</button>
                        </div>
                     </div>
                     <!--/ SUCCESSFUL SAVE MODAL -->

                     <!-- DELETE MODAL -->
                     <div id="delete-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="delete-modal-label">Delete Operation.</h3>
                        </div>
                        <div class="modal-body">
                           <p>Are you sure you want to delete this topic?  Deleting will purge the entire topic including all photos and comments.  This operation cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                           <button class="btn red yes">Yes, I'm sure. Delete.</button>
                           <button class="btn no">Cancel Delete</button>
                        </div>
                     </div>
                     <!--/ DELETE MODAL -->

                     
                  </div>
               </div>
               <!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTAINER-->    
         </div>
         <!-- END PAGE -->
         <?=$this->element('js/Topic.js');?>
         <script>
         jQuery(document).ready(function() {    
            io.saw.Topic.init();

            <? if ($show == 'yes'): ?>
               $('#tags').multiSelect();
               if (jQuery().datepicker) {
                  $('.date-picker').datepicker({
                     rtl : App.isRTL()
                  });
               }

          <? endif; ?>
           
         });            
         
         <? if(array_key_exists('topic', $this->vars) && array_key_exists('files', $this->vars['topic']) && !empty($this->vars['topic']['files'])): ?>
               
         var files = <?=json_encode($this->vars['topic']['files'])?>;
            
         <? else: ?>
         var files = [];
         <? endif; ?>
         
         function render_files_grid(){
           $('#vfl-body').html('');
           $.each( files, function( key, file ) {
               var newRow = '<tr class="gradeX odd"><td class=" ">'+file.name+'</td><td class=" "><a href="'+file.embedUrl+'" target="_blank">'+file.embedUrl+'</a></td><td data-id="'+file.id+'" class="minus"><a class="btn"><i class="icon-minus"></i></a></td></tr>';
               $('#vfl-body').append(newRow);
           });
            $('#vfl-body .minus').click(function(e){
               e.preventDefault();
               for (var i = files.length - 1; i > -1; i--) {
                      if (files[i].id === $(this).attr('data-id'))
                          files.splice(i, 1);
                  }
               render_files_grid();
            })
         }

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
                  for (var i = files.length - 1; i > -1; i--) {
                      if (files[i].id === value.id)
                          files.splice(i, 1);
                  }
                  files.push({
                     name:value.name
                     ,embedUrl:value.embedUrl
                     ,id:value.id
                  });
              });
              render_files_grid();
            }
          }
          jQuery(document).ready(function() {    
             
               $('#add-vfl').click(function(e){
                  e.preventDefault();
                  loadPicker();
               });

               render_files_grid();
            });
          </script>

         <? $id = (array_key_exists('topic',$this->vars)) ? $this->vars['topic']['_id'] : '' ?>
         <?=$this->element('editor',array('_id'=>$id,'client_id'=>$this->vars['client_id'],'access_token'=>$this->vars['access_token']));?>

          <!-- The Google API Loader script. -->
          <script type="text/javascript" src="https://apis.google.com/js/api.js"></script>
