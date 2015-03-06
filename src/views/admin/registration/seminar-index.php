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
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat red">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['submitted'])) ? count($this->vars['submitted']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           Submitted and Unpaid
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#submitted"><font><font>
                     Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat yellow">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['depositbalance'])) ? count($this->vars['depositbalance']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Deposit Paid</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#depositbalance"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <!--
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat red">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['deposit'])) ? count($this->vars['deposit']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           Deposits (unpaid)
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#deposits"><font><font>
                     Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               -->   
            </div>
            
            <div class="row-fluid">
               
               <div class="responsive span12 align-right" data-tablet="span12" data-desktop="span12">
                  <div class="dashboard-stat green">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['paid'])) ? count($this->vars['paid']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Paid in Full</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#registrationspaid"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               
            </div>

            <div class="row-fluid">
               
               <div class="responsive span6 align-right" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat red">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['scholarships_toapprove'])) ? count($this->vars['scholarships_toapprove']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Scholarships to Approve</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#scholarshipstoapprove"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat purple">
                     <div class="visual">
                        <i class="icon-hideme"><?=(!empty($this->vars['scholarships_approved'])) ? count($this->vars['scholarships_approved']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Scholarships</font></font></div>
                        <div class="desc"><font><font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#scholarships"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               
            </div>


            <? 
            $waitlist = (!empty($this->vars['waitlist'])) ? count($this->vars['waitlist']) : 0;
            $paid = (!empty($this->vars['paid'])) ? count($this->vars['paid']) : 0;
            $deposit = (!empty($this->vars['depositbalance'])) ? count($this->vars['depositbalance']) : 0;
            $total = $paid + $deposit;
            if(array_key_exists('maxRegistrations', $this->vars['seminar']['register']) 
               && !empty($this->vars['seminar']['register']['maxRegistrations']) 
               && $this->vars['seminar']['register']['maxRegistrations'] == $total):
            ?>
            <div class="row-fluid">
               
               <div class="responsive span12 align-right" data-tablet="span12" data-desktop="span12">
                  <div class="dashboard-stat blue">
                     <div class="visual">
                        <i class="icon-hideme"><?=$total?>/<?=$this->vars['seminar']['register']['maxRegistrations']?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>Max Registrations Allowed</font></font></div>
                        <div class="desc"><font>wait list total = <?=$waitlist?></font>
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#waitlist"><font><font>
                     scroll to waiting list </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               
            </div>            
            <? endif; ?>

            <div class="row-fluid">
               <div class="span12">
                  <a name="submitted"></a>
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box red">
                     <div class="portlet-title" id="registration">
                        <div class="caption"><i class="icon-user"></i>Submitted and Unpaid</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="registrations" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Phone</th>
                                 <th class="hidden-480">Date Submitted</th>
                                 <th class="hidden-480">Payment Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['submitted'])): foreach($this->vars['submitted'] as $registration): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$registration['name']?></td>
                                 <td class="hidden-phone"><?=$registration['email']?></td>
                                 <td class="hidden-480 "><?=$registration['phone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($registration['submittedDate']['fullDateTime'])); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$registration['submittedDate']['monthDay'].' '.$registration['submittedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=\Saw\Model\Registration::$paymentTypeReversed[$registration['currentPaymentType']];?></td>
                                 <td class=" ">
                                    <a data-id="<?=$registration['_id']?>" class="btn blue mini view registration"><i class=" "></i> Registration</a>
                                    <? if(!empty($registration['memberId'])): ?>
                                    <a data-id="<?=$registration['memberId']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
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
                  </div><a name="deposits"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>


            <? if(false): ?>
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box red">
                     <div class="portlet-title" id="registration">
                        <div class="caption"><i class="icon-user"></i>Deposit Paid</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="registrations" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Phone</th>
                                 <th class="hidden-480">Date Submitted</th>
                                 <th class="hidden-480">Payment Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['deposit'])): foreach($this->vars['deposit'] as $registration): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$registration['name']?></td>
                                 <td class="hidden-phone"><?=$registration['email']?></td>
                                 <td class="hidden-480 "><?=$registration['phone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($registration['submittedDate']['fullDateTime'])); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$registration['submittedDate']['monthDay'].' '.$registration['submittedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=\Saw\Model\Registration::$paymentTypeReversed[$registration['currentPaymentType']];?></td>
                                 <td class=" ">
                                    <a data-id="<?=$registration['_id']?>" class="btn blue mini view registration"><i class=" "></i> Registration</a>
                                    <? if(!empty($registration['memberId'])): ?>
                                    <a data-id="<?=$registration['memberId']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
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
                  </div><a name="depositbalance"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>
            <? endif; ?>


            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box yellow">
                     <div class="portlet-title" id="registration">
                        <div class="caption"><i class="icon-user"></i>Deposits Balance (unpaid)</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="registrations" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Phone</th>
                                 <th class="hidden-480">Date Submitted</th>
                                 <th class="hidden-480">Payment Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['depositbalance'])): foreach($this->vars['depositbalance'] as $registration): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$registration['name']?></td>
                                 <td class="hidden-phone"><?=$registration['email']?></td>
                                 <td class="hidden-480 "><?=$registration['phone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($registration['submittedDate']['fullDateTime'])); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$registration['submittedDate']['monthDay'].' '.$registration['submittedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=\Saw\Model\Registration::$paymentTypeReversed[$registration['currentPaymentType']];?></td>
                                 <td class=" ">
                                    <a data-id="<?=$registration['_id']?>" class="btn blue mini view registration"><i class=" "></i> Registration</a>
                                    <? if(!empty($registration['memberId'])): ?>
                                    <a data-id="<?=$registration['memberId']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
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
                  </div><a name="scholarship"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid" id="paid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box green">
                     <div class="portlet-title" id="registration">
                        <div class="caption"><i class="icon-user"></i>Registrations Paid in Full</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="registrations" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Phone</th>
                                 <th class="hidden-480">Date Paid</th>
                                 <th class="hidden-480">Payment Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['paid'])): foreach($this->vars['paid'] as $registration): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$registration['name']?></td>
                                 <td class="hidden-phone"><?=$registration['email']?></td>
                                 <td class="hidden-480 "><?=$registration['phone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($registration['paidDate']['fullDateTime'])); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$registration['paidDate']['monthDay'].' '.$registration['paidDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=\Saw\Model\Registration::$paymentTypeReversed[$registration['currentPaymentType']];?></td>
                                 <td class=" ">
                                    <a data-id="<?=$registration['_id']?>" class="btn blue mini view registration"><i class=" "></i> Registration</a>
                                    <a data-id="<?=$registration['paymentId']?>" class="btn blue mini view payment"><i class=" "></i> Payment</a>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="registrationspaid"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box red">
                     <div class="portlet-title" id="registration">
                        <div class="caption"><i class="icon-user"></i>Scholarships to Approve</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="registrations" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Phone</th>
                                 <th class="hidden-480">Date Submitted</th>
                                 <th class="hidden-480">Payment Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['scholarships_toapprove'])): foreach($this->vars['scholarships_toapprove'] as $registration): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$registration['name']?></td>
                                 <td class="hidden-phone"><?=$registration['email']?></td>
                                 <td class="hidden-480 "><?=$registration['phone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($registration['submittedDate']['fullDateTime'])); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$registration['submittedDate']['monthDay'].' '.$registration['submittedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=\Saw\Model\Registration::$paymentTypeReversed[$registration['currentPaymentType']];?></td>
                                 <td class=" ">
                                    <a data-id="<?=$registration['_id']?>" class="btn blue mini view registration"><i class=" "></i> Registration</a>
                                    <? if(!empty($registration['memberId'])): ?>
                                    <a data-id="<?=$registration['memberId']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
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
                  </div><a name="scholarshipstoapprove"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box purple">
                     <div class="portlet-title" id="registration">
                        <div class="caption"><i class="icon-user"></i>Scholarships Approved</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="registrations" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Phone</th>
                                 <th class="hidden-480">Date Submitted</th>
                                 <th class="hidden-480">Payment Type</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['scholarships_approved'])): foreach($this->vars['scholarships_approved'] as $registration): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$registration['name']?></td>
                                 <td class="hidden-phone"><?=$registration['email']?></td>
                                 <td class="hidden-480 "><?=$registration['phone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($registration['submittedDate']['fullDateTime'])); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$registration['submittedDate']['monthDay'].' '.$registration['submittedDate']['shortTime']?></td>
                                 <td class="center hidden-480 "><?=\Saw\Model\Registration::$paymentTypeReversed[$registration['currentPaymentType']];?></td>
                                 <td class=" ">
                                    <a data-id="<?=$registration['_id']?>" class="btn blue mini view registration"><i class=" "></i> Registration</a>
                                    <? if(!empty($registration['memberId'])): ?>
                                    <a data-id="<?=$registration['memberId']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
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
                  </div><a name="scholarships"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <?
               if(array_key_exists('maxRegistrations', $this->vars['seminar']['register']) 
               && !empty($this->vars['seminar']['register']['maxRegistrations']) 
               && $this->vars['seminar']['register']['maxRegistrations'] == $total):
            ?>

            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="registration">
                        <div class="caption"><i class="icon-user"></i>Waiting List</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="registrations" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">Email</th>
                                 <th class="hidden-480">Phone</th>
                                 <th class="hidden-480">Date Submitted</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['waitlist'])): foreach($this->vars['waitlist'] as $registration): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$registration['name']?></td>
                                 <td class="hidden-phone"><?=$registration['email']?></td>
                                 <td class="hidden-480 "><?=$registration['phone']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($registration['submittedDate']['fullDateTime'])); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$registration['submittedDate']['monthDay'].' '.$registration['submittedDate']['shortTime']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$registration['_id']?>" class="btn blue mini view registration"><i class=" "></i> Registration</a>
                                    <? if(!empty($registration['memberId'])): ?>
                                    <a data-id="<?=$registration['memberId']?>" class="btn blue mini view member"><i class=" "></i> Member</a>
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
                  </div><a name="waitlist"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <? endif; ?>
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<?=$this->element('js/Registration.js');?>
<script>
jQuery(document).ready(function() {    
   io.saw.Registration.manageInit();


   $('#registrations-to-approve tbody .ref-update').click(function(e){
      e.preventDefault();
      io.saw.FormPost.activate({postUrl:'/registration/references'
         ,serialized:'id='+$(this).attr('data-id')+'&value='+($(this).prev().val() || '*')
         ,postOnComplete:function(responseObj,responseStatus){}
         ,postOnSuccess:function(responseObj){}
         ,blockUI:'yes'
         ,blockUIParams:{elementToBlock:'#'+$(this).parents('td').attr('id')}
      });
      
   });

   $('#paid .yellow.view').click(function(e){
      e.preventDefault();
      document.location.href='/registrations/all';
   });

});      
</script>