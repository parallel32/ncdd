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
               <!-- BEGIN PAGE CONTENT-->
               <div class="row-fluid">
                  <div class="span12">
               <div class="portlet box green">
                  <div class="portlet-title">
                        <div class="caption">Order Items</div>
                     </div>
                  <div class="portlet-body">
                      
                    <?=$this->element('shopping-cart-items',array('cart_items'=>$this->vars['order']['payment']['items'],'readonly'=>'yes','user'=>$this->vars['user']));?>
                      
                    </div>
               </div>
              </div>
               </div>
              
               <div class="row-fluid">
                  <div class="span12">
                     <form id="saw-form" class="horizontal-form portlet">
                        <input id="add" type="hidden" name="doc[add]" value="<?=$this->vars['add']?>">
                        <input id="currentStatus" type="hidden" name="doc[currentStatus]" value="">
                        <input id="_id" type="hidden" name="doc[_id]" value="<?=(array_key_exists('order',$this->vars)) ? $this->vars['order']['_id'] : '' ?>">
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <h3 class="form-section text-info"><strong>Transaction ID</strong></h3>
                        <p>Payment gateway transaction Id reference.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <span class=""><?=$this->vars['order']['payment']['transactionId']?></span>
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Shipping Company</strong></h3>
                        <p>For your records, enter the name of the shipping company.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group ">
                                 <label class="control-label"></label>
                                 <div class="controls">
                                    <input type="text" name="doc[shippingCompany]" value="<?=(!empty($this->vars['order']) && array_key_exists('shippingCompany',$this->vars['order'])) ? $this->vars['order']['shippingCompany']: ''?>" class="m-wrap span10 shippingCompany">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section text-info"><strong>Tracking Number</strong></h3>
                        <p>For your records, enter the name of the tracking number.</p>
                        <div class="row-fluid">
                           <div class="span12 ">
                              <div class="control-group">
                              <label class="control-label"></label>
                              <div class="controls">
                                 <input type="text" name="doc[trackingNumber]" value="<?=(!empty($this->vars['order']) && array_key_exists('trackingNumber',$this->vars['order'])) ? $this->vars['order']['trackingNumber']: ''?>" class="m-wrap span10 trackingNumber">
                              </div>
                           </div>
                           </div>
                           <!--/span-->
                        </div>
                        
                        <!-- ERROR -->
                        <div class="alert alert-error hide">
                           <button class="close" data-dismiss="alert"></button>
                           You have some form errors. Please check below.
                        </div>
                        <!--/ ERROR -->
                        <div class="form-actions text-center">
                           <button type='button' class='btn green save-order'><i class='icon-ok'></i>Save and Mark Fulfilled.</button>
                           <button type='button' class='btn red delete'>Delete</button>
                           <button type='button' class='btn cancel'>Cancel</button>
                        </div>
                     </form>
                     <!-- SUCCESSFUL SAVE MODAL -->
                     <div id="save-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="save-modal-label">Successful Operation.</h3>
                        </div>
                        <div class="modal-body">
                           <p></p>
                        </div>
                        <div class="modal-footer">
                              <button class="btn green continue edit">Continue Editing</button>
                              <button class="btn blue all-posts">Go back to Products</button>
                              <button class="btn blue dashboard">Go to Dashboard</button>
                        </div>
                     </div>
                     <!--/ SUCCESSFUL SAVE MODAL -->

                     <!-- DELETE MODAL -->
                     <div id="delete-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="delete-modal-label" aria-hidden="true">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                           <h3 id="delete-modal-label">Delete Operation.</h3>
                        </div>
                        <div class="modal-body">
                           <p>Are you sure you want to delete this order?  Deleting will purge the entire order post including all photos.  This operation cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                           <button class="btn red yes-order">Yes, I'm sure. Delete.</button>
                           <button class="btn no">Cancel Delete</button>
                        </div>
                     </div>
                     <!--/ DELETE MODAL -->

                     
                  </div>
               </div>
               <!-- END PAGE CONTENT-->
            </div>
            <!-- END PAGE CONTAINER-->    
         </div>
         <!-- END PAGE -->
         <?=$this->element('js/Product.js');?>
         <?=$this->element('js/ClearField.js');?>
         <script>
         jQuery(document).ready(function() {    
            io.saw.Product.init();
            io.saw.ClearField.init({formArr:['#saw-form']});
         });
            
         </script>

