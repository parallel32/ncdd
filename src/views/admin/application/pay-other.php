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

            <!-- INVOICE -->
            <div class="row-fluid invoice">
               <div class="span12 alert">
                  <p><h3>You are now in the: alternat payment method screen</h3></p>
                  <p><h3>To pay by credit card on behalf of the member:</h3></p> <a class="btn blue" href="/application/<?=$this->vars['application']['_id']?>/pay"><i class="icon-money"></i> Goto CC Form</a>
               </div>
            </div>
            <hr />
            
            <div class="row-fluid invoice">
               <div class="row-fluid invoice-logo">
                  <div class="span6 invoice-logo-space"><img src="/assets/img/ncdd-login2-logo.png" alt="" /> </div>
                  <div class="span6">
                     <p>#<?=$this->vars['application']['_id']?> / <? $date = new \DateTime(); echo $date->format('d');?> <?echo $date->format('M');?>, <?echo $date->format('Y');?> <span class="muted">Application ID and Date</span></p>
                  </div>
               </div>
               <hr />
               <div class="row-fluid">
                  <div class="span3">
                     <h4>Member:</h4>
                     <ul class="unstyled">
                        <? $middleName = (!empty($this->vars['application']['middleName'])) ? ' '.$this->vars['application']['middleName'].' ':' '; ?>
                        <li><?=$this->vars['application']['firstName']?><?=$middleName?><?=$this->vars['application']['lastName']?></li>
                        <li><?=$this->vars['application']['formattedAddress']?></li>
                        <li>email: <?=$this->vars['application']['email']?></li>
                        <li>phone: <?=$this->vars['application']['phone']?></li>
                        <li>fax: <?=$this->vars['application']['fax']?></li>
                     </ul>
                  </div>
                  <div class="span4">
                     <h4>About:</h4>
                     <ul class="unstyled">
                        <li><?=$this->vars['application']['type']?></li>
                        <li><?=$this->vars['application']['executed']?></li>
                     </ul>
                  </div>
                  <div class="span4 invoice-payment">
                     <h4></h4>
                     <ul class="unstyled">
                        
                     </ul>
                  </div>
               </div>
               <div class="row-fluid">
                  <table class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Item</th>
                           <th class="hidden-480">Description</th>
                           <th class="hidden-480">Quantity</th>
                           <th class="hidden-480">Unit Cost</th>
                           <th>Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>1</td>
                           <td>Application</td>
                           <td class="hidden-480"><?=$this->vars['application']['type']?></td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">$<?=$this->vars['application']['membershipDues']?></td>
                           <td>$<?=$this->vars['application']['membershipDues']?></td>
                        </tr>
                        
                     </tbody>
                  </table>
               </div>
               <div class="row-fluid">
                  <div class="span12 invoice-block">
                     <ul class="unstyled amounts">
                        <li><strong>Sub - Total amount:</strong> $<?=$this->vars['application']['membershipDues']?></li>
                        <li><strong>Grand Total:</strong> $<?=$this->vars['application']['membershipDues']?></li>
                     </ul>
                  </div>
               </div>
            </div>

            <!--/ INVOICE -->

            <!-- ADMIN payment by check .. or reduce the payment amount by adding a discount to the invoice -->
            <!-- an invoice must have a corresponding payment (whether it's a credit card or a record created by the admin when marking an invoice paid) -->
            <!-- on this screen you have to mark something paid in order to de-activate it -->
            
            <!-- concept of renewals and trial memberships -->
            <!-- include refunds on already made credit card payments.  refunds on anything else will be used as credits towards future bills or the money will be sent back -->




            <!-- PAYMENT  only show for ADMIN -->
            <div class="row-fluid">
               <div class="span12">
                  <!-- PAYMENT ELEMENT -->
                  <form id="payment-form" class="horizontal-form portlet">
                     <!-- ERROR -->
                     <div class="alert alert-error hide">
                        <button class="close" data-dismiss="alert"></button>
                        You have some form errors. Please check below.
                     </div>
                     <!--/ ERROR -->
                     <input type="hidden" class="memberId" name="doc[memberId]" value="<?=$memberId?>">
                     <input type="hidden" class="ownerId" name="doc[ownerId]" value="<?=$ownerId?>">
                     <input type="hidden" class="ownerClass" name="doc[ownerClass]" value="<?=$ownerClass?>">
                     <input type="hidden" class="description" name="doc[description]" value="<?=$description?>">
                     <input type="hidden" class="title" name="doc[title]" value="<?=$title?>">
                     <input type="hidden" class="amount" name="doc[amount]" value="<?=$amount?>">
                     <input type="hidden" class="cardType" name="doc[cardType]" value="">
                     <input type="hidden" class="token" name="doc[token]" value="">
                     <h3 class="form-section">Payment Information</h3>
                     <div class="row-fluid">
                        <div class="span12 ">
                           <div class="control-group">
                              <label class="control-label" for="type">We Accept</label>
                              <div class="controls">
                                 <span class="card visa" title="Visa">Visa</span>
                                 <span class="card master" title="Mastercard">Mastercard</span>
                                 <span class="card amex" title="American Express">American Express</span>
                                 <span class="card discover" title="Discover">Discover</span>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span12 "><span class="cardType"></span></div>
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Your name as it appears on the card</label>
                              <div class="controls">
                                 <input type="text" name="doc[name]" class="m-wrap span8 name" value="<?=$firstName?> <?=$lastName?>">
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
                                 <input type="text" name="doc[number]" class="m-wrap span8 number">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">CVC Code</label>
                              <div class="controls">
                                 <input type="text" name="doc[cvc]" class="m-wrap span8 cvc">
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
                                 <select class="span4 expMonth" name="doc[expMonth]"></select>
                                 <select class="span4 expYear" name="doc[expYear]"></select>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <h3 class="form-section">Billing Address</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Address Line 1</label>
                              <div class="controls">
                                 <input type="text" name="doc[addressLine1]" class="m-wrap span8 addressLine1" value="<?=$address1?>">
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
                                 <input type="text" name="doc[addressLine2]" class="m-wrap span8 addressLine2" value="<?=$address2?>">
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
                                 <input type="text" name="doc[city]" class="m-wrap span8 city" value="<?=$city?>">
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
                                 <input type="text" name="doc[stateProvinceRegion]" class="m-wrap span8 stateProvinceRegion" value="<?=$state?>">
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
                                 <input type="text" name="doc[zipPostalCode]" class="m-wrap span8 zipPostalCode" value="<?=$postalCode?>">
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
                                 <input type="text" name="doc[country]" class="m-wrap span8 country" value="<?=$country?>">
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
                                 <input type="text" name="doc[email]" class="m-wrap span8 email" value="<?=$email?>">
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
                                 <input type="text" name="doc[phone]" class="m-wrap span8 phone" value="<?=$phone?>">
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
                        <button type="button" class="btn green"><i class="icon-ok"></i> Submit Payment</button>
                        <button type="button" class="btn cancel">Cancel and Go Back</button>
                     </div>
                  </form>
                  <!-- SUCCESSFUL SAVE MODAL -->
                  <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="save-success-label">Thank You.  Your payment has been processed.</h3>
                     </div>
                     <div class="modal-body">
                        <p>You can either view your receipt by clicking "View Receipt" below or click "Go To Dashboard" to be returned to your Dashboard.</p>
                     </div>
                     <div class="modal-footer">
                        <button class="btn blue continue payment" data-insertid="">View Receipt</button>
                        <button class="btn blue continue dashboard">Go To Dashboard</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  <?=$this->element('js/Payment.js');?>
                  <script>
                  jQuery(document).ready(function() {    
                     io.saw.Payment.otherInit();
                  });      
                  </script>
                  <!--/ PAYMENT ELEMENT -->
               </div>
            </div>
            <!--/ PAYMENT -->

            <!-- END PAGE CONTENT-->
         </div>
         <!-- END PAGE CONTAINER-->    
      </div>
      <!-- END PAGE -->