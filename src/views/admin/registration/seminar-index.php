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
                     <div class="dashboard-stat yellow">
                        <div class="visual">
                           <i class="icon-hideme"><?=(!empty($this->vars['submitted'])) ? count($this->vars['submitted']) : 0;?></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font>
                              Submitted (unpaid)
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
                     <a name="submitted"></a>
                     <div class="dashboard-stat green">
                        <div class="visual">
                           <i class="icon-hideme"><?=(!empty($this->vars['paid'])) ? count($this->vars['paid']) : 0;?></i>
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
            
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box yellow">
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
                  </div><a name="paid"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid" id="paid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box green">
                     <div class="portlet-title" id="registration">
                        <div class="caption"><i class="icon-user"></i>Registrations Paid</div>
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
                  </div>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>


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