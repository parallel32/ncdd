<? 
$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$this->app);
$accessLevel = $user['accessLevel']; 
$user_id = $user['user_id']; ?>
<?
   $show = 'yes';
   if(!empty($this->vars['forum']) && array_key_exists('currentStatus',$this->vars['forum'])): 
      $status = \Saw\Model\Forum::$statusReversed[$this->vars['forum']['currentStatus']];
      switch ($status) {
         case 'REVIEW':
            if($accessLevel == MEMBER){
               $show = 'yes';
            } else if ($accessLevel >= EDITOR){
               $show = 'yes';
            }
            break;
         case 'PUBLISH':
            if ($accessLevel >= EDITOR){
               $show = 'yes';
            }else{
               $show = 'no';
            }
            break;
         case 'UNPUBLISH':
            if ($accessLevel >= EDITOR){
               $show = 'yes';
            }else{
               $show = 'no';
            }
            break;
      }
   endif;
?>

         <link rel="stylesheet" type="text/css" href="<?=SAW_SSL_CDN?>/assets/plugins/jquery-multi-select/css/multi-select-metro.css" />
         <script type="text/javascript" src="<?=SAW_SSL_CDN?>/assets/plugins/jquery-multi-select/js/jquery.multi-select.js"></script>   

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
                        <input id="currentStatus" type="hidden" name="doc[currentStatus]" value="">
                        <input id="_id" type="hidden" name="doc[_id]" value="<?=(array_key_exists('forum',$this->vars)) ? $this->vars['forum']['_id'] : '' ?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <?if($this->vars['add'] == 'yes'):?>
                        <h2>Add a Forum here and submit it for review and publishing.</h2>
                        <? else: ?>
                        <h2>Edit your Forum here.</h2>
                        <? endif; ?>
                        <h3 class="form-section text-info"><strong>Forum Name</strong></h3>
                        <p>Create a short yet descriptive name for your forum.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input <?=($show=='no') ? 'readonly=""' : ''?> type="text" name="doc[name]" value="<?=(!empty($this->vars['forum']) && array_key_exists('name',$this->vars['forum'])) ? $this->vars['forum']['name']: ''?>" class="m-wrap span10 name">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Picture (optional)</strong></h3>
                        <p>You can upload a picture to make your forum more appealing.</p>
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
                        
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <div class="form-actions text-center">
                           <? 
                              if($accessLevel >= EDITOR):
                                 $buttons = "<button type='button' class='btn green save'><i class='icon-pencil'></i> Save draft for later publishing.</button>
                                             <button type='button' class='btn green publish'><i class='icon-ok'></i> It's ready. Publish it.</button>
                                             <button type='button' class='btn cancel'>Cancel</button>";
                              else:
                                 $buttons = "<button type='button' class='btn green save'><i class='icon-pencil'></i> Save draft for later publishing.</button>
                                             <button type='button' class='btn yellow review'><i class='icon-ok'></i> It's ready. Submit for review and publishing.</button>
                                             <button type='button' class='btn cancel'>Cancel</button>";
                              
                              endif;
                              if((array_key_exists('forum',$this->vars) && !empty($this->vars['forum']) && array_key_exists('owner',$this->vars['forum']) && array_key_exists('_id',$this->vars['forum']['owner']) && $user_id == (string)$this->vars['forum']['owner']['_id']) || array_key_exists('forum',$this->vars) && array_key_exists('owner',$this->vars['forum']) && empty($this->vars['forum']['owner']) && $accessLevel >= EDITOR){
                                 $buttons.=" <button type='button' class='btn red delete'>Delete</button>";
                              }
                              
                              if(!empty($this->vars['forum']) && array_key_exists('currentStatus',$this->vars['forum'])): 
                                 $status = \Saw\Model\Forum::$statusReversed[$this->vars['forum']['currentStatus']];
                                 switch ($status) {
                                    case 'REVIEW':
                                       if($accessLevel == MEMBER){
                                          $buttons = "<button type='button' class='btn green save-draft'><i class='icon-pencil'></i> Save and take out of the review queue.</button>
                                                      <button type='button' class='btn yellow save'><i class='icon-ok'></i> Save and leave in the review queue.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>";

                                          if(array_key_exists('forum',$this->vars) && !empty($this->vars['forum']) && array_key_exists('owner',$this->vars['forum']) && array_key_exists('_id',$this->vars['forum']['owner']) && $user_id == (string)$this->vars['forum']['owner']['_id']){
                                             $buttons.=" <button type='button' class='btn red delete'>Delete</button>";
                                          }
                                       } else if ($accessLevel >= EDITOR){
                                          $buttons = "<button type='button' class='btn green publish'><i class='icon-ok'></i> Publish now.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>
                                                      <button type='button' class='btn red delete'>Delete</button>";
                                       }
                                       break;
                                    case 'PUBLISH':
                                       if ($accessLevel >= EDITOR){
                                          $buttons = "<button type='button' class='btn green save'><i class='icon-pencil'></i> Save.</button>
                                                      <button type='button' class='btn yellow unpublish'><i class='icon-ok'></i> Save and un-publish.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>
                                                      <button type='button' class='btn red delete'>Delete</button>";
                                       }else{
                                          $buttons = '';
                                       }
                                       break;
                                    case 'UNPUBLISH':
                                       if ($accessLevel >= EDITOR){
                                          $buttons = "<button type='button' class='btn green publish'><i class='icon-ok'></i> Publish now.</button>
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
                              <button class="btn blue admin">Go to Manage Forums</button>
                           <? else: ?>
                              <button class="btn blue my-admin">Go to My Forums</button>
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
                           <p>Are you sure you want to delete this forum?  Deleting will purge the entire forum  including all topics and comments.  This operation cannot be undone.</p>
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
         <?=$this->element('js/Forum.js');?>
         <script>
         jQuery(document).ready(function() {    
            io.saw.Forum.init();

            <? if ($show == 'yes'): ?>
               $('#tags').multiSelect();
               if (jQuery().datepicker) {
                  $('.date-picker').datepicker({
                     rtl : App.isRTL()
                  });
               }
          <? endif; ?>
           
         });
            
         </script>

