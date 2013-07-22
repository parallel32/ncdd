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
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Submitted</th>
                                 <th class="hidden-480">Application Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['submitted'])): foreach($this->vars['submitted'] as $application): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$application['firstName'].' '.$application['lastName']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <td class="hidden-480 "><?=$application['submittedDate']['monthDay'].' '.$application['submittedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=$application['type']?></td>
                                 <td class=" "><a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" icon-eye-open"></i> View Application</a></td>
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
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Approved</th>
                                 <th class="hidden-480">Application Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['approved'])): foreach($this->vars['approved'] as $application): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$application['firstName'].' '.$application['lastName']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <td class="hidden-480 "><?=$application['approvedDate']['monthDay'].' '.$application['approvedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=$application['type']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" icon-eye-open"></i> View Application</a>
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view member"><i class=" icon-eye-open"></i> View Member</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="5">None.</td>
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
                  <div class="portlet box green">
                     <div class="portlet-title" id="application">
                        <div class="caption"><i class="icon-user"></i>Applications Paid (90 days)</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-480">Area</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class="hidden-480">Application Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['paid'])): foreach($this->vars['paid'] as $application): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$application['firstName'].' '.$application['lastName']?></td>
                                 <td class="hidden-480 "><?=$application['city'].', '.$application['state']?></td>
                                 <td class="hidden-480 "><?=$application['paidDate']['monthDay'].' '.$application['paidDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=$application['type']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view"><i class=" icon-eye-open"></i> View Application</a>
                                    <a data-id="<?=$application['_id']?>" class="btn blue mini view payment"><i class=" icon-eye-open"></i> View Payment</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="5">None.</td>
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
});      
</script>