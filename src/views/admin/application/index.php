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
            
            <div class="alert alert-info">
               <strong>New Member App -</strong> <a href="https://<?=SAW_ADMIN_WEBSITE?>/application/new-member">https://<?=SAW_ADMIN_WEBSITE?>/application/new-member</a>
            </div>
            <div class="alert alert-info">
               <strong>New Sustaining Member App -</strong> <a href="https://<?=SAW_ADMIN_WEBSITE?>/application/new-sustaining-member">https://<?=SAW_ADMIN_WEBSITE?>/application/new-sustaining-member</a>
            </div>

            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat yellow">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['approved'])) ? count($this->vars['approved']): 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>Unpaid</font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#unpaid"><font><font>
                     Click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <a name="approve"></a>
                  <div class="dashboard-stat green">
                     <div class="visual">
                        <i class="icon-hideme"><?=count($this->vars['paid']);?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Paid (90 days)</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="/applications/all"><font><font>
                     click to view all </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               
            </div>
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat blue">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['ncdd2014promocode'])) ? count($this->vars['ncdd2014promocode']): 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>NCDD2014 Promo</font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#ncdd2014"><font><font>
                     Click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat purple">
                     <div class="visual">
                        <i class="icon-hide-me"><span class="number"><?=count($this->vars['trial']);?></span></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>Trial Mode</font></div>
                        <div class="desc"><font><font></font></font></div>
                     </div>
                     <a class="more" href="#trial"><font><font>
                     Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               
            </div>
            
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat blue">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['newlypaid'])) ? count($this->vars['newlypaid']): 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>Paid w/o Promo</font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#paidwopromo"><font><font>
                     Click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat blue">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['ncdd2015promocode'])) ? count($this->vars['ncdd2015promocode']): 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font></font>NCDD2015 Promo</font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#ncdd2015"><font><font>
                     Click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
            </div>
            
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box purple">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications in Trial Mode</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Status</th>
                                 <th class="hidden-480">Starts</th>
                                 <th class="hidden-480">Ends</th>
                                 <th class="hidden-480">Promo</th>
                                 <th class="hidden-480">Application Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['trial'])): foreach($this->vars['trial'] as $application): ?>
                              <tr class="gradeX odd <?=(array_key_exists('currentStatus',$application['trial'])) ? ( \Saw\Model\Trial::$status['ACTIVE'] == $application['trial']['currentStatus']) ? 'success' :'error' : 'warning';?>">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <? $declineCount = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('declineCount',$application['member']['payment']) && $application['member']['payment']['declineCount'] > 0) ? '('.$application['member']['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('renewalREUSE',$application['member']['payment']) && $application['member']['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && !empty($application['member']['payment']['number']) && !empty($application['member']['payment']['cvc'])) ? '<a data-id="'.$application['member']['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>

                                 <td class="hidden-phone"><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=(array_key_exists('currentStatus',$application['trial'])) ? \Saw\Model\Trial::$statusReversed[$application['trial']['currentStatus']]: 'no status set';?></td>

                                 <?
                                    // humanize dates
                                    $start = \Carbon\Carbon::createFromTimeStamp(strtotime($application['trial']['startDate']['fullDateTime']), $application['trial']['timeZone']);
                                    $end = \Carbon\Carbon::createFromTimeStamp(strtotime($application['trial']['endDate']['fullMonth']), $application['trial']['timeZone']);
                                 ?>

                                 <td class="hidden-480 "><b><?=$start->diffForHumans()?></b><br>(<?=$application['trial']['startDate']['fullMonth']?>)</td>
                                 <td class="hidden-480 "><b><?=$end->diffForHumans()?></b><br>(<?=$application['trial']['endDate']['fullMonth']?>)</td>
                                 <td class="center hidden-480 "><?=(array_key_exists('promocode', $application)) ? $application['promocode']:'' ?></td>
                                 <td class="center hidden-480 "><?=$application['type']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$application['memberId']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="unpaid"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box yellow">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Approved and Unpaid</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Approved</th>
                                 <th class="hidden-480">Application Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['approved'])): foreach($this->vars['approved'] as $application): ?>
                              <tr class="gradeX odd">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <? $declineCount = ( is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('declineCount',$application['member']['payment']) && $application['member']['payment']['declineCount'] > 0) ? '('.$application['member']['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('renewalREUSE',$application['member']['payment']) && $application['member']['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && !empty($application['member']['payment']['number']) && !empty($application['member']['payment']['cvc'])) ? '<a data-id="'.$application['member']['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class="hidden-phone"><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($application['approvedDate']['fullDateTime']), $application['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$application['approvedDate']['monthDay'].' '.$application['approvedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=$application['type']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <?if(!empty($application['memberId'])):?>
                                    <a data-id="<?=(!empty($application['memberId'])) ? (string)$application['memberId'] : ''?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                    <? endif; ?>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="ncdd2015"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>NCDD2015 Promo</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class="hidden-480">References</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['ncdd2015promocode'])): foreach($this->vars['ncdd2015promocode'] as $application): ?>
                              <tr class="gradeX odd">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <? $declineCount = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('declineCount',$application['member']['payment']) && $application['member']['payment']['declineCount'] > 0) ? '('.$application['member']['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('renewalREUSE',$application['member']['payment']) && $application['member']['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && !empty($application['member']['payment']['number']) && !empty($application['member']['payment']['cvc'])) ? '<a data-id="'.$application['member']['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class="hidden-phone "><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <td class="hidden-480 "><?=$application['paidDate']['monthDay'].' '.$application['paidDate']['shortTime']?></td>
                                 <td class="hidden-phone">
                                    <? if($application['new_references']['total'] >= $application['new_references']['max']): ?>
                                    <span class="label label-success"><?=$application['new_references']['total'].' of '.$application['new_references']['max']?></span>
                                    <? else: ?>
                                    <span class="label label-important"><?=$application['new_references']['total'].' of '.$application['new_references']['max']?></span>
                                    <? endif; ?>
                                    <a href="https://<?=SAW_ADMIN_WEBSITE?>/reference/<?=$application['_id']?>/<?=$application['firstName'].'-'.$application['lastName']?>" target="_blank">Reference form</a>
                                 </td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$application['paymentId']?>" class="btn blue mini view payment"><i class=" "></i> Payment</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="ncdd2014"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>NCDD2014 Promo</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class="hidden-480">References</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['ncdd2014promocode'])): foreach($this->vars['ncdd2014promocode'] as $application): ?>
                              <tr class="gradeX odd">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <? $declineCount = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('declineCount',$application['member']['payment']) && $application['member']['payment']['declineCount'] > 0) ? '('.$application['member']['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('renewalREUSE',$application['member']['payment']) && $application['member']['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && !empty($application['member']['payment']['number']) && !empty($application['member']['payment']['cvc'])) ? '<a data-id="'.$application['member']['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class="hidden-phone "><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <td class="hidden-480 "><?=$application['paidDate']['monthDay'].' '.$application['paidDate']['shortTime']?></td>
                                 <td class="hidden-phone">
                                    <? if($application['new_references']['total'] >= $application['new_references']['max']): ?>
                                    <span class="label label-success"><?=$application['new_references']['total'].' of '.$application['new_references']['max']?></span>
                                    <? else: ?>
                                    <span class="label label-important"><?=$application['new_references']['total'].' of '.$application['new_references']['max']?></span>
                                    <? endif; ?>
                                    <a href="https://<?=SAW_ADMIN_WEBSITE?>/reference/<?=$application['_id']?>/<?=$application['firstName'].'-'.$application['lastName']?>" target="_blank">Reference form</a>
                                 </td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$application['paymentId']?>" class="btn blue mini view payment"><i class=" "></i> Payment</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="paidwopromo"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>
            
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Paid w/o Promo</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th>
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class="hidden-480">References</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['newlypaid'])): foreach($this->vars['newlypaid'] as $application): ?>
                              <tr class="gradeX odd">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <? $declineCount = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('declineCount',$application['member']['payment']) && $application['member']['payment']['declineCount'] > 0) ? '('.$application['member']['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && array_key_exists('renewalREUSE',$application['member']['payment']) && $application['member']['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(is_array($application['member']) && array_key_exists('payment',$application['member']) && is_array($application['member']['payment']) && !empty($application['member']['payment']) && !empty($application['member']['payment']['number']) && !empty($application['member']['payment']['cvc'])) ? '<a data-id="'.$application['member']['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class="hidden-phone "><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <td class="hidden-480 "><?=$application['paidDate']['monthDay'].' '.$application['paidDate']['shortTime']?></td>
                                 <td class="hidden-phone">
                                    <? if($application['new_references']['total'] >= $application['new_references']['max']): ?>
                                    <span class="label label-success"><?=$application['new_references']['total'].' of '.$application['new_references']['max']?></span>
                                    <? else: ?>
                                    <span class="label label-important"><?=$application['new_references']['total'].' of '.$application['new_references']['max']?></span>
                                    <? endif; ?>
                                    <a href="https://<?=SAW_ADMIN_WEBSITE?>/reference/<?=$application['_id']?>/<?=$application['firstName'].'-'.$application['lastName']?>" target="_blank">Reference form</a>
                                 </td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$application['paymentId']?>" class="btn blue mini view payment"><i class=" "></i> Payment</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>




         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<?=$this->element('js/Application.js');?>
<script>
jQuery(document).ready(function() {    
   io.saw.Application.init();


   $('#applications-to-approve tbody .ref-update').click(function(e){
      e.preventDefault();
      io.saw.FormPost.activate({postUrl:'/application/references'
         ,serialized:'id='+$(this).attr('data-id')+'&value='+($(this).prev().val() || '*')
         ,postOnComplete:function(responseObj,responseStatus){}
         ,postOnSuccess:function(responseObj){}
         ,blockUI:'yes'
         ,blockUIParams:{elementToBlock:'#'+$(this).parents('td').attr('id')}
      });
      
   });

   $('#paid .yellow.view').click(function(e){
      e.preventDefault();
      document.location.href='/applications/all';
   });

});      
</script>