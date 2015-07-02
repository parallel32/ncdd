
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
                  <!-- DRAFT BLOG POSTS -->
                  <div id="recent-drafts" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red">
                           <div class="portlet-title" id="draft">
                              <div class="caption"><i class="icon-edit"></i>Your drafts for the DUI Blog</div>
                              <div class="actions">
                                 <a href="" class="btn green draft-post" data-id="<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>"><i class="icon-plus"></i> Draft a Blog Post</a>
                                 <!-- VIDEO MODAL -->
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
                              <!--/ VIDEO MODAL -->
                              </div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="drafts" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Headline</th>
                                       <th class="hidden-480">Last Edited On</th>
                                       <th class="hidden-480">Type</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['drafts'])): foreach($this->vars['drafts'] as $blog): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$blog['headline']?></td>
                                       <td class="hidden-480 "><?=$blog['draftDate']['shortTime'].'  '.$blog['draftDate']['monthDay']?></td>
                                       <td class="hidden-480 "><?=$blog['currentType']?></td>
                                       <td class="hidden-480 "><?=$blog['currentStatus']?></td>
                                       <td class=" "><a data-id="<?=$blog['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No blog posts.</td>
                                    <? endif;?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <br><br>
                  <!--/ DRAFT BLOG POSTS -->

                  <!-- REVIEW BLOG POSTS -->
                  <div id="recent-reviews" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box yellow">
                           <div class="portlet-title" id="draft">
                              <div class="caption"><i class="icon-edit"></i>Posts that are waiting review</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="reviews" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Headline</th>
                                       <th class="hidden-480">Submitted for Review On</th>
                                       <th class="hidden-480">Type</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['reviews'])): foreach($this->vars['reviews'] as $blog): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$blog['headline']?></td>
                                       <td class="hidden-480 "><?=$blog['reviewDate']['shortTime'].'  '.$blog['reviewDate']['monthDay']?></td>
                                       <td class="hidden-480 "><?=$blog['currentType']?></td>
                                       <td class="hidden-480 "><?=$blog['currentStatus']?></td>
                                       <!--<td class=" "><a data-id="<?=$blog['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>-->
                                       <td class=" ">&nbsp;</td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No blog posts.</td>
                                    <? endif;?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <br><br>
                  <!--/ REVIEW BLOG POSTS -->

                  <!-- REVIEW BLOG POSTS -->
                  <div id="recent-approved" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box green">
                           <div class="portlet-title" id="draft">
                              <div class="caption"><i class="icon-edit"></i>Posts that are approved.</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="approved" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Headline</th>
                                       <th class="hidden-480">Scheduled for Publishing On</th>
                                       <th class="hidden-480">Type</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['approved'])): foreach($this->vars['approved'] as $blog): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$blog['headline']?></td>
                                       <td class="hidden-480 "><?=(empty($blog['publishDate'])) ? $blog['scheduleDate']['shortTime'].'  '.$blog['scheduleDate']['monthDay'] : $blog['publishDate']['shortTime'].'  '.$blog['publishDate']['monthDay'];?></td>
                                       <td class="hidden-480 "><?=$blog['currentType']?></td>
                                       <td class="hidden-480 "><?=$blog['currentStatus']?></td>
                                       <td class=" "><a href="/blog/<?=$blog['_id']?>/view" data-id="" class="btn blue mini view"><i class=" "></i> View</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No blog posts.</td>
                                    <? endif;?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <br><br>
                  <!--/ REVIEW BLOG POSTS -->
               </div>
            </div>
            
            <!-- END PAGE CONTENT-->

         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
      <script>
         jQuery(document).ready(function() {    
            $('#recent-drafts .draft-post').click(function(e){
               e.preventDefault();
               document.location.href='/blog/'+$(this).attr('data-id')+'/edit';  
            });
            $('#recent-drafts .edit').click(function(e){
               document.location.href='/blog/<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>/edit/'+$(this).attr('data-id');  
            });
            
         });
      </script>