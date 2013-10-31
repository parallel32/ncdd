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
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box red">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications To Approve</div>
                     </div>
                     <div id="applications-to-approve" class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="">Ref.</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Submitted</th>
                                 <th class="hidden-480">Application Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['submitted'])): foreach($this->vars['submitted'] as $application): ?>
                              <tr class="gradeX odd">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class=" hidden-phone" id="<?=$application['_id']?>"><input type="text" class="m-wrap" style="width:32px;" value="<?=(array_key_exists('references',$application)) ? $application['references']:''; ?>"><a data-id="<?=$application['_id']?>" href="#" class="btn green icn-only ref-update"><i class="icon-check icon-white"></i></a></td>
                                 <td class="hidden-phone"><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($application['submittedDate']['fullDateTime']), $application['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$application['submittedDate']['monthDay'].' '.$application['submittedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=$application['type']?></td>
                                 <td class=" "><a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> View</a></td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">Nothing to approve.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- END EXAMPLE TABLE PORTLET-->
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
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Status</th>
                                 <th class="hidden-480">Starts</th>
                                 <th class="hidden-480">Ends</th>
                                 <th class="hidden-480">Application Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['trial'])): foreach($this->vars['trial'] as $application): ?>
                              <tr class="gradeX odd <?=(array_key_exists('currentStatus',$application['trial'])) ? ( \Saw\Model\Trial::$status['ACTIVE'] == $application['trial']['currentStatus']) ? 'success' :'error' : 'warning';?>">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class="hidden-phone"><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=(array_key_exists('currentStatus',$application['trial'])) ? \Saw\Model\Trial::$statusReversed[$application['trial']['currentStatus']]: 'no status set';?></td>

                                 <?
                                    // humanize dates
                                    $start = \Carbon\Carbon::createFromTimeStamp(strtotime($application['trial']['startDate']['fullDateTime']), $application['trial']['timeZone']);
                                    $end = \Carbon\Carbon::createFromTimeStamp(strtotime($application['trial']['endDate']['fullMonth']), $application['trial']['timeZone']);
                                 ?>

                                 <td class="hidden-480 "><b><?=$start->diffForHumans()?></b><br>(<?=$application['trial']['startDate']['monthDay']?>)</td>
                                 <td class="hidden-480 "><b><?=$end->diffForHumans()?></b><br>(<?=$application['trial']['endDate']['monthDay']?>)</td>
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
                  </div>
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
                                 <td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class="hidden-phone"><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($application['approvedDate']['fullDateTime']), $application['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$application['approvedDate']['monthDay'].' '.$application['approvedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=$application['type']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" "></i> Application</a>
                                    <a data-id="<?=$application['memberId']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
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

            <div class="row-fluid" id="paid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box green">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Paid (90 days)</div>
                        <div class="actions">
                           <a class="btn yellow view"><i class=" icon-eye-open"></i> View All</a>
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class="hidden-480">Application Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['paid'])): foreach($this->vars['paid'] as $application): ?>
                              <tr class="gradeX odd">
                                 <? $middleName = (!empty($application['middleName'])) ? ' '.$application['middleName'].' ':' '; ?>
                                 <td class=" "><?=$application['firstName'].$middleName.$application['lastName']?></td>
                                 <td class="hidden-phone "><?=$application['email']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <td class="hidden-480 "><?=$application['paidDate']['monthDay'].' '.$application['paidDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=$application['type']?></td>
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