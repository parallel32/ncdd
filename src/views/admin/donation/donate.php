<? if(!empty($this->vars['member'])): 
   $signed_in = true;
else: 
   $signed_in = false;
endif; ?>



<!-- BEGIN CONTAINER -->   
<div class="page-container row-fluid">
   <!-- BEGIN PAGE CONTAINER-->
   <div class="container-fluid">
      <!-- BEGIN PAGE HEADER-->
         <div class="row-fluid">
            <div class="span12">
               <!-- BEGIN PAGE TITLE & BREADCRUMB-->
               <h3 class="page-title text-center">
                  <a href="//<?=SAW_CONSUMER_WEBSITE?>"><img src="<?=SAW_SSL_CDN?>/assets/img/ncdd-login2-logo.png"></a>
                  <br/>NCDD Donations
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
         


         <? if(!$signed_in && empty($this->vars['nlpro'])):?>
         <!-- BEGIN FORM-->
         <form id="signin-form" class="form-horizontal portlet" novalidate="novalidate">
            <input type="hidden" name="doc[message]" value="You will be redirected back to the donation form after sign in.">
            <input type="hidden" name="doc[redirect]" value="/donate">

            <h2 class="form-section"><b>NCDD members can log in to faciliate a donation.</b></h2>
            <button type="button" class="btn big blue signin"><i class="icon-key"></i> <b>Click Here to Log-In</b></button>
            <script>
               jQuery(document).ready(function() {    
                  $('#signin-form .signin').click(function(e){
                     $(this).html('<i class="icon-key"></i> Please wait...');
                     io.saw.FormPost.activate({postUrl:'/flash/set'
                        ,formName:'#signin-form'
                        ,serializeSelector:':input'
                        ,blockUI:'no'
                        ,postOnComplete:function(responseObj,responseStatus){}
                        ,postOnSuccess:function(responseObj){
                           document.location.href='/login';
                        }
                     });
                  });
               });      
            </script>
         </form>
            
         <? endif; ?>


         <!-- END PAGE HEADER-->
         <div class="row-fluid">
            <div class="span12">
               
               <!-- BEGIN FORM-->
               <form id="saw-form" class="horizontal-form portlet">
                  <input type="hidden" class="memberId" name="doc[memberId]" value="<?=($signed_in) ? $this->vars['member']['_id']: '';?>">
                  <input id="currentPaymentType" type="hidden" name="doc[currentPaymentType]" value="<?/*\Saw\Model\Registration::$paymentType['CREDIT']*/?>">
                  <input id="paymentId" type="hidden" name="doc[paymentId]" value="">
                  
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>                                
                  

                  <h3 class="form-section">1. What would you like to put your donation towards?</h3>
                  <h4><b>This is not required but, can be helpful if you want to donate to a specific operation of the College.</b></h4>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label"></label>
                           <div class="controls">
                              <input type="text" name="doc[for]" value="" class="m-wrap span12 for">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <h3 class="form-section">2. Donation Info.</h3>
                  <h4><b>Fill in as much information as you like.  However, we'll need your email address at the very least to send your donation confirmation.</b></h4>
                  <br>
                  <div class="row-fluid">
                     <div class="span4">
                        <div class="control-group">
                           <label class="control-label">First Name</label>
                           <div class="controls">
                              <input type="text" name="doc[firstName]" value="" class="m-wrap span12 firstName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Middle Name</label>
                           <div class="controls">
                              <input type="text" name="doc[middleName]" value="" class="m-wrap span12 middleName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span4 ">
                        <div class="control-group">
                           <label class="control-label">Last Name</label>
                           <div class="controls">
                              <input type="text" name="doc[lastName]" value="" class="m-wrap span12 lastName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Law Firm Name / Name of your practice</label>
                           <div class="controls">
                              <input type="text" name="doc[firmName]" value="" class="m-wrap span12 firmName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Address 1</label>
                           <div class="controls">
                              <input type="text" name="doc[address1]" value="" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Address 2</label>
                           <div class="controls">
                              <input type="text" name="doc[address2]" value="" class="m-wrap span12 address2">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">City</label>
                           <div class="controls">
                              <input type="text" name="doc[city]" value="" class="m-wrap span12 city">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">State / Province</label>
                           <div class="controls">
                              <input type="text" name="doc[state]" value="" class="m-wrap span12 state">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Zip</label>
                           <div class="controls">
                              <input type="text" name="doc[postalCode]" value="" class="m-wrap span12 postalCode">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Country</label>
                           <div class="controls">
                              <input type="text" name="doc[country]" value="" class="m-wrap span12 country">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Phone</label>
                           <div class="controls">
                              <input type="text" name="doc[phone]" value="" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     
                  </div>
                  
                  <div class="row-fluid">
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Email Address</label>
                           <div class="controls">
                              <input type="text" name="doc[email]" value="" class="m-wrap span12 email">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     
                  </div>


                  <h3 class="form-section">3. Amount to Donate</h3>
                  <div class="row-fluid addr ">
                        <div class="span12 ">
                           <div class="control-group">
                              <div class="controls">
                                 <div class="input-prepend input-append">
                                     <span class="add-on">$ </span>
                                        <input name="doc[amount]" id="amount" type="text" autocomplete="off" value="" class="m-wrap span12 amount"> 
                                     <span class="add-on">.00</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     </br>
                     
                  <h3 class="form-section">4. Donation Options</h3>
                     <div class="row-fluid">
                        <div class="span12 ">
                           
                              <button type="button" class="btn blue check">Click to Donate By Check</button>
                              <button type="button" class="btn blue credit">Click to Donate by Credit Card</button>
                           
                        </div>
                     </div>
                     <br><br>


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
                     <div id="payment-form" class="hide">
                        
                        <input type="hidden" class="memberId" name="doc[payment][memberId]" value="<?=($signed_in) ? $this->vars['member']['_id']: '';?>">
                        <input type="hidden" class="description" name="doc[payment][description]" value="<?='INV-'.time();?>">
                        <input type="hidden" class="title" name="doc[payment][title]" value="">
                        <input type="hidden" class="amount" name="doc[payment][amount]" value="">
                        <input type="hidden" class="cardType" name="doc[payment][cardType]" value="">
                        <input type="hidden" class="token" name="doc[payment][token]" value="">

                        <h3 class="form-section">5. Donate By Credit Card</h3>
                        <p>To pay by check, please scroll to the end of the form and click the blue button.</p>
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
                                    <input id="card-name" type="text" autocomplete="on" name="doc[payment][name]" class="m-wrap span8 name" value="<?=($signed_in) ? $this->vars['member']['firstName'].$middleName.$this->vars['member']['lastName']: ''?>">
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
                                    <input id="card-number" type="text" autocomplete="on" name="doc[payment][number]" class="m-wrap span8 number">
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
                                    <input id="card-cvc" type="text" autocomplete="on" name="doc[payment][cvc]" class="m-wrap span8 cvc">
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
                                    <select id="card-expMonth" class="span4 expMonth" name="doc[payment][expMonth]"></select>
                                    <select id="card-expYear" class="span4 expYear" name="doc[payment][expYear]"></select>
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
                                    <input id="card-addressLine1" type="text" autocomplete="on" name="doc[payment][addressLine1]" class="m-wrap span8 addressLine1" value="<?=($signed_in) ? $this->vars['location']['addressLine1']: ''?>">
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
                                    <input id="card-addressLine2" type="text" autocomplete="on" name="doc[payment][addressLine2]" class="m-wrap span8 addressLine2" value="<?=($signed_in) ? $this->vars['location']['addressLine2']: ''?>">
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
                                    <input id="card-city" type="text" autocomplete="on" name="doc[payment][city]" class="m-wrap span8 city" value="<?=($signed_in) ? $this->vars['location']['city']: ''?>">
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
                                    <input id="card-stateProvinceRegion" type="text" autocomplete="on" name="doc[payment][stateProvinceRegion]" class="m-wrap span8 stateProvinceRegion" value="<?=($signed_in) ? $this->vars['location']['state']: ''?>">
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
                                    <input id="card-zipPostalCode" type="text" autocomplete="on" name="doc[payment][zipPostalCode]" class="m-wrap span8 zipPostalCode" value="<?if($signed_in){if(strlen($this->vars['location']['zip']) < 5){echo str_pad($this->vars['location']['zip'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['location']['zip']) > 5 && strlen($this->vars['location']['zip']) < 9){str_pad($this->vars['location']['zip'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['location']['zip'];}}?>">
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
                                    <input id="card-country" type="text" autocomplete="on" name="doc[payment][country]" class="m-wrap span8 country" value="<?=($signed_in) ? $this->vars['location']['country']: ''?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>
                        <h3 class="form-section">Credit Card Contact Information</h3>
                        <div class="row-fluid">
                           <div class="span8 ">
                              <div class="control-group ">
                                 <label class="control-label">Email</label>
                                 <div class="controls">
                                    <input id="card-email" type="text" autocomplete="on" name="doc[payment][email]" class="m-wrap span8 email" value="<?=($signed_in) ? $this->vars['member']['email']: ''?>">
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
                                    <input id="card-phone" type="text" autocomplete="on" name="doc[payment][phone]" class="m-wrap span8 phone" value="<?=($signed_in) ? $this->vars['member']['primaryPhone']: ''?>">
                                 </div>
                              </div>
                           </div>
                           <!--/span-->
                        </div>                     
                     </div>
                     <!--/ PAYMENT ELEMENT -->
                     
                  <!-- SUCCESSFUL SAVE MODAL -->
                  <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="save-success-label">Successful Registration</h3>
                     </div>
                     <div class="modal-body">
                        <p></p>
                     </div>
                     <div class="modal-footer">
                        <button class="btn blue continue" data-insertid="">Return to NCDD.com</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->


                  <div  id="payment-form-check" class="hide">
                     <h3 class="form-section">5. Donate By Mailing a Check</h3>
                     <div class="row-fluid">
                        <div class="span12 ">
                           <h4 class="form-section">Please send a payment to the address below and make it payable to NCDD.</h4>
                           <p class=""><h4>
                              <br/>National College for DUI Defense, Inc. 
                              <br/>445 S. Decatur St. 
                              <br/>Montgomery, AL 36104
                              <br><br/>Tel: 334-264-1950 
                              <br/>Fax: 334-264-1920
                              </h4>
                           </p>
                        </div>
                        <!--/span-->
                     </div>
                  </div>
                  

                  <!-- ERROR -->
                     <div class="alert alert-error hide">
                        <button class="close" data-dismiss="alert"></button>
                        You have some form errors. Please check below.
                     </div>
                     <!--/ ERROR -->
                  
                     <div id="submit-donation-buttons" class="form-actions text-center">
                        <? $user = $this->app['session']->get('user');
                           if(is_array($user) && (array_key_exists('accessLevel', $user) && $user['accessLevel'] == ADMIN) || ((is_array($user)) && array_key_exists('enable_admin', $user) && ($user['enable_admin'] == 'ON') )){  
                        ?>
                        <input type="checkbox" name="suppress_emails" <?=(array_key_exists('suppress_emails',$user) && !empty($user['suppress_emails']))?'checked':'';?> value="yes">Suppress Emails.
                        <? } ?>
                        
                        <button type="button" class="btn green submit-donation"><i class="icon-ok"></i> Submit Donation</button>
                        
                        <button type="button" class="btn cancel-donation">Cancel and Go Back</button>
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


<?=$this->element('js/Donate.js');?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<?=$this->element('js/Donate-view.js');?>
