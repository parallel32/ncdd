
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
                  <!-- REVIEW BLOG POSTS -->
                  <div id="recent-review" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red">
                           <div class="portlet-title" id="draft">
                              <div class="caption"><i class="icon-edit"></i>DUI Blog Posts To Approve</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="reviews" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Headline</th>
                                       <th class="">Author</th>
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
                                       <td class=" "><?=$blog['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$blog['reviewDate']['shortTime'].'  '.$blog['reviewDate']['monthDay']?></td>
                                       <td class="hidden-480 "><?=$blog['currentType']?></td>
                                       <td class="hidden-480 "><?=$blog['currentStatus']?></td>
                                       <td class=" "><a data-blog-id="<?=$blog['_id']?>" data-member-id="<?=$blog['author']['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
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

                  <!-- SCHEDULED BLOG POSTS -->
                  <div id="recent-scheduled" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box yellow">
                           <div class="portlet-title" id="scheduled">
                              <div class="caption"><i class="icon-edit"></i>Posts scheduled for publising</div>
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
                                    <? if(!empty($this->vars['scheduled'])): foreach($this->vars['scheduled'] as $blog): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$blog['headline']?></td>
                                       <td class=" "><?=$blog['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$blog['scheduleDate']['monthDay']?></td>
                                       <td class="hidden-480 "><?=$blog['currentType']?></td>
                                       <td class="hidden-480 "><?=$blog['currentStatus']?></td>
                                       <td class=" "><a data-blog-id="<?=$blog['_id']?>" data-member-id="<?=$blog['author']['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
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
                  <!--/ SCHEDULED BLOG POSTS -->

                  <!-- PUBLSIHED BLOG POSTS -->
                  <div id="recent-published" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box green">
                           <div class="portlet-title" id="published">
                              <div class="caption"><i class="icon-edit"></i>Posts that are published.</div>
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
                                    <? if(!empty($this->vars['published'])): foreach($this->vars['published'] as $blog): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$blog['headline']?></td>
                                       <td class=" "><?=$blog['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$blog['publishDate']['shortTime'].'  '.$blog['publishDate']['monthDay'];?></td>
                                       <td class="hidden-480 "><?=$blog['currentType']?></td>
                                       <td class="hidden-480 "><?=$blog['currentStatus']?></td>
                                       <td class=" "><a data-blog-id="<?=$blog['_id']?>" data-member-id="<?=$blog['author']['_id']?>" class="btn blue mini edit"><i class=" "></i> Edit</a> <a href="/blog/<?=$blog['_id']?>/view" data-id="" class="btn blue mini view"><i class=" "></i> View</a></td>
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
                  <!--/ PUBLISHED BLOG POSTS -->

                  <!-- UNPUBLSIHED BLOG POSTS -->
                  <div id="recent-unpublished" class="row-fluid">
                     <div class="span12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box grey">
                           <div class="portlet-title" id="unpublished">
                              <div class="caption"><i class="icon-edit"></i>Posts that are unpublished.</div>
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
                                    <? if(!empty($this->vars['unpublished'])): foreach($this->vars['unpublished'] as $blog): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$blog['headline']?></td>
                                       <td class=" "><?=$blog['author']['displayName']?></td>
                                       <td class="hidden-480 "><?=$blog['unpublishDate']['shortTime'].'  '.$blog['unpublishDate']['monthDay'];?></td>
                                       <td class="hidden-480 "><?=$blog['currentType']?></td>
                                       <td class="hidden-480 "><?=$blog['currentStatus']?></td>
                                       <td class=" "><a data-blog-id="<?=$blog['_id']?>" data-member-id="<?=$blog['author']['_id']?>" class="btn blue mini edit"><i class=" icon-pencil"></i> Edit</a></td>
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
                  <!--/ UNPUBLISHED BLOG POSTS -->
               </div>
            </div>
            
            <!-- END PAGE CONTENT-->

         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
      <script>
         jQuery(document).ready(function() {    
            $('.edit').click(function(e){
               document.location.href='/blog/'+$(this).attr('data-member-id')+'/edit/'+$(this).attr('data-blog-id');  
            });
            
         });
      </script>