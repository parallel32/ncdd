
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
                  <div id="forums" class="row-fluid">
                     <div class="span12">
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
                                       <td colspan="5">No forum posts.</td>
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
                  <!-- REVIEW TOPIC POSTS -->
                  <div id="recent-review" class="row-fluid">
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
                                       <th class="">Forum</th>
                                       <th class="">Topic</th>
                                       <th class="">Author</th>
                                       <th class="hidden-480">Submitted for Review On</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['reviews'])): foreach($this->vars['reviews'] as $forum): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$forum['headline']?></td>
                                       <td class=" "><?=$forum['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$forum['reviewDate']['shortTime'].'  '.$forum['reviewDate']['monthDay']?></td>
                                       <td class="hidden-480 "><?=$forum['currentType']?></td>
                                       <td class="hidden-480 "><?=$forum['currentStatus']?></td>
                                       <td class=" "><a data-forum-id="<?=$forum['_id']?>" data-member-id="<?=$forum['author']['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
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
                                       <th class="">Headline</th>
                                       <th class="">Author</th>
                                       <th class="hidden-480">Scheduled to Post On</th>
                                       <th class="hidden-480">Type</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <? if(!empty($this->vars['scheduled'])): foreach($this->vars['scheduled'] as $forum): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$forum['headline']?></td>
                                       <td class=" "><?=$forum['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$forum['scheduleDate']['monthDay']?></td>
                                       <td class="hidden-480 "><?=$forum['currentType']?></td>
                                       <td class="hidden-480 "><?=$forum['currentStatus']?></td>
                                       <td class=" "><a data-forum-id="<?=$forum['_id']?>" data-member-id="<?=$forum['author']['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
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
                                    <? if(!empty($this->vars['published'])): foreach($this->vars['published'] as $forum): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$forum['headline']?></td>
                                       <td class=" "><?=$forum['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$forum['publishDate']['shortTime'].'  '.$forum['publishDate']['monthDay'];?></td>
                                       <td class="hidden-480 "><?=$forum['currentType']?></td>
                                       <td class="hidden-480 "><?=$forum['currentStatus']?></td>
                                       <td class=" "><a data-forum-id="<?=$forum['_id']?>" data-member-id="<?=$forum['author']['_id']?>" class="btn blue mini edit"><i class=" "></i> Edit</a> <a href="/forum/<?=$forum['_id']?>/view" data-id="" class="btn blue mini view"><i class=" "></i> View</a></td>
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
                                    <? if(!empty($this->vars['unpublished'])): foreach($this->vars['unpublished'] as $forum): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$forum['headline']?></td>
                                       <td class=" "><?=$forum['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$forum['unpublishDate']['shortTime'].'  '.$forum['unpublishDate']['monthDay'];?></td>
                                       <td class="hidden-480 "><?=$forum['currentType']?></td>
                                       <td class="hidden-480 "><?=$forum['currentStatus']?></td>
                                       <td class=" "><a data-forum-id="<?=$forum['_id']?>" data-member-id="<?=$forum['author']['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
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
            $('#forums .edit').click(function(e){
               document.location.href='/forum/edit/'+$(this).attr('data-forum-id');  
            });
            
         });
      </script>