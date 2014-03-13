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
                           <i class="icon-hideme"><?=$this->vars['newOrdersCnt'];?></i>
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
                                 <th class="">Ordered By</th>
                                 <th class="">Date</th>
                                 <th class="hidden-phone">Subtotal</th>
                                 <th class="hidden-480">Shipping</th>
                                 <th class="hidden-480">Discount</th>
                                 <th class="hidden-480">Total</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['newOrders'])): 
                                 foreach($this->vars['newOrders'] as $order): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$order['payment']['name']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($order['orderDate']['fullDateTime']), $order['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$order['orderDate']['monthDay'].' '.$order['orderDate']['shortTime']?></td>
                                 <td class=" hidden-phone"><?='$'.number_format($order['orderTotal'],2)?></td>
                                 <td class="hidden-phone"><?='$'.number_format($order['shippingTotal'],2)?></td>
                                 <td class="hidden-480 "><?=(array_key_exists('discountTotal',$order)) ? '$'.number_format($order['discountTotal'],2): ''?></td>
                                 <td class="center hidden-480 "><?='$'.number_format($order['payment']['amount'],2)?></td>
                                 <td class=" "><a data-id="<?=$order['_id']?>" class="btn blue mini order-edit"><i class=" "></i> View + Fulfill</a></td>
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
                                 <th class="hidden-480">Purchase Instructions</th>
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
                                       case 'MEMBERSONLY':
                                          $currentStatus = '<span class="label label-success">'.$product['currentStatus'].'</span>';
                                          break;
                                       case 'UNPUBLISH':
                                          $currentStatus = '<span class="label label-inverse">'.$product['currentStatus'].'</span>';
                                          break;
                                    }
                                 ?>
                                 <td class="hidden-480 "><?=$currentStatus?></td>
                                 <td class="center hidden-480 "><?=(array_key_exists('purchaseInstructions', $product)) ? $product['purchaseInstructions'] : '';?></td>
                                 <td class="center hidden-480 "><?=(is_array($product['category'])) ? $product['category']['name']: $product['category'];?></td>
                                 <td class=" ">
                                    <a data-id="<?=$product['_id']?>" class="btn blue mini edit"><i class=" "></i> Edit</a>
                                    <? if ($product['currentStatus'] >= 'MEMBERSONLY') { ?>
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
                                 <th class="">Ordered By</th>
                                 <th class="">Shipped</th>
                                 <th class="hidden-phone">Subtotal</th>
                                 <th class="hidden-480">Shipping</th>
                                 <th class="hidden-480">Discount</th>
                                 <th class="hidden-480">Total</th>
                                 <th class=""></th>
                              </tr>
                           </thead>
                           <tbody role="alert" aria-live="polite" aria-relevant="all">
                              <? if(!empty($this->vars['fulfilledOrders'])): 
                                 foreach($this->vars['fulfilledOrders'] as $order): ?>
                              <tr class="gradeX odd">
                                 <td class=" "><?=$order['payment']['name']?></td>
                                 <? $human = \Carbon\Carbon::createFromTimeStamp(strtotime($order['shipDate']['fullDateTime']), $order['timeZone']); ?>
                                 <td class="hidden-480 "><b><?=$human->diffForHumans()?></b><br><?=$order['shipDate']['monthDay'].' '.$order['shipDate']['shortTime']?></td>
                                 <td class=" hidden-phone"><?='$'.number_format($order['orderTotal'],2)?></td>
                                 <td class="hidden-phone"><?='$'.number_format($order['shippingTotal'],2)?></td>
                                 <td class="hidden-480 "><?=(array_key_exists('discountTotal',$order)) ? '$'.number_format($order['discountTotal'],2): ''?></td>
                                 <td class="center hidden-480 "><?='$'.number_format($order['payment']['amount'],2)?></td>
                                 <td class=" "><a data-id="<?=$order['_id']?>" class="btn blue mini order-edit"><i class=" "></i> View</a></td>
                              </tr>
                              <? endforeach;?>
                              <? else: ?>
                                 <td colspan="7">No new orders.</td>
                              <? endif;?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- END EXAMPLE TABLE PORTLET-->
               </div>
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
      document.location.href='https://<?=SAW_CONSUMER_WEBSITE?>/store/'+$(this).attr('data-id')+$(this).attr('data-slug');
   });
   $('.order-edit').click(function(e){
      document.location.href='/product/order/edit/'+$(this).attr('data-id');
   });
   
});      
</script>