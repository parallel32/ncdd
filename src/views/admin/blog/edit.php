<? $accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app); ?>
<?
   $show = 'yes';
   if(!empty($this->vars['blog']) && array_key_exists('currentStatus',$this->vars['blog'])): 
      $status = \Saw\Model\Blog::$statusReversed[$this->vars['blog']['currentStatus']];
      switch ($status) {
         case 'REVIEW':
            if($accessLevel == MEMBER){
               $show = 'yes';
            } else if ($accessLevel >= EDITOR){
               $show = 'yes';
            }
            break;
         case 'SCHEDULE':
            if ($accessLevel >= EDITOR){
               $show = 'yes';
               break;
            }else{
               $show = 'no';
            }
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
                        <input id="currentStatus" type="hidden" name="doc[currentStatus]" value="">
                        <input id="_id" type="hidden" name="doc[_id]" value="<?=(array_key_exists('blog',$this->vars)) ? $this->vars['blog']['_id'] : '' ?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h2>Draft a blog post here.  Save it as a draft or submit it for publishing.</h2>
                        <h3 class="form-section text-info"><strong>Headline</strong></h3>
                        <p>Create a short yet descriptive headline for your post.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input <?=($show=='no') ? 'readonly=""' : ''?> type="text" name="doc[headline]" value="<?=(!empty($this->vars['blog']) && array_key_exists('headline',$this->vars['blog'])) ? $this->vars['blog']['headline']: ''?>" class="m-wrap span10 headline">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Url</strong></h3>
                        <p>Your Headline will automatically produce a clean SEO friendly URL.  But, you can always change it here after you finish typing the Headline.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input <?=($show=='no') ? 'readonly=""' : ''?> type="text" name="doc[slug]" value="<?=(!empty($this->vars['blog']) && array_key_exists('slug',$this->vars['blog'])) ? $this->vars['blog']['slug']: ''?>" class="m-wrap span10 slug">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Tags</strong></h3>
                        <p>Appropriately categorize your blog post by single clicking one or more of the following available tags in the list on the left.</p>
                        <p>You can remove tags by just clicking them in the list on the right.</p>
                        <p>If you want to add a tag that's not listed please contact NCDD.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group">
                              <label class="control-label">Available Tags</label>
                              <div class="controls">
                                 <? if($show=='yes'):?>
                                    <select class="tags" multiple="multiple" id="tags" name="doc[tags][]" style="position: absolute; left: -9999px;">
                                       <? 
                                          foreach($this->vars['availableTags'] as $k=>$v): 
                                             $selected = false;
                                             if(!empty($this->vars['blog']) && array_key_exists('tags',$this->vars['blog'])){
                                                if(strpos($this->vars['blog']['tags'],$v) !== false){
                                                   $selected = true;
                                                }
                                             }
                                       ?>

                                       <option <?=($selected) ? ' selected' :'' ?>><?=$v?></option>
                                       <? endforeach; ?>
                                    </select>
                                 <? else: ?>
                                    <?=(!empty($this->vars['blog']) && array_key_exists('tags',$this->vars['blog'])) ? '<h4>'.$this->vars['blog']['tags'].'</h4>' : 'no tags were selected'?>
                                 <? endif; ?>
                              </div>
                           </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Picture (optional)</strong></h3>
                        <p>You can upload a picture to make your blog post more appealing.  From an SEO perspective, blog posts with a picture are much better received by search engines.</p>
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
                        <h3 class="form-section text-info"><strong>Video (optional)</strong> recommended width is 640</h3>
                        <p>If you'd like to write up a blog post about a video you found on the web or a video you published to the web.  It's a great idea for a blog post.
                           <br>Add the embed code for the video here.
                           <br>Be sure it's not just the link to the video, but the embedded video player instead.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <textarea <?=($show=='no') ? 'readonly=""' : ''?> name="doc[video]" class="span6 m-wrap video" rows="3"><?=(!empty($this->vars['blog']) && array_key_exists('video',$this->vars['blog'])) ? $this->vars['blog']['video']: ''?></textarea>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Link (optional)</strong></h3>
                        <p>If you'd like to write up a blog post about an article you found on the web or one that you published.  It's a great idea for a blog post topic.
                           <br>Add the link to the article here.  Be sure to add the full link including http:// and everything after.
                           <br>By adding the link here it will receive prominent styling on the blog post and will be obvious and clickable.
                           <br>You won't need to add it to the content of the blog post and give it special formatting.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input <?=($show=='no') ? 'readonly=""' : ''?> type="text" name="doc[link]" value="<?=(!empty($this->vars['blog']) && array_key_exists('link',$this->vars['blog'])) ? $this->vars['blog']['link']: ''?>" class="m-wrap span10 link">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Content</strong></h3>&nbsp;<button type="button" class="btn blue show-editor">Click To Edit</button><br><br>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <span id="body" class=""><?=(!empty($this->vars['blog']) && array_key_exists('body',$this->vars['blog'])) ? $this->vars['blog']['body'] : '<br>'?></span>
                                    <input id="input-body" type="hidden" name="doc[body]" value="">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <? if($accessLevel >= EDITOR): ?>
                           <h3 class="form-section text-info"><strong>Schedule for Publishing</strong></h3>
                           <p>This is optional.  You can go ahead and publish it now by clicking the "Publish Now" button below.</p>
                           <div class="row-fluid">
                              <div class="span12 ">
                                 <div class="control-group ">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                       <div class="input-append date " data-date="" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                                          <input placeholder="click to enter date" class="m-wrap m-ctrl-medium date-picker span10 scheduleDate" name="doc[scheduleDate]" readonly="" type="text" value="<?=(!empty($this->vars['blog']) && array_key_exists('scheduleDate',$this->vars['blog']) && is_array($this->vars['blog']['scheduleDate']) && array_key_exists('detail',$this->vars['blog']['scheduleDate'])) ? $this->vars['blog']['scheduleDate']['detail']: ''?>">
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
                              if(!empty($this->vars['blog']) && array_key_exists('author',$this->vars['blog']) && $this->vars['memberId'] == (string)$this->vars['blog']['author']['_id']){
                                 $buttons.=" <button type='button' class='btn red delete'>Delete</button>";
                              }
                              
                              if(!empty($this->vars['blog']) && array_key_exists('currentStatus',$this->vars['blog'])): 
                                 $status = \Saw\Model\Blog::$statusReversed[$this->vars['blog']['currentStatus']];
                                 switch ($status) {
                                    case 'REVIEW':
                                       if($accessLevel == MEMBER){
                                          $buttons = "<button type='button' class='btn green save-draft'><i class='icon-pencil'></i> Save and take out of the approval queue.</button>
                                                      <button type='button' class='btn yellow save'><i class='icon-ok'></i> Save and leave in the approval queue.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>";

                                          if(!empty($this->vars['blog']) && array_key_exists('author',$this->vars['blog']) && $this->vars['memberId'] == (string)$this->vars['blog']['author']['_id']){
                                             $buttons.=" <button type='button' class='btn red delete'>Delete</button>";
                                          }
                                       } else if ($accessLevel >= EDITOR){
                                          $buttons = "<button type='button' class='btn green publish'><i class='icon-ok'></i> Publish now.</button>
                                                      <button type='button' class='btn yellow schedule'><i class='icon-pencil'></i> Schedule for publishing.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>
                                                      <button type='button' class='btn red delete'>Delete</button>";
                                       }
                                       break;
                                    case 'SCHEDULE':
                                       if ($accessLevel >= EDITOR){
                                          $buttons = "<button type='button' class='btn green save'><i class='icon-pencil'></i> Save </button>
                                                      <button type='button' class='btn yellow review'><i class='icon-ok'></i> Save and remove from publishing schedule.</button>
                                                      <button type='button' class='btn cancel'>Cancel</button>
                                                      <button type='button' class='btn red delete'>Delete</button>";
                                          break;
                                       }else{
                                          $buttons = '';
                                       }
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
                              <button class="btn blue all-posts">Go to All Blog Posts</button>
                           <? else: ?>
                              <button class="btn blue my-posts">Go to My Blog Posts</button>
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
                           <p>Are you sure you want to delete this blog post?  Deleting will purge the entire blog post including all photos and comments.  This operation cannot be undone.</p>
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
         <?=$this->element('js/Blog.js');?>
         <?=$this->element('js/ClearField.js');?>

         <script>
         jQuery(document).ready(function() {    
            io.saw.Blog.init();
            io.saw.ClearField.init({formArr:['#saw-form']});

            <? if ($show == 'yes'): ?>
               $('#tags').multiSelect();
               if (jQuery().datepicker) {
                  $('.date-picker').datepicker({
                     rtl : App.isRTL()
                  });
               }
               
               window.editor = new SnapEditor.InPlace("body", {
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
                     /*
                     ,onSave: function (e) {
                        var isSuccess = true;
                        html = e.html;
                        io.saw.Blog.save();
                        return isSuccess || "Error";
                     }
                     ,onUnsavedChanges: function (e) {
                        e.api.execAction("save");
                    }*/
               });
               $('.show-editor').click(function(e){
                  window.editor.api.activate();
               })
          <? endif; ?>
           
         });
            
         </script>

