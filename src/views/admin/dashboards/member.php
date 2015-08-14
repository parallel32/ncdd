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

            <? if(array_key_exists('seminar_deposit_notices',$this->vars) && !empty($this->vars['seminar_deposit_notices'])): ?>
               <? if(is_array($this->vars['seminar_deposit_notices']) && count($this->vars['seminar_deposit_notices']) > 0):?>

                  <div class="row-fluid">
                     <div class="span12">
                        <a name="submitted"></a>
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red">
                           <div class="portlet-title" id="registration">
                              <div class="caption"><i class="icon-facetime-video"></i>Your Seminar Registrations At A Glance</div>
                           </div>
                           <div class="portlet-body">
                              <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                              <table class="table table-striped table-bordered table-hover dataTable" id="registrations" aria-describedby="sample_1_info">
                                 <thead>
                                    <tr role="row">
                                       <th class="">Seminar</th>
                                       <th class="hidden-phone">Starts On</th>
                                       <th class="hidden-480">Registered On</th>
                                       <th class="hidden-480">Method of Payment</th>
                                       <th class="hidden-480">Status</th>
                                       <th class=""></th>
                                    </tr>
                                 </thead>
                                 <tbody role="alert" aria-live="polite" aria-relevant="all">

                                 <? foreach ($this->vars['seminar_deposit_notices'] as $notice): ?>
                                    <tr class="gradeX odd">
                                       <td class=" "><?=$notice['seminar']['headline']?></td>
                                       <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($notice['seminar']['startDate']['fullDateTime'])); ?>
                                       <td class="hidden-phone"><b><?=$human->diffForHumans()?></b><br><?=$notice['seminar']['startDate']['monthDay'].' '.$notice['seminar']['startDate']['shortTime']?></td>
                                       <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($notice['registration']['submittedDate']['fullDateTime'])); ?>
                                       <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$notice['registration']['submittedDate']['monthDay'].' '.$notice['registration']['submittedDate']['shortTime']?></td>
                                       <? $payment_type = \Saw\Model\Registration::$paymentTypeReversed[$notice['registration']['currentPaymentType']]; ?>
                                       <td class="center hidden-480 "><?=$payment_type;?></td>
                                       <?
                                       $status = 'Please contact NCDD.';
                                       $is_deposit = false;
                                       switch (\Saw\Model\Registration::$statusReversed[$notice['registration']['currentStatus']]) {
                                          case 'DEPOSIT':
                                          case 'DEPOSITBALANCE':
                                             if(
                                                   !empty($notice['registration']['paymentId']) 
                                                   || (
                                                         array_key_exists('depositPaymentId', $notice['registration']) 
                                                         && !empty($notice['registration']['depositPaymentId'])
                                                      )
                                                 
                                             ) {
                                                $status = 'Deposit Received. Awaiting Balance Payment.';
                                             }else{
                                                $status = 'Deposit Payment Not Yet Received.';
                                             }
                                             $is_deposit = true;
                                             break;
                                          case 'SUBMITTED':
                                             $status = 'Your registration has been received.';
                                             break;
                                          case 'WAITLIST':
                                             $status = 'You are on the wait list.';
                                             break;
                                          case 'SCHOLARSHIP':
                                             $status = 'We have received your scholarship request';
                                             break;
                                       }

                                       ?>
                                       <td class="center hidden-480 "><?=$status?></td>
                                       <td class=" ">
                                          <? if($is_deposit):?>
                                          <a href="/registration/seminar/<?=$notice['seminar']['_id']?>/<?=$notice['seminar']['slug']?>" class="btn blue view registration"><i class=" "></i> Pay Balance Here</a>
                                          <? endif; ?>
                                       </td>
                                    </tr>
                                 <? endforeach; ?>

                                 </tbody>
                              </table>
                           </div>
                        </div><a name="deposits"></a>
                        <!-- END EXAMPLE TABLE PORTLET-->
                     </div>
                  </div>

               <? endif; ?>
            <? endif; ?>

            <? if(array_key_exists('renewal',$this->vars)): ?>
               <? if(!empty($this->vars['renewal']) && $this->vars['renewal']['currentStatus'] < \Saw\Model\Renewal::$status['SUBMITTED']): ?>
                  <h3 class="form-section alert alert-error">Please prepare your membership <?=(\Saw\Model\Member::$membership['GENERAL MEMBER'] == $this->vars['currentMembership']) ? 'renewal form': 'update form';?></h3>
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
                  <span><a data-apptype="<?=$apptype?>" data-id="<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>" class="btn green large renewal"><i class=" icon-pencil"></i> Click Here to Submit Your Renewal Form.</a></span>
                  <br><br>

               <? elseif (!empty($this->vars['renewal']) && $this->vars['renewal']['currentStatus'] == \Saw\Model\Renewal::$status['SUBMITTED']): ?>
                  <h3 class="form-section alert alert-warning">Your membership <?=(\Saw\Model\Member::$membership['GENERAL MEMBER'] == $this->vars['currentMembership']) ? 'renewal form': 'update form';?> has been submitted and is awaiting approval.</h3>
                  <br><br>
               <? elseif (!empty($this->vars['renewal']) && $this->vars['renewal']['currentStatus'] == \Saw\Model\Renewal::$status['APPROVED'] && $this->vars['currentMembership'] > \Saw\Model\Member::$membership['GENERAL MEMBER']): ?>
                  <h3 class="form-section alert alert-success">Your membership <?=(\Saw\Model\Member::$membership['GENERAL MEMBER'] == $this->vars['currentMembership']) ? 'renewal form': 'update form';?> has been approved and your renewal process is complete.</h3>
                  <br><br>
               <? elseif (!empty($this->vars['renewal']) && $this->vars['renewal']['currentStatus'] == \Saw\Model\Renewal::$status['PAID']): ?>
                  <h3 class="form-section alert alert-success">Your membership <?=(\Saw\Model\Member::$membership['GENERAL MEMBER'] == $this->vars['currentMembership']) ? 'renewal form': 'update form';?> has been paid and your <b>membership renewal</b> process is <b>complete</b>.  We thank you for your continued membership with us.</h3>
                  <br><br>
               <? endif; ?>
            <? endif; ?>

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
               <? if($this->app['renewal_card_decline']()): ?>
               <div id="approved-applications" class="row-fluid">
                  <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE PORTLET-->
                     <div class="portlet box red">
                        <div class="portlet-title" id="application">
                           <div class="caption"><i class="icon-user"></i>Your credit card has been <b>declined</b>.  Please check the information we have on file for you.</div>
                        </div>
                        <div class="portlet-body">
                           <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                           <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                              <thead>
                                 <tr role="row">
                                    <th class=""></th>
                                 </tr>
                              </thead>
                              <tbody role="alert" aria-live="polite" aria-relevant="all">
                                 <tr class="gradeX odd">
                                    <td class=" "><a class="btn blue" href="/card"><i class="icon-credit-card"></i> Manage your credit card on file. Click here.</a></td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!-- END EXAMPLE TABLE PORTLET-->
                  </div>
               </div>
               <? endif; ?>
               <? if($this->app['renewal_card_expiration_date']()): ?>
               <div id="approved-applications" class="row-fluid">
                  <div class="span12">
                     <!-- BEGIN EXAMPLE TABLE PORTLET-->
                     <div class="portlet box red">
                        <div class="portlet-title" id="application">
                           <div class="caption"><i class="icon-user"></i>Your credit card has either <b>expired</b> will expire soon.  Please check the information we have on file for you.</div>
                        </div>
                        <div class="portlet-body">
                           <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                           <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                              <thead>
                                 <tr role="row">
                                    <th class=""></th>
                                 </tr>
                              </thead>
                              <tbody role="alert" aria-live="polite" aria-relevant="all">
                                 <tr class="gradeX odd">
                                    <td class=" "><a class="btn blue" href="/card"><i class="icon-credit-card"></i> Manage your credit card on file. Click here.</a></td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!-- END EXAMPLE TABLE PORTLET-->
                  </div>
               </div>
               <? endif; ?>

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
                                    <th class=""></th>
                                 </tr>
                              </thead>
                              <tbody role="alert" aria-live="polite" aria-relevant="all">
                                 <? if(!empty($this->vars['applications'])): foreach($this->vars['applications'] as $application): ?>
                                 <tr class="gradeX odd">
                                    <td class="hidden-480 "><?=$application['approvedDate']['monthDay'].' '.$application['approvedDate']['shortTime']?></td>
                                    <td class=" "><a data-id="<?=$application['_id']?>" class="btn blue pay"><i class=" "></i> Pay Membership Dues</a></td>
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

            <? if(!$this->app['renewal_payment_failure']()):?>
               <!--/ APPROVED APPLICATIONS -->
            <? if(false):?>
            <div class="row-fluid">
               <div class="span12">
                  <a class="btn blue" href="/card"><i class="icon-credit-card"></i> Manage your credit card on file. Click here.</a>
               </div>
            </div>
            <? endif; ?>

            <div class="row-fluid">
               <div class="span12">
                  &nbsp;
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  <div class="span12">
                     <h3>Please watch this video tutorial on how to utilize the Virtual Forensic Library.</h3>
                     <iframe width="640" height="480" src="//www.youtube.com/embed/OvM3pPAWJ9Q?rel=0" frameborder="0" allowfullscreen></iframe>
                  </div>
               </div>
            </div>

            <div id="approved-applications" class="row-fluid">
               <div class="span12">
