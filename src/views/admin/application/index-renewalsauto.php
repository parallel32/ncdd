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
            <h3>Auto-renew script runs at the top of every hour until all records are marked paid</h3>
            <div class="row-fluid">
               <div class="responsive span12" data-tablet="span12" data-desktop="span12">
                  <div class="dashboard-stat purple">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['ar_res'])) ? count($this->vars['ar_res']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           Grand Total
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                  </div>
               </div>
            </div>


            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat blue">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['valid'])) ? count($this->vars['valid']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           valid
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#valid"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat yellow">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['expired'])) ? count($this->vars['expired']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           expired
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#expired"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div>
            </div>


            <div class="row-fluid">
               <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                  <div class="dashboard-stat red">
                     <div class="visual">
                        <i class="icon-hideme"><?=(is_array($this->vars['declined'])) ? count($this->vars['declined']) : 0;?></i>
                     </div>
                     <div class="details">
                        <div class="number"><font><font>
                           declined
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#declined"><font><font>
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
                        <div class="number"><font><font>
                           paid
                        </font></font></div>
                        <div class="desc"><font><font>                           
                           
                        </font></font></div>
                     </div>
                     <a class="more" href="#paid"><font><font>
                     click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                     </a>                 
                  </div>
               </div><a name="declined"></a>
            </div>


            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box red">
                     <div class="portlet-title" id="application">
                        <div class="caption">Declined</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Card</th>
                                 <th class="hidden-phone">ExpDate</th>
                                 <th class="hidden-phone">Number</th>
                                 <th class="hidden-480">Member</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['declined'])): foreach($this->vars['declined'] as $item): ?>
                              <tr class="gradeX odd ">
                              <?if (true): ?>
                                 <td class=" "><a data-id="<?=$item['record']['_id']?>" class="btn mini view card">cc</a></td>
                                 <td class="hidden-phone"><?=$item['record']['payment']['expMonth']?> / <?=$item['record']['payment']['expYear']?></td>
                                 <td class="hidden-phone"><?='...'.substr(str_replace('.x', '', $item['record']['payment']['number']), -4);?></td>
                                 <td class="hidden-phone"><?=$item['record']['name']?></td>
                                 <td class="hidden-phone"><?=$item['declinedMessage']?></td>                                 
                              <? endif; 
                              ?>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="unpaid"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>            
         </div>
         <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box blue">
                     <div class="portlet-title" id="application">
                        <div class="caption">Valid</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Card</th>
                                 <th class="hidden-phone">ExpDate</th>
                                 <th class="hidden-phone">Number</th>
                                 <th class="hidden-480">Member</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['valid'])): foreach($this->vars['valid'] as $item): ?>
                              <tr class="gradeX odd ">
                              <?if (true): ?>
                                 <td class=" "><a data-id="<?=$item['record']['_id']?>" class="btn mini view card">cc</a></td>
                                 <td class="hidden-phone"><?=$item['record']['payment']['expMonth']?> / <?=$item['record']['payment']['expYear']?></td>
                                 <td class="hidden-phone"><?='...'.substr(str_replace('.x', '', $item['record']['payment']['number']), -4);?></td>
                                 <td class="hidden-phone"><?=$item['record']['name']?></td>
                                 <td class="hidden-phone"><?=$item['declinedMessage']?></td>                                 
                              <? endif; ?>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="unpaid"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>            
         </div>
         <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box green">
                     <div class="portlet-title" id="application">
                        <div class="caption">Paid</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Card</th>
                                 <th class="hidden-phone">ExpDate</th>
                                 <th class="hidden-phone">Number</th>
                                 <th class="hidden-480">Member</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['paid'])): foreach($this->vars['paid'] as $item): ?>
                              <tr class="gradeX odd ">
                              <?if (true): ?>
                                 <td class=" "><a data-id="<?=$item['record']['_id']?>" class="btn mini view card">cc</a></td>
                                 <td class="hidden-phone"><?=$item['record']['payment']['expMonth']?> / <?=$item['record']['payment']['expYear']?></td>
                                 <td class="hidden-phone"><?='...'.substr(str_replace('.x', '', $item['record']['payment']['number']), -4);?></td>
                                 <td class="hidden-phone"><?=$item['record']['name']?></td>
                                 <td class="hidden-phone"><a data-id="<?=$item['paymentId']?>" class="btn mini green payment">Payemnt</a></td>                                 
                              <? endif; ?>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="unpaid"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>            
         </div>
         <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box yellow">
                     <div class="portlet-title" id="application">
                        <div class="caption">Expired</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Card</th>
                                 <th class="hidden-phone">ExpDate</th>
                                 <th class="hidden-phone">Number</th>
                                 <th class="hidden-480">Member</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['expired'])): foreach($this->vars['expired'] as $item): ?>
                              <tr class="gradeX odd ">
                              <?if (true): ?>
                                 <td class=" "><a data-id="<?=$item['record']['_id']?>" class="btn mini view card">cc</a></td>
                                 <td class="hidden-phone"><?=$item['record']['payment']['expMonth']?> / <?=$item['record']['payment']['expYear']?></td>
                                 <td class="hidden-phone"><?='...'.substr(str_replace('.x', '', $item['record']['payment']['number']), -4);?></td>
                                 <td class="hidden-phone"><?=$item['record']['name']?></td>
                                 <td class="hidden-phone"><?=$item['declinedMessage']?></td>                                 
                              <? endif; ?>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="6">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="unpaid"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>            
         </div>



         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->


      <!-- EMAIL VIEW MODAL -->
      <div class="modal container fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
           <div class="modal-dialog">
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title" id="view-label"></h4>
                   </div>
                   <div class="modal-body">
                       <iframe src="" style="zoom:0.60" width="99.6%" height="800" frameborder="0"></iframe>
                   </div>
                   <div class="modal-footer">
                       <button class="btn default no">Close</button>
                   </div>
                 </div>
           </div>
       </div>
      <!--/ EMAIL VIEW MODAL -->


<script>
jQuery(document).ready(function() {
   $('.btn.card').live('click', function() {
      $('#view-modal iframe').attr('src','/card/'+$(this).attr('data-id'));
      $('#view-modal').modal({keyboard: false});   
   });
   $('.btn.payment').live('click', function() {
      $('#view-modal iframe').attr('src','/payment/'+$(this).attr('data-id')+'/view');
      $('#view-modal').modal({keyboard: false});   
   });
   $('#view-modal .btn.no').click(function(e){
      $('#view-modal').modal('hide');
   });
});      
</script>