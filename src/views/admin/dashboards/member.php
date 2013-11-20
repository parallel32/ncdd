<?
$accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app); 
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
                  <div id="dashboard">
               <!-- BEGIN DASHBOARD STATS --
               <div class="row-fluid">
                  <div class="span6 responsive" data-tablet="span6" data-desktop="span6">
                     <div class="dashboard-stat blue">
                        <div class="visual">
                           <i class="icon-comments"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              13
                           </div>
                           <div class="desc">                           
                              Clients
                           </div>
                        </div>
                        <a class="more" href="#">
                        View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="span6 responsive" data-tablet="span6" data-desktop="span6">
                     <div class="dashboard-stat yellow">
                        <div class="visual">
                           <i class="icon-bar-chart"></i>
                        </div>
                        <div class="details">
                           <div class="number">33</div>
                           <div class="desc">Domains</div>
                        </div>
                        <a class="more" href="#">
                        View more <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
               </div>
               <!-- END DASHBOARD STATS -->


               <!-- APPROVED APPLICATIONS -->
               <? 
                  $allow = false;
                  if(!empty($this->vars['applications'])): 
                     $allow = true;
                     if(count($this->vars['applications']) == 1){
                        if($this->vars['applications'][0]['class'] == 'UpdateFoundingMember' || $this->vars['applications'][0]['class'] == 'UpdateSustainingMember'){
                           $allow = false;
                        }
                     }
                  endif;
               ?>
               <? if(!empty($this->vars['applications']) && $allow): ?>
               <div id="approved-applications" class="row-fluid">
                  <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE PORTLET-->
                     <div class="portlet box red">
                        <div class="portlet-title" id="application">
                           <div class="caption"><i class="icon-user"></i>Your membership dues can now be paid.  Please do this promptly.</div>
                        </div>
                        <div class="portlet-body">
                           <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                           <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                              <thead>
                                 <tr role="row">
                                    <th class="hidden-480">Date Approved</th>
                                    <th class="hidden-480">Application Type</th>
                                    <th class=""></th>
                                 </tr>
                              </thead>
                              <tbody role="alert" aria-live="polite" aria-relevant="all">
                                 <? if(!empty($this->vars['applications'])): foreach($this->vars['applications'] as $application): ?>
                                 <tr class="gradeX odd">
                                    <td class="hidden-480 "><?=$application['approvedDate']['monthDay'].' '.$application['approvedDate']['shortTime']?></td>
                                    <td class="center hidden-480 "><?=$application['type']?></td>
                                    <td class=" "><a data-id="<?=$application['_id']?>" class="btn blue mini pay"><i class=" "></i> Pay Membership Dues</a></td>
                                 </tr>
                                 <? endforeach;?>
                                 <? else: ?>
                                    <td colspan="5">Nothing to approve.</td>
                                 <? endif;?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!-- END EXAMPLE TABLE PORTLET-->
                  </div>
               </div>
               <? endif; ?>
               <!--/ APPROVED APPLICATIONS -->

               <? if(!empty($this->vars['renewal']) && $this->vars['renewal']['currentStatus'] < \Saw\Model\Renewal::$status['SUBMITTED']): ?>
                  <h3 class="form-section">Prepare your membership <?=(\Saw\Model\Member::$membership['GENERAL MEMBER'] == $this->vars['currentMembership']) ? 'renewal form': 'update form';?></h3>
                  <?
                     switch ($this->vars['currentMembership']) {
                        case \Saw\Model\Member::$membership['GENERAL MEMBER']:
                           $apptype = 'update-member';
                           break;
                        case \Saw\Model\Member::$membership['SUSTAINING MEMBER']:
                           $apptype = 'update-sustaining-member';
                           break;
                        case \Saw\Model\Member::$membership['FOUNDING MEMBER']:
                           $apptype = 'update-founding-member';
                           break;                        
                        default:
                           $apptype = 'update-member';
                           break;
                     }
                  ?>
                  <span><a data-apptype="<?=$apptype?>" data-id="<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>" class="btn green large renewal"><i class=" icon-pencil"></i> Begin</a></span>
                  <br><br>

               <? elseif ($this->vars['renewal']['currentStatus'] == \Saw\Model\Renewal::$status['SUBMITTED']): ?>
                  <h3 class="form-section">Your membership <?=(\Saw\Model\Member::$membership['GENERAL MEMBER'] == $this->vars['currentMembership']) ? 'renewal form': 'update form';?> has been submitted and is awaiting approval.</h3>
                  <br><br>
               <? endif; ?>


               <h3 class="form-section">Profile Information</h3>
               <span><a data-id="<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>" class="btn blue large edit-profile"><i class=" icon-pencil"></i> Edit Your Profile</a></span>
               <br><br>
               <h3 class="form-section">Website Badges</h3>
               <div class="row-fluid">
                  <div class="span6 ">
                     <div class="control-group ">
                        <label class="control-label">Member Status</label>
                        <div class="controls">
                           <img width="152" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/member">
                           <? if($this->vars['member']['boardCertified']): ?>
                              &nbsp;&nbsp;<img width="200" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/boardcertified">
                           <? endif; ?>
                        </div>
                     </div>
                  </div>
                  <!--/span-->
                  <? if($this->vars['member']['currentFacultyPosition'] > 0): ?>
                  <div class="span6 ">
                     <div class="control-group ">
                        <label class="control-label">Executive Status</label>
                        <div class="controls">
                           <img src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/exec">
                        </div>
                     </div>
                  </div>
                  <!--/span-->
                  <? endif; ?>
               </div>
               <div class="row-fluid">
                  <div class="span6 ">
                     <div class="control-group ">
                        <label class="control-label">Membership Badge for your website:</label>
                        <div class="controls">
                           <textarea rows="3" class="span8"><a target="_blank" href="http://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="152" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/member" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                        </div>
                     </div>
                  </div>
                  <!--/span-->
               </div>
               <? if($this->vars['member']['boardCertified']): ?>
               <div class="row-fluid">
                  <div class="span6 ">
                     <div class="control-group ">
                        <label class="control-label">Board Certified Badge for your website:</label>
                        <div class="controls">
                           <textarea rows="3" class="span8"><a target="_blank" href="http://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="200" src="http://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                        </div>
                     </div>
                  </div>
                  <!--/span-->
               </div>
               <? endif; ?>
            <? if($accessLevel >= MEMBER):?>
               <!-- RECENT BLOG POSTS -->
               <? if(!empty($this->vars['blogs'])): ?>
               <div id="recent-blogs" class="row-fluid">
                  <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE PORTLET-->
                     <div class="portlet box blue">
                        <div class="portlet-title" id="blog">
                           <div class="caption"><i class="icon-edit"></i>Recent posts from the DUI Blog</div>
                           <div class="actions">
                              <a href="/blog" class="btn yellow">View All</a>
                              <a href="" class="btn green draft-post" data-id="<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>"><i class="icon-plus"></i> Draft a Blog Post</a>
                           </div>
                        </div>
                        <div class="portlet-body">
                           <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                           <table class="table table-striped table-bordered table-hover dataTable" id="blogs" aria-describedby="sample_1_info">
                              <thead>
                                 <tr role="row">
                                    <th class="">Headline</th>
                                    <th class="hidden-480">Date Published</th>
                                    <th class="hidden-480">Author</th>
                                    <th class=""></th>
                                 </tr>
                              </thead>
                              <tbody role="alert" aria-live="polite" aria-relevant="all">
                                 <? if(!empty($this->vars['blogs'])): foreach($this->vars['blogs'] as $blog): ?>
                                 <tr class="gradeX odd">
                                    <td class=" "><?=$blog['headline']?></td>
                                    <td class="hidden-480 "><?=$blog['publishDate']['shortTime'].' '.$blog['publishDate']['monthDay']?></td>
                                    <td class="hidden-480 "><?=$blog['author']['firstName'].' '.$blog['author']['lastName']?></td>
                                    <td class=" "><a data-id="<?=$blog['_id']?>" class="btn blue mini view"><i class=" "></i> View</a></td>
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
               <? endif; ?>
               <br><br>
               <!--/ RECEN BLOG POSTS -->
               
               <?=$this->element('twitter-feed.html')?>

               <!-- PRIVATE PAGES (RECENT) -->
               <div class="row-fluid">
                  <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE PORTLET-->
                     <div class="portlet box blue">
                        <div class="portlet-title" id="page">
                           <div class="caption"><i class="icon-copy"></i>Private Pages (most recent)</div>
                           <div class="actions">
                              <a id="page-view-all" class="btn yellow view"><i class=" icon-eye-open"></i> View All</a>
                           </div>
                        </div>
                        <div class="portlet-body">
                           <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                           <table class="table table-striped table-bordered table-hover dataTable" id="pages" aria-describedby="sample_1_info">
                              <thead>
                                 <tr role="row">
                                    <th class="">Headline</th>
                                    <th class="">Published</th>
                                    <th class=""></th>
                                 </tr>
                              </thead>
                              <tbody role="alert" aria-live="polite" aria-relevant="all">
                                 <? if(!empty($this->vars['pages'])): foreach($this->vars['pages'] as $page): ?>
                                 <tr class="gradeX odd">
                                    <td class=" "><?=$page['headline']?></td>
                                    <td class=" "><?=date('F j, Y',$page['_id']->getTimestamp())?></td>
                                    <td class=" "><a data-id="<?=$page['slug']?>" class="btn blue mini view"><i class=" "></i> View</a></td>
                                 </tr>
                                 <? endforeach;?>
                                 <? else: ?>
                                    <td colspan="5">No pages at the moment.</td>
                                 <? endif;?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!-- END EXAMPLE TABLE PORTLET-->
                  </div>
               </div>
               <div class="clearfix"></div>
               <!--/ PRIVATE PAGES (RECENT) -->
            <? endif; ?>
            </div>
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<?=$this->element('js/Dashboard.js');?>
<script>
jQuery(document).ready(function() {    
   io.saw.Dashboard.memberInit();
});      
</script>