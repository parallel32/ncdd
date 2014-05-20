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
                  <div class="portlet box green">
                     <div class="portlet-title" id="payment">
                        <div class="caption"><i class="icon-money"></i>All Payments</div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="payments" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Title</th>
                                 <th class="hidden-480">Name</th>
                                 <th class="hidden-480">Amount</th>
                                 <th class="hidden-480">Paid Date</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['payments'])): foreach($this->vars['payments'] as $payment): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$payment['title']?></td>
                                 <td class="hidden-480 "><?=$payment['name']?></td>
                                 <td class="center hidden-480 ">$<?=$payment['amount']?></td>
                                 <td class="hidden-480 "><?=$payment['paidDate']['monthDay'].' '.$payment['paidDate']['shortTime']?></td>
                                 <td class=" ">
                                    <a data-id="<?=$payment['_id']?>" class="btn blue mini view payment"><i class=" "></i> View</a>
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
<?
## stripe
//echo $this->element('js/Payment.js');
## fdgg
echo $this->element('js/PaymentFDGG.js');
?>      
<script>
jQuery(document).ready(function() {    
   io.saw.Payment.indexInit();
});      
</script>