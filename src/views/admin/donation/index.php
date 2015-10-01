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
      <div class="row-fluid">
         <div class="span12">
            <h1>Donations</h1>
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat yellow">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['submitted'])) ? count($this->vars['submitted']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Submitted</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#submitted"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat green">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['paid'])) ? count($this->vars['paid']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Paid</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#paid"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
            </div>
         </div>
      </div>



   
      <a name="submitted"></a>
      <div class="row-fluid">
         <div class="span12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box yellow">
               <div class="portlet-title" id="application">
                  <div class="caption"><i class="icon-user"></i>Submitted Donations</div>
                  <div class="actions">
                     
                  </div>
               </div>
               <div class="portlet-body">
                  <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                  <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                     <thead>
                        <tr role="row">
                           <th class=""></th><th class="">Name</th>
                           <th class="hidden-phone">Email</th>
                           <th class="hidden-phone">Phone</th>
                           <th class="hidden-480">Date </th>
                           <th class=""></th>
                        </tr>
                     </thead>
                     <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <? if(!empty($this->vars['submitted'])): foreach($this->vars['submitted'] as $member): ?>
                        <tr class="gradeX odd">
                           <? $declineCount = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0) ? '('.$member['payment']['declineCount'].')': ''; ?>
                           <? $renewalREUSE = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('renewalREUSE',$member['payment']) && $member['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                           <td class=" "><?=(array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && !empty($member['payment']['number']) && !empty($member['payment']['cvc'])) ? '<a data-id="'.$member['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$member['displayName']?></td>
                           <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                           <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                           <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                           <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                              <a data-id="<?=$member['renewal']['contributionPaymentId']?>" class="btn blue mini view payment"><i class=" "></i> Payment</a>
                              <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                              <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                              <a data-id="<?=$member['_id']?>" class="btn mini yellow-stripe user-login">LogIn</a>
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
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
         </div>
      </div>

      <a name="paid"></a>
      <div class="row-fluid">
         <div class="span12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box green">
               <div class="portlet-title" id="application">
                  <div class="caption"><i class="icon-user"></i>Paid Donations</div>
                  <div class="actions">
                     
                  </div>
               </div>
               <div class="portlet-body">
                  <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                  <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                     <thead>
                        <tr role="row">
                           <th class=""></th><th class="">Name</th>
                           <th class="hidden-phone">Email</th>
                           <th class="hidden-phone">Phone</th>
                           <th class="hidden-480">Date </th>
                           <th class=""></th>
                        </tr>
                     </thead>
                     <tbody role="alert" aria-live="polite" aria-relevant="all">
                        <? if(!empty($this->vars['paid'])): foreach($this->vars['paid'] as $member): ?>
                        <tr class="gradeX odd">
                           <? $declineCount = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0) ? '('.$member['payment']['declineCount'].')': ''; ?>
                           <? $renewalREUSE = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('renewalREUSE',$member['payment']) && $member['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                           <td class=" "><?=(array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && !empty($member['payment']['number']) && !empty($member['payment']['cvc'])) ? '<a data-id="'.$member['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$member['displayName']?></td>
                           <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                           <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                           <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                           <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                              <a data-id="<?=$member['renewal']['contributionPaymentId']?>" class="btn blue mini view payment"><i class=" "></i> Payment</a>
                              <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                              <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                              <a data-id="<?=$member['_id']?>" class="btn mini yellow-stripe user-login">LogIn</a>
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
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
         </div>
      </div>


   </div>
</div>
<!-- END PAGE -->
