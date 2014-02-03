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
                           <i class="icon-hideme"><?=$this->vars['newCnt'];?></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font>
                              New Orders
                           </font></font></div>
                           <div class="desc"><font><font>                           
                              
                           </font></font></div>
                        </div>
                        <a class="more" href="#new"><font><font>
                        Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                     <div class="dashboard-stat purple">
                        <div class="visual">
                           <i class="icon-hide-me"><span class="number"><?=$this->vars['productsCnt'];?></span></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font></font>Products</font></div>
                        </div>
                        <a class="more" href="#products"><font><font>
                        Click To Scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  
               </div>
               <div class="row-fluid">
                  <div class="responsive span6" data-tablet="span6" data-desktop="span6">
                     <a name="approve"></a>
                     <div class="dashboard-stat green">
                        <div class="visual">
                           <i class="icon-hideme"><?=$this->vars['fulfilledCnt'];?></i>
                        </div>
                        <div class="details">
                           <div class="number"><font><font>Fulfilled Orders</font></font></div>
                           <div class="desc"><font><font>
                              
                           </font></font></div>
                        </div>
                        <a class="more" href="#fulfilled"><font><font>
                        click to scroll </font></font><i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  
               </div>
            <a name="name"></a>
            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box red">
                     <div class="portlet-title">
                        <div class="caption"><i class="icon-barcode"></i>New Orders</div>
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
                              <? if(!empty($this->vars['newOrders'])): foreach($this->vars['newOrders'] as $application): ?>
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
                                 <td colspan="7">No new orders.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="products"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid" id="product">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box purple">
                     <div class="portlet-title">
                        <div class="caption"><i class="icon-barcode"></i>All Products</div>
                        <div class="actions">
                           <a class="btn green add-product"><i class=" icon-plus"></i> Add a Product</a>
                        </div>
                     </div>
                     <div class="portlet-body">
                        <div id="sample_1_wrapper" class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTable" id="applications" aria-describedby="sample_1_info">
                           <thead>
                              <tr role="row">
                                 <th class="">Name</th>
                                 <th class="hidden-phone">$</th>
                                 <th class="hidden-phone">Member $</th>
                                 <th class="hidden-phone">Shipping $</th>
                                 <th class="hidden-480">Status</th>
                                 <th class="hidden-480">Add'l Notes</th>
                                 <th class="hidden-480">Category</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['products'])): foreach($this->vars['products'] as $product): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$product['name']?></td>
                                 <td class="hidden-phone">$<?=number_format($product['price'],2)?></td>
                                 <td class="hidden-phone">$<?=number_format($product['memberPrice'],2)?></td>
                                 <td class="hidden-phone">$<?=number_format($product['shippingPrice'],2)?></td>
                                 
                                 <?
                                    switch ($product['currentStatus']) {
                                       case 'PUBLISH':
                                          $currentStatus = '<span class="label label-success">'.$product['currentStatus'].'</span>';
                                          break;
                                       case 'UNPUBLISH':
                                          $currentStatus = '<span class="label label-inverse">'.$product['currentStatus'].'</span>';
                                          break;
                                    }
                                 ?>
                                 <td class="hidden-480 "><?=$currentStatus?></td>
                                 <td class="center hidden-480 "><?=$product['additionalNotes']?></td>
                                 <td class="center hidden-480 "><?=(is_array($product['category'])) ? $product['category']['name']: $product['category'];?></td>
                                 <td class=" ">
                                    <a data-id="<?=$product['_id']?>" class="btn blue mini edit"><i class=" "></i> Edit</a>
                                    <? if ($product['currentStatus'] == 'PUBLISH') { ?>
                                    <a data-id="<?=$product['_id']?>" data-slug="<?=$product['slug']?>" class="btn blue mini view"><i class=" "></i> View</a>
                                    <? } ?>
                                 </td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">None.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div><a name="fulfilled"></a>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12">
                  <!-- BEGIN EXAMPLE TABLE PORTLET-->
                  <div class="portlet box green">
                     <div class="portlet-title">
                        <div class="caption"><i class="icon-barcode"></i>Fulfilled Orders</div>
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
                              <? if(!empty($this->vars['fulfilledOrders'])): foreach($this->vars['fulfilledOrders'] as $application): ?>
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
<?=$this->element('js/Product.js');?>
<script>
jQuery(document).ready(function() {    
   io.saw.Product.init();
   $('#product .add-product').click(function(e){
      document.location.href='/product/edit';
   });
   $('#product .edit').click(function(e){
      document.location.href='/product/edit/'+$(this).attr('data-id');
   });
   $('#product .view').click(function(e){
      document.location.href='http://<?=SAW_CONSUMER_WEBSITE?>/store/'+$(this).attr('data-id')+$(this).attr('data-slug');
   });
   
});      
</script>