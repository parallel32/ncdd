
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
                  <!-- FORUMS -->
                  <div class="row-fluid">
                     <div id="forums" class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box blue">
                           <div class="portlet-title" id="draft">
                              <div class="caption"><i class="icon-edit"></i>DUI Forums</div>
                              <div class="actions">
                                 <a class="btn green add-forum"><i class=" icon-plus"></i> Add a New Forum</a>
                              </div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="reviews" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Forum</th>
                                       <th class="">Author</th>
                                       <th class="hidden-480">Topics</th>
                                       <th class="hidden-480">Comments</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['forums'])): foreach($this->vars['forums'] as $forum): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$forum['name']?></td>
                                       <td class=" "><?=(array_key_exists('owner',$forum) && !empty($forum['owner'])) ? $forum['owner']['displayName'] : 'Admin'?></td>
                                       <td class="hidden-480 "><?=$forum['topicCount']?></td>
                                       <td class="hidden-480 "><?=$forum['commentCount']?></td>
                                       <?
                                          switch ($forum['currentStatus']) {
                                             case 'PUBLISH':
                                                $currentStatus = '<span class="label label-success">'.$forum['currentStatus'].'</span>';
                                                break;
                                             case 'UNPUBLISH':
                                                $currentStatus = '<span class="label label-inverse">'.$forum['currentStatus'].'</span>';
                                                break;
                                             case 'DRAFT':
                                                $currentStatus = '<span class="label label-important">'.$forum['currentStatus'].'</span>';
                                                break;
                                             case 'REVIEW':
                                                $currentStatus = '<span class="label label-warning">'.$forum['currentStatus'].'</span>';
                                                break;
                                          }
                                       ?>
                                       <td class="hidden-480 "><?=$currentStatus?></td>
                                       <td class=" "><a data-forum-id="<?=$forum['_id']?>" data-member-id="" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a> <a href="/forum/<?=$forum['_id']?>/view" data-id="" class="btn blue mini view"><i class=" "></i> View</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No topics.</td>
                                    <? endif;?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <br><br>
                  <!--/ FORUMS -->
                  <!-- DRAFT BLOG POSTS -->
                  <div id="recent-drafts" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red">
                           <div class="portlet-title" id="draft">
                              <div class="caption"><i class="icon-edit"></i>Your Topic Drafts</div>
                              <div class="actions">
                                 <a href="" class="btn green draft-post" data-id="<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>"><i class="icon-plus"></i> Draft a New Topic</a>
                              </div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="drafts" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Topic</th>
                                       <th class="hidden-480">Forum</th>
                                       <th class="hidden-480">Last Edited On</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['drafts'])): foreach($this->vars['drafts'] as $topic): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$topic['headline']?></td>
                                       <td class="hidden-480 "><?=$topic['forum']['name']?></td>
                                       <td class="hidden-480 "><?=$topic['draftDate']['shortTime'].'  '.$topic['draftDate']['monthDay']?></td>
                                       <td class="hidden-480 "><?=$topic['currentStatus']?></td>
                                       <td class=" "><a data-id="<?=$topic['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No topics.</td>
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

                  <!-- REVIEW TOPIC POSTS -->
                  <div id="recent-reviews" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red">
                           <div class="portlet-title" id="draft">
                              <div class="caption"><i class="icon-edit"></i>Topics To Approve</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="reviews" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Topic</th>
                                       <th class="">Forum</th>
                                       <th class="">Author</th>
                                       <th class="hidden-480">Submitted for Review On</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['reviews'])): foreach($this->vars['reviews'] as $topic): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$topic['headline']?></td>
                                       <td class=" "><?=$topic['forum']['name']?></td>
                                       <td class=" "><?=$topic['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$topic['reviewDate']['shortTime'].'  '.$topic['reviewDate']['monthDay']?></td>
                                       <td class="hidden-480 "><?=$topic['currentStatus']?></td>
                                       <td class=" "><a data-id="<?=$topic['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No topics.</td>
                                    <? endif;?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <br><br>
                  <!--/ REVIEW TOPIC POSTS -->

                  <!-- SCHEDULED TOPIC POSTS -->
                  <div id="recent-scheduled" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box yellow">
                           <div class="portlet-title" id="scheduled">
                              <div class="caption"><i class="icon-edit"></i>Topics scheduled for publising</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="scheduleds" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Topic</th>
                                       <th class="">Forum</th>
                                       <th class="">Author</th>
                                       <th class="hidden-480">Scheduled to Post On</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['scheduled'])): foreach($this->vars['scheduled'] as $topic): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$topic['headline']?></td>
                                       <td class=" "><?=$topic['forum']['name']?></td>
                                       <td class=" "><?=$topic['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$topic['scheduleDate']['shortTime'].'  '.$topic['scheduleDate']['monthDay']?></td>
                                       <td class="hidden-480 "><?=$topic['currentStatus']?></td>
                                       <td class=" "><a data-id="<?=$topic['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No topics.</td>
                                    <? endif;?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <br><br>
                  <!--/ SCHEDULED TOPIC POSTS -->

                  <!-- PUBLSIHED TOPIC POSTS -->
                  <div id="recent-published" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box green">
                           <div class="portlet-title" id="published">
                              <div class="caption"><i class="icon-edit"></i>Topics that are published.</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="publisheds" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Headline</th>
                                       <th class="">Author</th>
                                       <th class="hidden-480">Published On</th>
                                       <th class="hidden-480">Type</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['published'])): foreach($this->vars['published'] as $topic): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$topic['headline']?></td>
                                       <td class=" "><?=$topic['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$topic['publishDate']['shortTime'].'  '.$topic['publishDate']['monthDay'];?></td>
                                       <td class="hidden-480 "><?=$topic['currentType']?></td>
                                       <td class="hidden-480 "><?=$topic['currentStatus']?></td>
                                       <td class=" "><a data-id="<?=$topic['_id']?>" class="btn blue mini edit"><i class=" "></i> Edit</a> <a href="/forum/<?=$topic['_id']?>/view" data-id="" class="btn blue mini view"><i class=" "></i> View</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No topics.</td>
                                    <? endif;?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <br><br>
                  <!--/ PUBLISHED TOPIC POSTS -->

                  <!-- UNPUBLSIHED TOPIC POSTS -->
                  <div id="recent-unpublished" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box grey">
                           <div class="portlet-title" id="unpublished">
                              <div class="caption"><i class="icon-edit"></i>Topics that are unpublished.</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="unpublisheds" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Headline</th>
                                       <th class="">Author</th>
                                       <th class="hidden-480">Published On</th>
                                       <th class="hidden-480">Type</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['unpublished'])): foreach($this->vars['unpublished'] as $topic): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$topic['headline']?></td>
                                       <td class=" "><?=$topic['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$topic['unpublishDate']['shortTime'].'  '.$topic['unpublishDate']['monthDay'];?></td>
                                       <td class="hidden-480 "><?=$topic['currentType']?></td>
                                       <td class="hidden-480 "><?=$topic['currentStatus']?></td>
                                       <td class=" "><a data-id="<?=$topic['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
                                    </tr>
                                    <? endforeach;?>
                                    <? else: ?>
                                       <td colspan="5">No topics.</td>
                                    <? endif;?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>
                  <br><br>
                  <!--/ UNPUBLISHED TOPIC POSTS -->
               </div>
            </div>
            
            <!-- END PAGE CONTENT-->

         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
      <script>
         jQuery(document).ready(function() {    
            $('.add-forum').click(function(e){
               document.location.href='/forum/edit';  
            });
            $('#recent-drafts .draft-post').click(function(e){
               e.preventDefault();
               document.location.href='/topic/edit';    
            });
            $('#recent-drafts .edit').click(function(e){
               document.location.href='/topic/edit/'+$(this).attr('data-id');
            });
            $('#recent-reviews .edit').click(function(e){
               document.location.href='/topic/edit/'+$(this).attr('data-id');
            });
            $('#recent-scheduled .edit').click(function(e){
               document.location.href='/topic/edit/'+$(this).attr('data-id');
            });
            $('#forums .edit').click(function(e){
               document.location.href='/forum/edit/'+$(this).attr('data-forum-id');  
            });
            
            
         });
      </script>