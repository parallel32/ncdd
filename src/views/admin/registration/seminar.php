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
                  <img src="/assets/img/ncdd-login2-logo.png">
                  <br/>Seminar Registration Form
               </h3>
               <h3 class="text-center">
                  <?=$this->vars['seminar']['headline']?>
                  <br/><?=$this->vars['seminar']['location']?>
                  <br/><?=$this->vars['seminar']['startDate']['monthDay']?> - <?=$this->vars['seminar']['endDate']['monthDay']?>, <?=$this->vars['seminar']['startDate']['year']?>
               
               </h3>
               <p class="text-center">
                  
                  <br/>National College for DUI Defense, Inc. 
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
         <div class="row-fluid">
            <div class="span12">
               <!-- BEGIN FORM-->
               <form id="signin-form" class="form-horizontal portlet" novalidate="novalidate">
                  <input type="hidden" name="doc[message]" value="You will be redirected back to the registration form after sign in.">
                  <input type="hidden" name="doc[redirect]" value="/registration/seminar/<?=$this->vars['seminar']['_id']?>/<?=$this->vars['seminar']['slug']?>">
               </form>
               
               <form id="saw-form" class="horizontal-form portlet">
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>         
                  
                  <? if(!$signed_in):?>
                  <h3 class="form-section">If you're a member please sign in.</h3>
                  <button type="button" class="btn blue signin"><i class="icon-key"></i> Sign In</button>
                  <script>
                     jQuery(document).ready(function() {    
                        $('#saw-form .signin').click(function(e){
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
                  <? endif; ?>
                  <h3 class="form-section">1. Your Information</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Name</label>
                           <div class="controls">
                              <? $middleName = (!empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' '; ?>
                              <input type="text" name="doc[name]" value="<?=($signed_in) ? $this->vars['member']['firstName'].$middleName.$this->vars['member']['lastName'] :'' ?>" class="m-wrap span12 firstName">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label">Telephone</label>
                           <div class="controls">
                              <input id="phone" type="text" name="doc[phone]" value="<?=($signed_in) ? $this->vars['member']['primaryPhone'] :'' ?>" class="m-wrap span12 phone">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group ">
                           <label class="control-label">Facsimile</label>
                           <div class="controls">
                              <input id="fax" type="text" name="doc[fax]" value="<?=($signed_in) ? $this->vars['member']['primaryFax'] :'' ?>" class="m-wrap span12 fax">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Bar Number / State</label>
                           <div class="controls">
                              <input type="text" name="doc[barNumber]" value="<?=($signed_in) ? $this->vars['member']['barNumber'] :'' ?>" class="m-wrap span12 barNumber">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Email</label>
                           <div class="controls">
                              <input type="text" name="doc[email]" value="<?=($signed_in) ? $this->vars['member']['email'] :'' ?>" class="m-wrap span12 email">
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- BEGIN ADDRESS -->
                  <h3 class="form-section">2. Address</h3>
                  
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 1</label>
                           <div class="controls">
                              <input type="text" id="address1" name="doc[address1]" value="<?=($signed_in) ? $this->vars['location']['addressLine1'] :'' ?>" class="m-wrap span12 address1">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Address 2</label>
                           <div class="controls">
                              <input type="text" id="address2" name="doc[address2]" value="<?=($signed_in) ? $this->vars['location']['addressLine2'] :'' ?>" class="m-wrap span12 address2">
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >City</label>
                           <div class="controls">
                              <input type="text" id="city" name="doc[city]" value="<?=($signed_in) ? $this->vars['location']['city'] :'' ?>" class="m-wrap span12 city"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >State / Province</label>
                           <div class="controls">
                              <input type="text" id="state" name="doc[state]" value="<?=($signed_in) ? $this->vars['location']['state'] :'' ?>" class="m-wrap span12 state"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!--/row-->           
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Postal Code</label>
                           <div class="controls">
                              <input type="text" id="zip" name="doc[postalCode]" value="<?=($signed_in) ? $this->vars['location']['zip'] :'' ?>" class="m-wrap span12 postalCode"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Country</label>
                           <div class="controls">
                              <input type="text" id="country" name="doc[country]" value="<?=($signed_in) ? $this->vars['location']['country'] :'' ?>" class="m-wrap span12 country"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <!-- END ADDRESS -->
                  <h3 class="form-section">3. Registration Details</h3>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Name for Name Tag</label>
                           <div class="controls">
                              <input type="text" name="doc[nameTag]" value="<?=($signed_in) ? $this->vars['member']['firstName'].$middleName.$this->vars['member']['lastName'] :'' ?>" class="m-wrap span12 nameTag"> 
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Attendees Dinner RSVP</label>
                           <div class="controls">
                              <input type="text" name="doc[dinnerRSVP]" class="m-wrap span12 dinnerRSVP"> 
                              <span class="help-block">Please enter how many people you would like to RSVP for the dinner (2 maximum).</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  </br></br>
                  <h3 class="form-section">4. Attendance Certification Statement</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">I acknowledge that the National College for DUI Defense does not allow attendance by jurists or prosecutors except upon special written invitation.  Accordingly, I hereby certify that I am not a full time judicial officer or full time prosecutor and that I am actively engaged in the defense of criminal cases.
                           </br>
                           </label>
                           </br>
                           <label class="control-label">By printing your name you acknowledge the above statements.</label>
                           <div class="controls">
                              <div class="input-prepend input-append">
                                 <span class="add-on">Printed Name </span>
                                 <input name="doc[executedPrintedName]" class="m-wrap span12 executedPrintedName" type="text" placeholder="">
                                 <span class="add-on">, on this <? $date = new \DateTime(); echo $date->format('dS');?> day of <?echo $date->format('F');?>, 20<?echo $date->format('y');?></span>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  </br></br>
                  <h3 class="form-section">5. Payment</h3>
                  <div class="row-fluid addr ">
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Registration Fee</label>
                           <div class="controls">
                              <div class="input-prepend input-append">
                                  <span class="add-on">$ </span>
                                     <input type="text" disabled value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>" class="m-wrap span12"> 
                                  <span class="add-on">.00</span>
                              </div>
                              <span class="help-block">**CD of materials will be included in the registration fee.**</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                     <div class="span6 ">
                        <div class="control-group">
                           <label class="control-label" >Would you like to pre-order a hard copy of the materials?</label>
                           <div class="controls">
                              <select name="doc[hardCopyYesNo]" class="span6 m-wrap hardcopyYesNo">
                                 <option value="NO">NO</option>
                                 <option value="YES">YES</option>
                              </select>
                              <span class="help-block">If yes, an additional charge of $<?=$this->vars['seminar']['register']['hardCopyPrice']?> will be added.</span>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" >Total Fee</label>
                           <div class="controls">
                              <div class="input-prepend input-append">
                                  <span class="add-on">$ </span>
                                     <input type="text" disabled value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>" class="m-wrap span12"> 
                                  <span class="add-on">.00</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="pull-left">
                           <h4>Click to: </h4>
                           <button type="button" class="btn blue check">Pay By Check</button>&nbsp;&nbsp;OR&nbsp;&nbsp; 
                           <button type="button" class="btn blue credit">Pay by Credit Card</button>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  </br>
                  </br>
                  </br>
                  </br>
                  
                  <!-- SUCCESSFUL SAVE MODAL -->
                  <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="save-success-label">Thank you, your Registration is complete.  You will receive an email confirmation in the email you provided.</h3>
                     </div>
                     <div class="modal-body">
                        <p></p>
                     </div>
                     <div class="modal-footer">
                        <button class="btn blue continue" data-insertid="">Return to NCDD.com</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  
               </form>
               <!-- END FORM--> 













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
                     <input type="hidden" class="memberId" name="doc['payment'][memberId]" value="<?=($signed_in) ? $this->vars['member']['_id']: '';?>">
                     <input type="hidden" class="ownerId" name="doc['payment'][ownerId]" value="<?=$this->vars['seminar']['_id']?>">
                     <input type="hidden" class="ownerClass" name="doc['payment'][ownerClass]" value="RegistrationSeminar">
                     <input type="hidden" class="description" name="doc['payment'][description]" value="<?='INV-'.time();?>">
                     <input type="hidden" class="title" name="doc['payment'][title]" value="<?=$this->vars['seminar']['headline'].' '.$this->vars['seminar']['location'].' '.$this->vars['seminar']['startDate']['monthDay'].' - '.$this->vars['seminar']['endDate']['monthDay'].', '.$this->vars['seminar']['startDate']['year']?>">
                     <input type="hidden" class="amount" name="doc['payment'][amount]" value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>">
                     <input type="hidden" class="cardType" name="doc['payment'][cardType]" value="">
                     <input type="hidden" class="token" name="doc['payment'][token]" value="">
                     <h3 class="form-section">Pay By Credit Card</h3>
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
                                 <input type="text" name="doc['payment'][name]" class="m-wrap span8 name" value="<?=($signed_in) ? $this->vars['member']['firstName'].$middleName.$this->vars['member']['lastName']: ''?>">
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
                                 <input type="text" name="doc['payment'][number]" class="m-wrap span8 number">
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
                                 <input type="text" name="doc['payment'][cvc]" class="m-wrap span8 cvc">
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
                                 <select class="span4 expMonth" name="doc['payment'][expMonth]"></select>
                                 <select class="span4 expYear" name="doc['payment'][expYear]"></select>
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
                                 <input type="text" name="doc['payment'][addressLine1]" class="m-wrap span8 addressLine1" value="<?=($signed_in) ? $this->vars['location']['addressLine1']: ''?>">
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
                                 <input type="text" name="doc['payment'][addressLine2]" class="m-wrap span8 addressLine2" value="<?=($signed_in) ? $this->vars['location']['addressLine2']: ''?>">
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
                                 <input type="text" name="doc['payment'][city]" class="m-wrap span8 city" value="<?=($signed_in) ? $this->vars['location']['city']: ''?>">
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
                                 <input type="text" name="doc['payment'][stateProvinceRegion]" class="m-wrap span8 stateProvinceRegion" value="<?=($signed_in) ? $this->vars['location']['state']: ''?>">
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
                                 <input type="text" name="doc['payment'][zipPostalCode]" class="m-wrap span8 zipPostalCode" value="<?=($signed_in) ? $this->vars['location']['zip']: ''?>">
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
                                 <input type="text" name="doc['payment'][country]" class="m-wrap span8 country" value="<?=($signed_in) ? $this->vars['location']['country']: ''?>">
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
                                 <input type="text" name="doc['payment'][email]" class="m-wrap span8 email" value="<?=($signed_in) ? $this->vars['member']['email']: ''?>">
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
                                 <input type="text" name="doc['payment'][phone]" class="m-wrap span8 phone" value="<?=($signed_in) ? $this->vars['member']['primaryPhone']: ''?>">
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
                        <button type="button" class="btn green"><i class="icon-ok"></i> Submit Registration</button>
                        <button type="button" class="btn cancel">Cancel and Go Back</button>
                     </div>
                  </form>
                  <!--/ PAYMENT ELEMENT -->














            </div>
         </div>
         <!-- END PAGE CONTENT-->

   </div>
   <!-- END PAGE CONTAINER -->
</div>
<!-- END CONTAINER -->
<?=$this->element('js/Registration.js');?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
(function( Payment, $, undefined ) {
   
   var params = {};

   function validateCVC(cvc){
      if(Stripe.validateCVC(cvc.val())){
         cvc.parents('.control-group').removeClass('error');// remove the red highlight
         cvc.next('.help-inline').remove(); // remove the error text
         $('#payment-form .control-group').find('.help-block.error').remove(); // remove help blocks too
      }else{
         // bootstrap field to red with error message
         cvc.parents('.control-group').addClass('error');
         if(cvc.next('.help-inline').length == 0){
            cvc.after('<span class="help-inline">A valid security code is required.</span>');
         }
      }
   }
   function validateCardNumber(card){
      if(Stripe.validateCardNumber(card.val())){
            card.parents('.control-group').removeClass('error');// remove the red highlight
            card.next().remove(); // remove the error text
            $('#payment-form .control-group').find('.help-block.error').remove(); // remove help blocks too
            $('#payment-form .card').css('backgroundPosition','0 -25px');
            switch (Stripe.cardType(card.val())){
               case 'Visa':
                  $('#payment-form .card.visa').css('backgroundPosition','0 0px');
                  break;
               case 'MasterCard':
                  $('#payment-form .card.master').css('backgroundPosition','0 0px');
                  break;
               case 'American Express':
                  $('#payment-form .card.amex').css('backgroundPosition','0 0px');
                  break;
               case 'Discover':
                  $('#payment-form .card.discover').css('backgroundPosition','0 0px');
                  break;         
            }
            $('#payment-form .cardType').html(Stripe.cardType(card.val()));
         }else{
            // bootstrap field to red with error message
            card.parents('.control-group').addClass('error');
            if(card.next('.help-inline').length == 0){
               card.after('<span class="help-inline">A valid card number is required.</span>');
            }
         }
   }
   function createStripeToken(){

      Stripe.setPublishableKey("<?=SAW_STRIPE_PUBLIC_KEY?>");
      $('#payment-form .btn.green').html('<i class="icon-time"></i> Validating Your Card..');
      $('#payment-form .btn.green').attr("disabled", "disabled");

      Stripe.createToken({
         name: $('#payment-form .name').val(),
         number: $('#payment-form .number').val(),
         cvc: $('#payment-form .cvc').val(),
         exp_month: $('#payment-form .expMonth').val(), 
         exp_year: $('#payment-form .expYear').val(),
         address_line1:$('#payment-form .addressLine1').val(),
         address_line2:$('#payment-form .addressLine2').val(),
         address_state:$('#payment-form .stateProvinceRegion').val(),
         address_zip:$('#payment-form .zipPostalCode').val(),
         address_country:$('#payment-form .country').val()
      },function(status, response) {
         if (status >= 400) { // we have an error
            // re-enable the submit button
            $('#payment-form .btn.green').removeAttr("disabled");
            $('#payment-form .btn.green').html('<i class="icon-ok"></i> Submit Payment');

            // process the error
            if(response.hasOwnProperty('error')){
               $('#payment-form .control-group.'+response.error.param).addClass('error');
               $('#payment-form .control-group.'+response.error.param+' :input').after('<span class="help-inline">'+response.error.message+'</span>');            
            }
            // set response message
            $('#payment-form .alert-error').removeClass('hide').html('<span>'+response.error.message+'</span>');
            $('#payment-form .control-group :input.'+response.error.param).parents('.control-group').addClass('error');
            $('#payment-form .control-group :input.'+response.error.param).parents('.controls').append(
            '<span for="'+response.error.param+'" class="help-block error pulsate" style="">'+response.error.message+'</span>'
            );

            // finally re-set the token field to blank
            $('#payment-form .token').val('');
         } else {
            // payment button text
            $('#payment-form .btn.green').html('<i class="icon-time"></i> Processing Your Payment..');
            // remove errors
            $('#payment-form .control-group').find('.help-block.error').remove();
            $('#payment-form .error').removeClass('error');
            $('#payment-form .alert-error').addClass('hide')

            // set returned values to the form
            $('#payment-form .token').val(response.id);
            // in case of a form validation error we need to save the credit card number because on the next save stripe will have to re-process
            Payment.hold_card = $('#payment-form .number').val();
            $('#payment-form .number').val(response.card.last4);
            $('#payment-form .cardType').val(response.card.type);

            // and submit
            io.saw.Payment.charge();
         }
      });// end Stripe.createToken
   }
   Payment.hold_card = '';
   Payment.charge = function (){
      io.saw.FormPost.activate({postUrl:'/payment/charge'
         ,formName:'#payment-form'
         ,serializeSelector:':input'
         ,postOnComplete:function(responseObj,responseStatus){
               $('#payment-form .number').val(io.saw.Payment.hold_card);
               if(responseStatus == 'success'){
            
            }else{
                  var responseObj = $.parseJSON(responseObj.responseText);
               }
         }
         ,postOnSuccess:function(responseObj){
               $('#save-success').modal({keyboard: false});       
               $('#payment-form .btn.green').prop("disabled",true);
               $('#payment-form .btn.green').html('<i class="icon-ok"></i> Payment Successful');
               params.chargeOnSuccess(responseObj,responseObj.paymentId.$id);
         }
         ,postOnErrors:function(responseObj){
               $('#payment-form .btn.green').removeAttr("disabled");
            $('#payment-form .btn.green').html('<i class="icon-ok"></i> Submit Payment - try again');
            
         }
      });      
   };
   Payment.refund = function (){
      io.saw.FormPost.activate({postUrl:'/payment/refund'
         ,formName:'#payment-form'
         ,serializeSelector:':input'
         ,postOnComplete:function(responseObj,responseStatus){
               if(responseStatus == 'success'){
               
               }else{
                  var responseObj = $.parseJSON(responseObj.responseText);
               }
         }
         ,postOnSuccess:function(responseObj){}
      });      
   }; 
   Payment.init = function(p){
      params = p;
      params.chargeOnSuccess = params.chargeOnSuccess || function(){};
      
      $('#payment-form input').keypress(function (e) {
         if (e.which == 13) {
            validateCardNumber($('#payment-form .number'));
            validateCVC($('#payment-form .cvc'));
            createStripeToken();
         }
      });
      $('#payment-form .btn.green').click(function(e){
         createStripeToken();
      });
      $('#payment-form .btn.cancel').click(function(e){
         document.location.href='/';
      });
      $('#save-success .continue.payment').click(function(e){
         document.location.href='/payment/'+$(this).attr('data-insertid')+'/view';
      });
      $('#save-success .continue.dashboard').click(function(e){
         document.location.href='/';
      });
      


      // prepare the month dropdown
      var select = $("#payment-form .expMonth"),
      month = new Date().getMonth() + 1;
      for (var i = 1; i <= 12; i++) {
         select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
      }

      // prepare the year dropdown
      var select = $("#payment-form .expYear"),
      year = new Date().getFullYear();

      for (var i = 0; i < 12; i++) {
         select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
      }

      // validate card number
      $('#payment-form .number').blur(function(){
         validateCardNumber($(this));
      });
      // validate cvc check
      $('#payment-form .cvc').blur(function(){
         validateCVC($(this));
      });
         
   };
   Payment.indexInit = function(){
      $('.btn.blue.mini.view').click(function(e){
         document.location.href='/payment/'+$(this).attr('data-id')+'/view';
      });   
      $('.btn.cancel').click(function(e){
         document.location.href='/payment';
      });   

   }
   
}( io.saw.Payment = io.saw.Payment || {}, io.saw.jQuery || jQuery ));
</script>
<script>
jQuery(document).ready(function() {    
   io.saw.Registration.init();
   io.saw.Payment.init({chargeOnSuccess:function(responseObj,paymentId){
      $('#save-success .continue.payment').attr('data-insertid',paymentId);
      io.saw.FormGet.activate({postUrl:'/registration/seminar/register/'+paymentId
         ,postOnComplete:function(responseObj,responseStatus){}
         ,postOnSuccess:function(responseObj){
            //document.location.href='/applications';
         }
      });
   }});
   
   $('#saw-form .hardcopyYesNo').change(function(e){
      console.log($('#saw-form .hardcopyYesNo options:selected').val());
   });
   
});      
</script>