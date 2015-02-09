                  <!-- PAYMENT ELEMENT -->
                  <style>
                  .card {
                  float: left;
                  width: 39px;
                  height: 25px;
                  text-indent: -9999px;
                  background-position: 0 0;
                  background-repeat: no-repeat;
                  padding-right: 2px;
                  }
                  
                  .card.visa {
                  background-image: url('/assets/img/card-visa.gif');
                  }
                  .card.master {
                  background-image: url('/assets/img/card-mastercard.gif');
                  }
                  .card.amex {
                  background-image: url('/assets/img/card-amex.gif');
                  }
                  .card.discover {
                  background-image: url('/assets/img/card-discover.gif');
                  }
                  </style>
                        
                  
                  <form id="payment-form" class="horizontal-form portlet">
                     <!-- ERROR -->
                     <div class="alert alert-error hide">
                        <button class="close" data-dismiss="alert"></button>
                        You have some form errors. Please check below.
                     </div>
                     <!--/ ERROR -->
                     <input type="hidden" class="memberId" name="doc[memberId]" value="<?=(!empty($memberId)) ? $memberId : ''?>">
                     <input type="hidden" class="ownerId" name="doc[ownerId]" value="<?=$ownerId?>">
                     <input type="hidden" class="ownerClass" name="doc[ownerClass]" value="<?=$ownerClass?>">
                     <input type="hidden" class="description" name="doc[description]" value="<?=$description?>">
                     <input type="hidden" class="title" name="doc[title]" value="<?=$title?>">
                     <input type="hidden" class="cardType" name="doc[cardType]" value="">
                     <input type="hidden" class="token" name="doc[token]" value="">
                     <? 
                     $user = $this->app['session']->get('user');
                     $accessLevel = $user['accessLevel'];
                     $user_id = $user['user_id'];
                     ?>
                     <? if($accessLevel == ADMIN): ?>
                     <h3 class="form-section">Payment Adjustment (admin only)</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Amount To Pay</label>
                              <div class="controls">
                                 <div class="input-prepend input-append">
                                    <span class="add-on">$ </span>
                                       <input type="text" name="doc[amount]" class="m-wrap span8 amount" value="<?=$amount?>">
                                    <span class="add-on">.00</span>
                                 </div>
                                 <span class="help-block">A receipt with this amount will be created.</span>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <? else: ?>
                        <input type="hidden" class="amount" name="doc[amount]" value="<?=$amount?>">
                     <? endif; ?>

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
                                 <input type="text" name="doc[name]" class="m-wrap span8 name" value="<?=(isset($name) && !empty($name)) ? $name : $firstName.' '.$lastName?>">
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
                                 <input type="text" name="doc[number]" class="m-wrap span8 number" value="<?=(isset($number) && !empty($number)) ? $number : ''?>">
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
                                 <input type="text" name="doc[cvc]" class="m-wrap span8 cvc" value="<?=(isset($cvc) && !empty($cvc)) ? $cvc : ''?>">
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
                                 <select id="ccard-expMonth" class="span4 expMonth" name="doc[expMonth]"></select>
                                 <select id="ccard-expYear" class="span4 expYear" name="doc[expYear]"></select>
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
                                 <input type="text" name="doc[zipPostalCode]" class="m-wrap span8 zipPostalCode" value="<?if(strlen($postalCode) < 5){echo str_pad($postalCode,5,'0',STR_PAD_LEFT);}else if(strlen($postalCode) > 5 && strlen($postalCode) < 9){str_pad($postalCode,9,'0',STR_PAD_LEFT);}else{echo $postalCode;}?>">
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
                           if($user['accessLevel'] >= EDITOR && ($user['accessLevel'] == ADMIN  || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') ))){  
                        ?>
                        <input type="checkbox" name="suppress_emails" <?=(array_key_exists('suppress_emails',$user) && !empty($user['suppress_emails']))?'checked':'';?> value="yes">Suppress Emails.
                        <? } ?>
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
                        <? $accessLevel = call_user_func(function($app){ $user = $app['session']->get('user'); return $user['accessLevel'];},$this->app); ?>
                        <? if($accessLevel >= EDITOR):?>
                        <button class="btn yellow continue applications"><?=$redirect_label?></button>
                        <? endif; ?>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  
                  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
                  <?
                  ## stripe
                  //echo $this->element('js/Payment.js');
                  ## fdgg
                  echo $this->element('js/PaymentFDGG.js');
                  ?>      
                  <script>
                  jQuery(document).ready(function() {    
                     io.saw.Payment.init(<?=$chargeOnSuccess?>);

                     <? if($accessLevel >= EDITOR):?>
                     $('#save-success .continue.applications').click(function(e){
                        document.location.href='<?=$redirect_url?>';
                     });   
                     <? endif; ?>


                     <? if(isset($expMonth) && !empty($expMonth)): ?>
                        // STORE CARD STUFF
                        var smonth = '<?=$expMonth?>';
                        var syear = '<?=$expYear?>';
                        $('#ccard-expMonth option[value='+smonth+']').attr('selected', 'selected');
                        $('#ccard-expYear option[value=20'+syear+']').attr('selected', true);
                     <? endif; ?>
                  });      
                  </script>
                  <!--/ PAYMENT ELEMENT -->