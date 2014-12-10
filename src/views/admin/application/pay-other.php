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
                  <p><h3><b>Alternate payment method screen</b></h3></p>
                  <p><h3>To pay by credit card on behalf of the member:</h3></p> <a class="btn blue" href="/application/<?=$this->vars['application']['_id']?>/pay"><i class="icon-money"></i> Goto the Credit Card Form</a>
               </div>
            </div>
            <hr />
            
            <?=$this->element('invoice-block',array('application'=>$this->vars['application'],'member'=>$this->vars['member'],'location'=>$this->vars['location'],'pro_rated_membership_dues'=>$this->vars['pro_rated_membership_dues']));?>
            <?if(false):?>
            <!--/ INVOICE -->

            <!-- ADMIN payment by check .. or reduce the payment amount by adding a discount to the invoice -->
            <!-- an invoice must have a corresponding payment (whether it's a credit card or a record created by the admin when marking an invoice paid) -->
            <!-- on this screen you have to mark something paid in order to de-activate it -->
            
            <!-- concept of renewals and trial memberships -->
            <!-- include refunds on already made credit card payments.  refunds on anything else will be used as credits towards future bills or the money will be sent back -->




            <!-- PAYMENT  only show for ADMIN -->
            <?endif;?>
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
                     <?
                     $memberId = $this->vars['application']['memberId'];
                     $ownerId = $this->vars['application']['_id'];
                     $ownerClass = $this->vars['application']['class'];
                     $description = 'INV-'.time();
                     $title = $this->vars['application']['type'];
                     $firstName = $this->vars['application']['firstName'];
                     $lastName = $this->vars['application']['lastName'];
                     $email = $this->vars['application']['email'];
                     $phone = (!empty($this->vars['application']['phone'])) ? $this->vars['application']['phone']: $this->vars['location']['phone'];
                     $address1 = (!empty($this->vars['application']['address1'])) ? $this->vars['application']['address1']: $this->vars['location']['addressLine1'];
                     $address2 = (!empty($this->vars['application']['address2'])) ? $this->vars['application']['address2']: $this->vars['location']['addressLine2'];
                     $city = (!empty($this->vars['application']['city'])) ? $this->vars['application']['city']: $this->vars['location']['city'];
                     $state = (!empty($this->vars['application']['state'])) ? $this->vars['application']['state']: $this->vars['location']['state'];
                     $postalCode = (!empty($this->vars['application']['postalCode'])) ? $this->vars['application']['postalCode']: $this->vars['location']['zip'];
                     $country = (!empty($this->vars['application']['country'])) ? $this->vars['application']['country']: $this->vars['location']['country'];
                     
                     ?>
                     <input type="hidden" class="name" name="doc[name]" value="<?=$firstName.' '.$lastName?>">
                     <input type="hidden" class="memberId" name="doc[memberId]" value="<?=$memberId?>">
                     <input type="hidden" class="ownerId" name="doc[ownerId]" value="<?=$ownerId?>">
                     <input type="hidden" class="ownerClass" name="doc[ownerClass]" value="<?=$ownerClass?>">
                     <input type="hidden" class="description" name="doc[description]" value="<?=$description?>">
                     <input type="hidden" class="title" name="doc[title]" value="<?=$title?>">
                     <input type="hidden" class="type" name="doc[type]" value="check">
                     <h3 class="form-section">Payment Information</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Amount To Pay</label>
                              <div class="controls">
                                 <div class="input-prepend input-append">
                                    <span class="add-on">$ </span>
                                       <input type="text" name="doc[amount]" class="m-wrap span8 amount" value="<?=$this->vars['aamount']?>">
                                    <span class="add-on">.00</span>
                                 </div>
                                 <span class="help-block">A receipt with this amount will be created.</span>
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
                        <? $user = $this->app['session']->get('user');
                           if($user['accessLevel'] == ADMIN || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )){  
                        ?>
                        <input type="checkbox" name="suppress_emails" <?=(array_key_exists('suppress_emails',$user) && !empty($user['suppress_emails']))?'checked':'';?> value="yes">Suppress Emails.
                        <? } ?>
                        <button data-application-id="<?=$this->vars['application']['_id']?>" type="button" class="btn green submit-payment"><i class="icon-ok"></i> Submit Payment</button>
                        <button data-id="<?=$this->vars['application']['_id']?>" type="button" class="btn cancel">Cancel and Go Back</button>
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
                        <button class="btn yellow continue applications">Go To Applications</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  <?=$this->element('js/Application.js');?>
                  <script>
                  jQuery(document).ready(function() {    
                     io.saw.Application.paymentInit();
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