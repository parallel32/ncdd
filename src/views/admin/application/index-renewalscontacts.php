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

            <h1>1. Renewals with changes</h1>
            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat red">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['renewals'])) ? count($this->vars['renewals']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           Total
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                  </div>
               </div>
            </div>


            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption">(<?=(is_array($this->vars['renewals_email'])) ? count($this->vars['renewals_email']) : 0;?>) - Changes to email</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th><th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals_email'])): foreach($this->vars['renewals_email'] as $member): ?>
                              <tr class="gradeX odd ">
                                 <? $declineCount = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0) ? '('.$member['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('renewalREUSE',$member['payment']) && $member['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && !empty($member['payment']['number']) && !empty($member['payment']['cvc'])) ? '<a data-id="'.$member['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                    <a data-id="<?=$member['_id']?>" class="btn mini yellow-stripe user-login">LogIn</a>
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
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption">(<?=(is_array($this->vars['renewals_bar'])) ? count($this->vars['renewals_bar']) : 0;?>) - changes to sate bar number</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th><th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals_bar'])): foreach($this->vars['renewals_bar'] as $member): ?>
                              <tr class="gradeX odd ">
                                 <? $declineCount = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0) ? '('.$member['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('renewalREUSE',$member['payment']) && $member['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && !empty($member['payment']['number']) && !empty($member['payment']['cvc'])) ? '<a data-id="'.$member['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                    <a data-id="<?=$member['_id']?>" class="btn mini yellow-stripe user-login">LogIn</a>
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
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption">(<?=(is_array($this->vars['renewals_listserv'])) ? count($this->vars['renewals_listserv']) : 0;?>) - changes to list serv email</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th><th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals_listserv'])): foreach($this->vars['renewals_listserv'] as $member): ?>
                              <tr class="gradeX odd ">
                                 <? $declineCount = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0) ? '('.$member['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('renewalREUSE',$member['payment']) && $member['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && !empty($member['payment']['number']) && !empty($member['payment']['cvc'])) ? '<a data-id="'.$member['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                    <a data-id="<?=$member['_id']?>" class="btn mini yellow-stripe user-login">LogIn</a>
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
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption">(<?=(is_array($this->vars['renewals_firmname'])) ? count($this->vars['renewals_firmname']) : 0;?>) - changes to firm name</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th><th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals_firmname'])): foreach($this->vars['renewals_firmname'] as $member): ?>
                              <tr class="gradeX odd ">
                                 <? $declineCount = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0) ? '('.$member['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('renewalREUSE',$member['payment']) && $member['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && !empty($member['payment']['number']) && !empty($member['payment']['cvc'])) ? '<a data-id="'.$member['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                    <a data-id="<?=$member['_id']?>" class="btn mini yellow-stripe user-login">LogIn</a>
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
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption">(<?=(is_array($this->vars['renewals_address'])) ? count($this->vars['renewals_address']) : 0;?>) - changes to address</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th><th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals_address'])): foreach($this->vars['renewals_address'] as $member): ?>
                              <tr class="gradeX odd ">
                                 <? $declineCount = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0) ? '('.$member['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('renewalREUSE',$member['payment']) && $member['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && !empty($member['payment']['number']) && !empty($member['payment']['cvc'])) ? '<a data-id="'.$member['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                    <a data-id="<?=$member['_id']?>" class="btn mini yellow-stripe user-login">LogIn</a>
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
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption">(<?=(is_array($this->vars['renewals_phone'])) ? count($this->vars['renewals_phone']) : 0;?>) - changes to phone</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class=""></th><th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-phone">Phone</th>
                                 <th class="hidden-480">Date</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['renewals_phone'])): foreach($this->vars['renewals_phone'] as $member): ?>
                              <tr class="gradeX odd ">
                                 <? $declineCount = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('declineCount',$member['payment']) && $member['payment']['declineCount'] > 0) ? '('.$member['payment']['declineCount'].')': ''; ?>
                                 <? $renewalREUSE = (array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && array_key_exists('renewalREUSE',$member['payment']) && $member['payment']['renewalREUSE'] == 'yes') ? 'purple': 'red'; ?>
                                 <td class=" "><?=(array_key_exists('payment',$member) && is_array($member['payment']) && !empty($member['payment']) && !empty($member['payment']['number']) && !empty($member['payment']['cvc'])) ? '<a data-id="'.$member['_id'].'" class="btn '.$renewalREUSE.' mini view card">cc'.$declineCount.'</a>':'' ?></td><td class=" "><?=$member['displayName']?></td>
                                 <td class="hidden-phone"><a href="mailto:<?=$member['email']?>?subject=Re:Your NCDD Update Form"><?=$member['email']?></a></td>
                                 <td class="hidden-phone"><?=$member['primaryPhone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($member['renewal']['submittedDate']['fullDateTime']), $member['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$member['renewal']['submittedDate']['monthDay'].' '.$member['renewal']['submittedDate']['shortTime']?></td><td class=" ">
                                    <a data-id="<?=$member['renewal']['applicationId']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$member['_id']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
                                    <a data-id="<?=$member['_id']?>" class="btn mini yellow-stripe user-login">LogIn</a>
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

            
            <script>
            jQuery(document).ready(function() {    
               io.saw.Application.init();

               $('td .user-login').click(function(e){
                  io.saw.FormGet.activate({postUrl:'/authentication/shadologin/'+$(this).attr('data-id')
                     ,postOnComplete:function(responseObj,responseStatus){}
                     ,postOnSuccess:function(responseObj){
                        document.location.href = '/';
                     }
                     ,postOnErrors:function(responseObj){
                        alert('Something failed trying to sign in as this user...this is an unlikely error with no logs.  Please recall what you did and email Mike.');
                     }
                  });
               });
            
            });      
            </script>









         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<?=$this->element('js/Application.js');?>
<script>
jQuery(document).ready(function() {    
   io.saw.Application.init();

   $('#paid-renewals .yellow.view').click(function(e){
      e.preventDefault();
      document.location.href='/applications/all';
   });

});      
</script>