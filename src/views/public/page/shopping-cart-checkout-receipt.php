<!-- BEGIN CONTAINER -->   
<div class="page-container row-fluid">
   <!-- BEGIN PAGE CONTAINER-->
   <div class="container-fluid">
      <!-- BEGIN PAGE HEADER-->
         <div class="row-fluid">
            <div class="span12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title text-center">
                  <img src="/assets/img/ncdd-login2-logo.png">
                  <br/>Store Purchase Receipt
               </h3>
               <p class="text-center">
                  
                  National College for DUI Defense, Inc. 
                  <br/>445 S. Decatur St. 
                  <br/>Montgomery, AL 36104
                  <br/>Tel: 334-264-1950 
                  <br/>Fax: 334-264-1920
               </p>
               <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
         </div>
         <!-- END PAGE HEADER-->
         <!-- BEGIN PAGE CONTENT-->
         <div class="row-fluid shoppingCart" style="padding-bottom:0px;">
            <div class="shoppingCartBody productDescrrr">
                <form>
              <?=$this->element('shopping-cart-items',array('cart_items'=>$this->vars['order']['payment']['items'],'readonly'=>'yes','user'=>$this->vars['user']));?>
                </form>
              </div>
        </div>
         <div class="row-fluid checkout">
            <div class="span12">
               <!-- BEGIN FORM-->
               <form id="saw-form" class="horizontal-form portlet">
                  <!-- PAYMENT ELEMENT -->
                          <form id="payment-form" class="horizontal-form portlet">
                             <!-- ERROR -->
                             
                             <div class="obliqueLineTitle"><h2 style="padding:0 25px 0px 0px">Payment ID</h2></div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">In case you need to refer to this order please use this ID:</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['transactionId']?></span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="obliqueLineTitle"><h2 style="padding:0 25px 0px 0px">Payment Information</h2></div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Your name as it appears on the card</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['name']?></span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Credit Card Number</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['number']?></span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Expiration Date</label>
                                      <div class="controls">
                                         <span class="text-info">Month:<?=$this->vars['order']['payment']['expMonth']?> <br>Year: <?=$this->vars['order']['payment']['expYear']?></span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Email</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['email']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Phone</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['phone']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             
                             <div class="obliqueLineTitle"><h2 style="padding:0 25px 0px 0px">Billing Address</h2></div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Address Line 1</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['addressLine1']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Address Line 2</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['addressLine2']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">City</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['city']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">State/Province/Region</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['stateProvinceRegion']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Zip/PostalCode</label>
                                      <div class="controls">
                                         <span class="text-info"><?if(strlen($this->vars['order']['payment']['zipPostalCode']) < 5){echo str_pad($this->vars['order']['payment']['zipPostalCode'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['order']['payment']['zipPostalCode']) > 5 && strlen($this->vars['order']['payment']['zipPostalCode']) < 9){str_pad($this->vars['order']['payment']['zipPostalCode'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['order']['payment']['zipPostalCode'];}?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Country</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['country']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="obliqueLineTitle"><h2 style="padding:0 25px 0px 0px">Shipping Address</h2></div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Address Line 1</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['addressLine1Shipping']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Address Line 2</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['addressLine2Shipping']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">City</label>
                                      <div class="controls">
                                         <span class="text-info"><?=$this->vars['order']['payment']['cityShipping']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">State/Province/Region</label>
                                      <div class="controls">
                                        <span class="text-info"> <?=$this->vars['order']['payment']['stateProvinceRegionShipping']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Zip/PostalCode</label>
                                      <div class="controls">
                                        <span class="text-info"> <?if(strlen($this->vars['order']['payment']['zipPostalCodeShipping']) < 5){echo str_pad($this->vars['order']['payment']['zipPostalCodeShipping'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['order']['payment']['zipPostalCodeShipping']) > 5 && strlen($this->vars['order']['payment']['zipPostalCodeShipping']) < 9){str_pad($this->vars['order']['payment']['zipPostalCodeShipping'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['order']['payment']['zipPostalCodeShipping'];}?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
                             <div class="row-fluid">
                                <div class="span8 ">
                                   <div class="control-group ">
                                      <label class="control-label">Country</label>
                                      <div class="controls">
                                        <span class="text-info"> <?=$this->vars['order']['payment']['countryShipping']?> </span>
                                      </div>
                                   </div>
                                </div>
                                <!--/span-->
                             </div>
               </form>
               <!-- END FORM--> 
            </div>
         </div>
         <!-- END PAGE CONTENT-->

   </div>
   <!-- END PAGE CONTAINER -->
</div>
<!-- END CONTAINER -->