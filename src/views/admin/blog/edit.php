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
                        <input id="currentStatus" type="hidden" name="doc[currentStatus]" value="<?=(array_key_exists('blog',$this->vars)) ? $this->vars['blog']['currentStatus'] : ''?>">
                        <input id="_id" type="hidden" name="doc[_id]" value="<?=(array_key_exists('blog',$this->vars)) ? $this->vars['blog']['_id'] : '' ?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h2>Draft a blog post here.  Save it as a draft or submit it for publishing.</h2>
                        <div class="alert alert-info">
                           <strong>Blog Tip:</strong> 
                           <br>Try and use different pictures for the blog posts.  
                           People will be less likely to read a blog post with the same picture.  
                           In fact, they may think they already read it.  
                           <br>Also, search engines have the ability to identify photos as duplicates.
                        </div>
                        <div class="row-fluid">
                           <div class="span12 ">

                           <table class="table table-hover">
                              <thead>
                                 <tr>
                                    <th colspan="3"><h3>How-To Videos</h3></th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr>
                                    <td><!-- VIDEO MODAL -->
                              <?$modal='video-a';?>
                              <?$modal_title='How to Draft a Blog';?>
                              <?$modal_src='https://www.youtube.com/embed/nuWium_5InI?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                                    <td><!-- VIDEO MODAL -->
                              <?$modal='video-b';?>
                              <?$modal_title='How to Embed a Video';?>
                              <?$modal_src='https://www.youtube.com/embed/uz-m5Z2E_lY?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                                    <td><!-- VIDEO MODAL -->
                              <?$modal='video-c';?>
                              <?$modal_title='How to Embed a Video Link';?>
                              <?$modal_src='https://www.youtube.com/embed/uz-m5Z2E_lY?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                                 </tr>
                                 <tr>
                                    <td><!-- VIDEO MODAL -->
                              <?$modal='video-d';?>
                              <?$modal_title='How to Embed a Website Link';?>
                              <?$modal_src='https://www.youtube.com/embed/uz-m5Z2E_lY?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                                    <td><!-- VIDEO MODAL -->
                              <?$modal='video-e';?>
                              <?$modal_title='How to Embed an Uploaded Photo';?>
                              <?$modal_src='https://www.youtube.com/embed/FxsCon2CR44?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                                    <td><!-- VIDEO MODAL -->
                              <?$modal='video-f';?>
                              <?$modal_title='How to Embed an Uploaded File';?>
                              <?$modal_src='https://www.youtube.com/embed/zvM2sJsw7bE?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                                 </tr>
                                 <tr>
                                    <td><!-- VIDEO MODAL -->
                              <?$modal='video-g';?>
                              <?$modal_title='How to Embed an Virtual Forensic Library File';?>
                              <?$modal_src='https://www.youtube.com/embed/XSSgJ86ZYns?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                                    <td><!-- VIDEO MODAL -->
                              <?$modal='video-h';?>
                              <?$modal_title='How to Add a Main Picture';?>
                              <?$modal_src='https://www.youtube.com/embed/ogpmPdAZTCE?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                                    <td><!-- VIDEO MODAL -->
                              <?$modal='video-i';?>
                              <?$modal_title='How to Sumbit for Publishing';?>
                              <?$modal_src='https://www.youtube.com/embed/Dswq3l6dK18?rel=0';?>
                              <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                              <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                              <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                              <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                                 <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3 id="save-modal-label"><?=$modal_title?></h3>
                                 </div>
                                 <div class="modal-body">
                                    <iframe width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                                 </div>
                              </div>
                              <!--/ VIDEO MODAL --></td>
                                 </tr>
                              </tbody>
                           </table>
                              
                              
                              
                              

                           </div>
                        </div>
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
                                             if(is_array($this->vars['blog']['tags'])) {
                                                
                                                foreach($this->vars['blog']['tags'] as $tag):
                                                   
                                                   if(strpos($tag['name'],$v['name']) !== false){

                                                      $selected = true;   
                                                   }
                                                endforeach;
                                             }elseif (is_string($this->vars['blog']['tags'])){
                                                if(strpos($this->vars['blog']['tags'],$v) !== false){
                                                   $selected = true;
                                                }
                                             }
                                          }
                                       ?>
                                       <option <?=($selected) ? ' selected' :'' ?> value="<?=$k?>"><?=$v['name']?></option>
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
                        <?
                        /**
                           todo 
                        */
                        ?>
                        <h3 class="form-section text-info"><strong>Content</strong>&nbsp;&nbsp;&nbsp;<a class="btn blue" href="javascript:tinymce.activeEditor.focus();">Click to Edit</a>
                        <!-- VIDEO MODAL -->
                           <?$modal='video-content';?>
                           <?$modal_title='Editor How-To\'s';?>
                           <?$modal_src='https://www.youtube.com/embed/_eZZkPhkIME?rel=0';?>
                           <style>.modal.video {width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */ }</style>
                           <a id="<?=$modal?>" class="btn purple"><i class="icon-youtube-play"></i> <?=$modal_title?></a>
                           <script>$('#<?=$modal?>').click(function(e){$('#<?=$modal?>-modal').modal({keyboard: false});});</script>
                           <div id="<?=$modal?>-modal" class="modal hide fade video" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                              <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                 <h3 id="save-modal-label"><?=$modal_title?></h3>
                              </div>
                              <div class="modal-body">
                                 <script>
                                    jQuery(document).ready(function() {    
                                       $('#embed-video').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/_eZZkPhkIME?rel=0');
                                       });
                                       $('#embed-video-link').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/f_rt_YnNjGs?rel=0');
                                       });
                                       $('#embed-website-link').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/-ZOlUA4hOlw?rel=0');
                                       });
                                       $('#embed-photo').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/NpBs85diwS4?rel=0');
                                       });
                                       $('#embed-file').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/0jIi7jF-4aM?rel=0');
                                       });
                                       $('#embed-vfl').click(function(e){
                                          $('#howto-frame').attr('src','https://www.youtube.com/embed/bjfYaF4Dt-Q?rel=0');
                                       });

                                    });      
                                 </script>
                                 <table class="table table-hover">
                                 <tbody>
                                    <tr>
                                       <td><a id="embed-video" class="btn purple"><i class="icon-youtube-play"></i> Embed Video</a></td>
                                       <td><a id="embed-video-link" class="btn purple"><i class="icon-youtube-play"></i> Embed Video Link</a></td>
                                       <td><a id="embed-website-link" class="btn purple"><i class="icon-youtube-play"></i> Embed Website Link</a></td>
                                    </tr>
                                    <tr>
                                       <td><a id="embed-photo" class="btn purple"><i class="icon-youtube-play"></i> Embed Photo</a></td>
                                       <td><a id="embed-file" class="btn purple"><i class="icon-youtube-play"></i> Embed File</a></td>
                                       <td><a id="embed-vfl" class="btn purple"><i class="icon-youtube-play"></i> Embed Virtual Library Link</a></td>
                                    </tr>
                                 </tbody>
                                 </table>
                                 <iframe id="howto-frame" width="100%" height="720" src="<?=$modal_src?>" frameborder="0" allowfullscreen></iframe>
                              </div>
                           </div>
                           <!--/ VIDEO MODAL --></h3>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                           <style>div.editable {margin: 0px 0px 0px 0px;padding: 5px 50px 5px 5px;} div.editable p {margin: 0px 0px 0px 0px;}</style>
                           <div id="body" class="span12 editable" style="margin-left:0px;">
                              <?=(!empty($this->vars['blog']) && array_key_exists('body',$this->vars['blog'])) ? $this->vars['blog']['body'] : ''?>
                           </div>
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
               $( "#saw-form .scheduleDate" ).datepicker();
            <? endif; ?>            
         });
         </script>
         <? if ($show == 'yes'): ?>
         <?/**
            TODO
         */?>
         <? $id = (array_key_exists('blog',$this->vars)) ? $this->vars['blog']['_id'] : '' ?>
         <?=$this->element('editor',array('_id'=>$id,'client_id'=>$this->vars['client_id'],'access_token'=>$this->vars['access_token']));?>
         <? endif; ?>