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
                  <p><h3>To pay by credit card on behalf of the member:</h3></p> <a class="btn blue" href="/registration/seminar/<?=$this->vars['registration']['_id']?>/pay"><i class="icon-money"></i> Goto the Credit Card Form</a>
               </div>
            </div>
            <hr />
            
            <div class="row-fluid invoice">
               <div class="row-fluid invoice-logo">
                  <div class="span6 invoice-logo-space"><img src="/assets/img/ncdd-login2-logo.png" alt="" /> </div>
                  <div class="span6">
                     <p>#<?=$this->vars['registration']['_id']?> / <? $date = new \DateTime(); echo $date->format('d');?> <?echo $date->format('M');?>, <?echo $date->format('Y');?> <span class="muted">Registration ID and Date</span></p>
                  </div>
               </div>
               <hr />
               <div class="row-fluid">
                  <div class="span3">
                     <h4>Member:</h4>
                     <ul class="unstyled">
                        <li><?=$this->vars['registration']['name']?></li>
                        <li>
                           <?=$this->vars['registration']['address1']?><?=(!empty($this->vars['registration']['address2'])) ?' '.$this->vars['registration']['address2'] :'' ;?>
                           <?=$this->vars['registration']['city']?>, <?=$this->vars['registration']['state']?> <?=$this->vars['registration']['country']?>
                        </li>
                        <li>email: <?=$this->vars['registration']['email']?></li>
                        <li>phone: <?=$this->vars['registration']['phone']?></li>
                        <li>fax: <?=$this->vars['registration']['fax']?></li>
                     </ul>
                  </div>
                  <div class="span4">
                     <h4>About:</h4>
                     <ul class="unstyled">
                        <li><?=$this->vars['registration']['type']?></li>
                        <li><?=$this->vars['registration']['attendanceCertificationStatement']?></li>
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
                        <? //echo "<pre>";print_r($this->vars['registration']);echo "</pre>";
                           /*
                           if(array_key_exists('deposit',$this->vars['seminar']['register'])
                              && array_key_exists('depositQuestion',$this->vars['registration']) 
                              && !empty($this->vars['registration']['deposit']) 
                              && $this->vars['registration']['depositQuestion'] == 'yes'):
                              //*/
                           if($this->vars['registration']['currentStatus'] == \Saw\Model\Registration::$status['DEPOSIT']):
                              
                              $this->vars['registration']['registrationFee'] = $this->vars['registration']['deposit'];
                              $label = 'Registration Deposit';

                           elseif($this->vars['registration']['currentStatus'] == \Saw\Model\Registration::$status['DEPOSITBALANCE']):
                              $this->vars['registration']['registrationFee'] = (int)$this->vars['registration']['registrationFeeOriginal'] - (int)$this->vars['registration']['deposit'];
                              $label = 'Registration Balance Due';
                           else:
                              $label = "Registration Full Payment";
                           endif;
                        ?>
                        <tr>
                           <td>1</td>
                           <td><?=$label?></td>
                           <td class="hidden-480"><?=$this->vars['registration']['type']?></td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">$<?=$this->vars['registration']['registrationFee']?></td>
                           <td>$<?=$this->vars['registration']['registrationFee']?></td>
                        </tr>
                        
                        <? $amount = $this->vars['registration']['registrationFee']; ?>
                        <? if(array_key_exists('hardCopy',$this->vars['registration']) && !empty($this->vars['registration']['hardCopy'])): ?>
                        <? if($this->vars['registration']['hardCopy'] == 'YES'): 
                        ?>
                        <tr>
                           <td>2</td>
                           <td>Hard Copy</td>
                           <td class="hidden-480">Printed and Prepared Hard Copy</td>
                           <td class="hidden-480">1</td>
                           <td class="hidden-480">$<?=$this->vars['registration']['hardCopyFee']?></td>
                           <td>$<?=$this->vars['registration']['hardCopyFee']?></td>
                        </tr>
                        <? endif; ?>
                        <? endif; ?>
                     </tbody>
                  </table>
               </div>
               <div class="row-fluid">
                  <div class="span12 invoice-block">
                     <ul class="unstyled amounts">
                        <? if($this->vars['registration']['currentStatus'] == \Saw\Model\Registration::$status['DEPOSITBALANCE']): 
                           $this->vars['registration']['total'] = $this->vars['registration']['registrationFee'];
                           endif; ?>
                        <li><strong>Total:</strong> $<?=$this->vars['registration']['total']?></li>
                     </ul>
                  </div>
               </div>
            </div>
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
                     $memberId = $this->vars['registration']['memberId'];
                     $ownerId = $this->vars['registration']['_id'];
                     $ownerClass = $this->vars['registration']['class'];
                     $description = 'INV-'.time();
                     $title = $label.' - '.$this->vars['registration']['type'].' - '.$this->vars['seminar']['headline'].' - '.$this->vars['seminar']['location'].' - '.$this->vars['seminar']['startDate']['monthDay'].' - '.$this->vars['seminar']['endDate']['monthDay'].', '.$this->vars['seminar']['startDate']['year'];
                     $name = $this->vars['registration']['name'];
                     $email = $this->vars['registration']['email'];
                     $phone = $this->vars['registration']['phone'];
                     $address1 = $this->vars['registration']['address1'];
                     $address2 = $this->vars['registration']['address2'];
                     $city = $this->vars['registration']['city'];
                     $state = $this->vars['registration']['state'];
                     $postalCode = $this->vars['registration']['postalCode'];
                     $country = $this->vars['registration']['country'];
                     ?>
                     <input type="hidden" class="name" name="doc[name]" value="<?=$name?>">
                     <input type="hidden" class="memberId" name="doc[memberId]" value="<?=(!empty($memberId)) ? $memberId: ''?>">
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
                                       <input type="text" name="doc[amount]" class="m-wrap span8 amount" value="<?=$this->vars['registration']['total']?>">
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
                                 <input type="text" name="doc[addressLine1]" class="m-wrap span8 address1" value="<?=$address1?>">
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
                                 <input type="text" name="doc[addressLine2]" class="m-wrap span8 address2" value="<?=$address2?>">
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
                           if($user['accessLevel'] == ADMIN){  
                        ?>
                        <input type="checkbox" name="suppress_emails" <?=(array_key_exists('suppress_emails',$user) && !empty($user['suppress_emails']))?'checked':'';?> value="yes">Suppress Emails.
                        <? } ?>
                        <button data-registration-id="<?=$this->vars['registration']['_id']?>" type="button" class="btn green submit-payment"><i class="icon-ok"></i> Submit Payment</button>
                        <button data-id="<?=$this->vars['registration']['_id']?>" type="button" class="btn cancel">Cancel and Go Back</button>
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
                        <button class="btn yellow continue registrations" data-id="<?=$this->vars['registration']['_id']?>" data-seminar-id="<?=$this->vars['seminar']['_id']?>">Go To Registrations</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  <?=$this->element('js/Registration.js');?>
                  <script>
                  jQuery(document).ready(function() {    
                     io.saw.Registration.paymentInit();
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