<h3 class="form-section">Rules regarding the content of NCDD  member profiles:  </h3>

<p>NCDD kindly asks that you follow these guidelines when authoring your biography: </p>

<p>The profiles of NCDD members are intended to provide the public with objective and verifiable data regarding the lawyer.  A lawyer shall not make a false or misleading communication about the lawyer or the lawyer's services. Any profile is prohibited if it</p>

<p>(a) contains a material misrepresentation of fact or law, or omits a fact necessary to make the statement considered as a whole not materially misleading;</p>

<p>(b) is likely to create an unjustified expectation about results the lawyer can achieve, or states or implies that the lawyer can achieve results by means that violate these Rules or other law; or</p>

<p>(c) compares the lawyer's services with other lawyers' services, unless the comparison can be factually substantiated.</p>

<p>(d) uses opinions, superlatives or other terms of self-aggrandizement. For example, it would be improper to describe oneself as the 'top' or 'best' or 'most highly qualified' or 'expert' attorney in any manner, except when identifying certificates, awards or recognitions issued to him or her by an agency or organization recognized by NCDD. If such terms are used to identify any certificates, awards or recognitions issued by any agency, governmental or private, or by any group, organization or association, the reference must be truthful and verifiable and may not be misleading.</p>
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


               
               

               <? if(!empty($this->vars['delegate'])): ?>
               <h3 class="form-section">Manage Your State Delegate Page</h3>
               <span><a href="/delegate/edit/<?=$this->vars['delegate']['_id']?>" class="btn blue large edit-profile"><i class=" icon-pencil"></i> Manage <?=$this->vars['delegate']['state']?></a></span>
               <br><br>
               <? endif; ?>
               <h3 class="form-section">Profile Information</h3>
               <span><a data-id="<?=call_user_func(function($app){ $user = $app['session']->get('user'); return $user['user_id'];},$this->app);?>" class="btn blue large edit-profile"><i class=" icon-pencil"></i> Edit Your Profile</a></span>
               <br><br>
               <?if($this->vars['trial_member'] == 'no'): ?>
               <h3 class="form-section">Website Badges</h3>
               <div class="row-fluid">
                  <div class="span6 ">
                     <div class="control-group ">
                        <label class="control-label">Member Status</label>
                        <div class="controls">
                           <img width="152" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/member">
                           <? if($this->vars['member']['boardCertified']): ?>
                              &nbsp;&nbsp;<img width="200" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/boardcertified">
                           <? endif; ?>
                           <? if(array_key_exists('boardCertifiedSr', $this->vars['member']) && $this->vars['member']['boardCertifiedSr']): ?>
                              &nbsp;&nbsp;<img width="200" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/boardcertified">
                           <? endif; ?>
                           <? if(array_key_exists('staff',$this->vars['member']) && $this->vars['member']['staff']): ?>
                              &nbsp;&nbsp;<img width="152" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/staff">
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
                           <? if($this->vars['member']['currentFacultyPosition'] == \Saw\Model\Member::$facultyPosition['DELEGATE']):?>
                           <img width="152" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/exec">
                           <? else: ?>
                           <img src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/exec">
                           <? endif; ?>
                           
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
                           <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="152" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/member" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
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
                           <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="200" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                        </div>
                     </div>
                  </div>
                  <!--/span-->
               </div>
               <? endif; ?>
               <? if(array_key_exists('boardCertifiedSr', $this->vars['member']) && $this->vars['member']['boardCertifiedSr']): ?>
               <div class="row-fluid">
                  <div class="span6 ">
                     <div class="control-group ">
                        <label class="control-label">Board Certified Sr Badge for your website:</label>
                        <div class="controls">
                           <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="200" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/boardcertified" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                        </div>
                     </div>
                  </div>
                  <!--/span-->
               </div>
               <? endif; ?>
               <? if(array_key_exists('staff',$this->vars['member']) && $this->vars['member']['staff']): ?>
               <div class="row-fluid">
                  <div class="span6 ">
                     <div class="control-group ">
                        <label class="control-label">Faculty Badge for your website:</label>
                        <div class="controls">
                           <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="152" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/staff" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                        </div>
                     </div>
                  </div>
                  <!--/span-->
               </div>
               <? endif; ?>
               
               <? if(!empty($this->vars['delegate'])): ?>
               <div class="row-fluid">
                  <div class="span6 ">
                     <div class="control-group ">
                        <label class="control-label">State Delegate for your website:</label>
                        <div class="controls">
                           <textarea rows="3" class="span8"><a target="_blank" href="https://<?=SAW_CONSUMER_WEBSITE?>/member/<?=$this->vars['member']['_id']?>/<?=$this->vars['member']['slug']?>"><img width="152" src="https://<?=SAW_CONSUMER_WEBSITE?>/badge/<?=$this->vars['member']['_id']?>/delegate" alt="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" title="NCDD National College for DUI Defense: <?=$this->vars['member']['firstName']?><?=(array_key_exists('middleName',$this->vars['member']) && !empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' ';?><?=$this->vars['member']['lastName']?>" /></a></textarea>
                        </div>
                     </div>
                  </div>
                  <!--/span-->
               </div>
               <? endif; ?>
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
         <? endif; // renewal_payment_failure ?>
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