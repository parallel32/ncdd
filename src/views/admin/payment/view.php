<?
$user = call_user_func(function($app){ $user = $app['session']->get('user'); return $user;},$this->app);
?>
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
                  <!-- PAYMENT ELEMENT -->
                  <form id="payment-form" class="horizontal-form portlet">
                     <h3 class="form-section">Payment Information</h3>
                     <div class="row-fluid">
                        <div class="span12 ">
                           <h4>
                              <?=$this->vars['payment']['title']?>
                           </h4></br>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Date Paid</label>
                              <div class="controls">
                                 <input type="text" value="<?=$this->vars['payment']['paidDate']['monthDay'].' '.$this->vars['payment']['paidDate']['shortTime']?>" readonly class="m-wrap span8 name">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Order Id</label>
                              <div class="controls">
                                 <input type="text" value="<?=$this->vars['payment']['orderId']?>" readonly class="m-wrap span8 name">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Transaction ID</label>
                              <div class="controls">
                                 <input type="text" value="<?=$this->vars['payment']['transactionId']?>" readonly class="m-wrap span8 name">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Description</label>
                              <div class="controls">
                                 <input type="text" value="<?=$this->vars['payment']['description']?>" readonly class="m-wrap span8 name">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Amount</label>
                              <div class="controls">
                                 <input type="text" value="<?=$this->vars['payment']['amount']?>" readonly class="m-wrap span8 name">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <? if($this->vars['payment']['type'] == 'check'): ?>
                              <label class="control-label">Name</label>
                              <? else: ?>
                              <label class="control-label">Your name as it appears on the card</label>
                              <? endif; ?>
                              <div class="controls">
                                 <input type="text" value="<?=$this->vars['payment']['name']?>" readonly class="m-wrap span8 name">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <? if($this->vars['payment']['type'] == 'check'): ?>

                     <? else: ?>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Credit Card Number</label>
                              <div class="controls">
                                 <input type="text" value="<?=(strlen($this->vars['payment']['number']) > 10) ? substr($this->vars['payment']['number'], -4): $this->vars['payment']['number']?>" readonly class="m-wrap span8 number">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <!--
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Credit Card Type</label>
                              <div class="controls">
                                 <input type="text" value="<?=$this->vars['payment']['cardType']?>" readonly class="m-wrap span8 number">
                              </div>
                           </div>
                        </div>
                        <!--/span--
                     </div>
                     -->
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">CVC Code</label>
                              <div class="controls">
                                 <input type="text" value="<?=$this->vars['payment']['cvc']?>" readonly class="m-wrap span8 cvc">
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
                                 <input type="text" value="<?=$this->vars['payment']['expMonth']?>" readonly class="m-wrap span4 expMonth">
                                 <input type="text" value="<?=$this->vars['payment']['expYear']?>" readonly class="m-wrap span4 expYear">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <? endif; ?>
                     
                     <h3 class="form-section">Billing Address</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Address Line 1</label>
                              <div class="controls">
                                 <input type="text" value="<?=$this->vars['payment']['addressLine1']?>" readonly class="m-wrap span8 addressLine1">
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
                                 <input type="text" value="<?=$this->vars['payment']['addressLine2']?>" readonly class="m-wrap span8 addressLine2">
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
                                 <input type="text" value="<?=$this->vars['payment']['city']?>" readonly class="m-wrap span8 city">
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
                                 <input type="text" value="<?=$this->vars['payment']['stateProvinceRegion']?>" readonly class="m-wrap span8 stateProvinceRegion">
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
                                 <input type="text" value="<?=$this->vars['payment']['zipPostalCode']?>" readonly class="m-wrap span8 zipPostalCode">
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
                                 <input type="text" value="<?=$this->vars['payment']['country']?>" readonly class="m-wrap span8 country">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h3 class="form-section">Contact Information</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Email</label>
                              <div class="controls">
                                 <input type="text" value="<?=$this->vars['payment']['email']?>" readonly class="m-wrap span8 email">
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
                                 <input type="text" value="<?=$this->vars['payment']['phone']?>" readonly class="m-wrap span8 phone">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <? if($user['accessLevel'] >= EDITOR && array_key_exists('fullResponse',$this->vars['payment']) && !empty($this->vars['payment']['fullResponse'])){ ?>
                     <h3 class="form-section">First Data Global Gateway - Full Response</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">If needed for finding transactions: below is the full response from First Data</label>
                              <div class="controls">
                                 <pre>
                                    <?print_r($this->vars['payment']['fullResponse'])?>
                                 </pre>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <? } ?>
                     <div class="form-actions text-center">
                        <button type="button" class="btn cancel">Go Back</button>
                     </div>
                  </form>
                  
                  <!--/ PAYMENT ELEMENT -->
            </div>
         </div>
         <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->
<?
 ## stripe
 //echo $this->element('js/Payment.js');
 ## fdgg
 echo $this->element('js/PaymentFDGG.js');
 ?>      <script>
      jQuery(document).ready(function() {    
         io.saw.Payment.indexInit();
      });      
      </script>