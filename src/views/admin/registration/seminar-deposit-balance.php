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
               </h3>
               <div class="alert alert-info text-center">
                  <h3><b>Registration Balance Due - Payment Form</b></h3>
               </div>
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
               
               <? if(!$signed_in):?>
               <!-- BEGIN FORM-->
               <form id="signin-form" class="form-horizontal portlet" novalidate="novalidate">
                  <input type="hidden" name="doc[message]" value="You will be redirected back to the registration form after sign in.">
                  <input type="hidden" name="doc[redirect]" value="/registration/seminar/deposit/<?=$this->vars['registration']['_id']?>">

                  <h3 class="form-section">Members, please sign in to facilitate registration.</h3>
                  <button type="button" class="btn blue signin"><i class="icon-key"></i> Sign In</button>
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

               <? if(!$signed_in && $this->vars['seminar']['register']['currentStatus'] == \Saw\Model\SeminarRegister::$status['MEMBERSONLY']):?>

               <? else: ?>
               <form id="saw-form" class="horizontal-form portlet">
                  <input type="hidden" class="seminarId" name="doc[seminarId]" value="<?=$this->vars['seminar']['_id']?>">
                  <input type="hidden" class="registrationId" name="doc[registrationId]" value="<?=$this->vars['registration']['_id']?>">
                  <input type="hidden" class="memberId" name="doc[memberId]" value="<?=($signed_in) ? $this->vars['member']['_id']: '';?>">
                  <input id="currentPaymentType" type="hidden" name="doc[currentPaymentType]" value="<?=\Saw\Model\Registration::$paymentType['CREDIT']?>">
                  <input id="paymentId" type="hidden" name="doc[paymentId]" value="">
                  
                  <h3 class="form-section">1. Your Information</h3>
                  <div class="row-fluid">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label">Name</label>
                           <div class="controls">
                              <? $middleName = (!empty($this->vars['member']['middleName'])) ? ' '.$this->vars['member']['middleName'].' ':' '; ?>
                              <input type="text" name="doc[name]" value="<?=($signed_in) ? $this->vars['member']['firstName'].$middleName.$this->vars['member']['lastName'] :'' ?>" class="m-wrap span12 name">
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
                              <input type="text" id="zip" name="doc[postalCode]" value="<?if($signed_in){if(strlen($this->vars['location']['zip']) < 5){echo str_pad($this->vars['location']['zip'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['location']['zip']) > 5 && strlen($this->vars['location']['zip']) < 9){str_pad($this->vars['location']['zip'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['location']['zip'];}}?>" class="m-wrap span12 postalCode"> 
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
                  
                  <h3 class="form-section">3. Your Registration Fee Balance Is:</h3>
                  <div class="row-fluid addr ">
                     <div class="span12 ">
                        <div class="control-group">
                           <label class="control-label" ></label>
                           <div class="controls">
                              <div class="input-prepend input-append">
                                  <span class="add-on">$ </span>
                                     <input name="doc[total]" id="total" type="text" disabled value="<?=$this->vars['registration']['registrationFeeOriginal']-$this->vars['registration']['deposit'] ?>" class="m-wrap span12"> 
                                     <input name="doc[registrationFee]" type="hidden" value="<?=$this->vars['registration']['registrationFeeOriginal']-$this->vars['registration']['deposit'] ?>" class="m-wrap span12"> 
                                     <input name="doc[registrationFeeOriginal]" type="hidden" value="<?=($signed_in) ? $this->vars['seminar']['register']['memberPrice'] :$this->vars['seminar']['register']['nonMemberPrice'] ?>" class="m-wrap span12"> 
                                  <span class="add-on">.00</span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--/span-->
                  </div>
                  </br>
                  
                  <!-- SUCCESSFUL SAVE MODAL -->
                  <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="save-success-label">Successful Seminar Deposit Balance Payment</h3>
                     </div>
                     <div class="modal-body">
                        <p></p>
                     </div>
                     <div class="modal-footer">
                        <button class="btn blue continue" data-insertid="">Return to NCDD.com</button>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  



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
                  <div id="payment-form">
                     
                     <input type="hidden" class="ownerId" name="doc[payment][ownerId]" value="<?=$this->vars['registration']['_id']?>">
                     <input type="hidden" class="ownerClass" name="doc[payment][ownerClass]" value="RegistrationSeminar">
                     <input type="hidden" class="memberId" name="doc[payment][memberId]" value="<?=($signed_in) ? $this->vars['member']['_id']: '';?>">
                     <input type="hidden" class="description" name="doc[payment][description]" value="<?='INV-'.time();?>">
                     <input type="hidden" class="title" name="doc[payment][title]" value="DEPOSIT BALANCE PAID - <?=$this->vars['seminar']['headline'].' - '.$this->vars['seminar']['location'].' - '.$this->vars['seminar']['startDate']['monthDay'].' - '.$this->vars['seminar']['endDate']['monthDay'].', '.$this->vars['seminar']['startDate']['year']?>">
                     <input type="hidden" class="amount" name="doc[payment][amount]" value="<?=$this->vars['registration']['registrationFeeOriginal']-$this->vars['registration']['deposit'] ?>">
                     <input type="hidden" class="cardType" name="doc[payment][cardType]" value="">
                     <input type="hidden" class="token" name="doc[payment][token]" value="">
                     <h3 class="form-section">6. Pay By Credit Card</h3>
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
                                 <input id="card-name" type="text" name="doc[payment][name]" class="m-wrap span8 name" value="<?=($signed_in) ? $this->vars['member']['firstName'].$middleName.$this->vars['member']['lastName']: ''?>">
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
                                 <input id="card-number" type="text" name="doc[payment][number]" class="m-wrap span8 number">
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
                                 <input id="card-cvc" type="text" name="doc[payment][cvc]" class="m-wrap span8 cvc">
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
                                 <input id="card-addressLine1" type="text" name="doc[payment][addressLine1]" class="m-wrap span8 addressLine1" value="<?=($signed_in) ? $this->vars['location']['addressLine1']: ''?>">
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
                                 <input id="card-addressLine2" type="text" name="doc[payment][addressLine2]" class="m-wrap span8 addressLine2" value="<?=($signed_in) ? $this->vars['location']['addressLine2']: ''?>">
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
                                 <input id="card-city" type="text" name="doc[payment][city]" class="m-wrap span8 city" value="<?=($signed_in) ? $this->vars['location']['city']: ''?>">
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
                                 <input id="card-stateProvinceRegion" type="text" name="doc[payment][stateProvinceRegion]" class="m-wrap span8 stateProvinceRegion" value="<?=($signed_in) ? $this->vars['location']['state']: ''?>">
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
                                 <input id="card-zipPostalCode" type="text" name="doc[payment][zipPostalCode]" class="m-wrap span8 zipPostalCode" value="<?if($signed_in){if(strlen($this->vars['location']['zip']) < 5){echo str_pad($this->vars['location']['zip'],5,'0',STR_PAD_LEFT);}else if(strlen($this->vars['location']['zip']) > 5 && strlen($this->vars['location']['zip']) < 9){str_pad($this->vars['location']['zip'],9,'0',STR_PAD_LEFT);}else{echo $this->vars['location']['zip'];}}?>">
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
                                 <input id="card-country" type="text" name="doc[payment][country]" class="m-wrap span8 country" value="<?=($signed_in) ? $this->vars['location']['country']: ''?>">
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
                                 <input id="card-email" type="text" name="doc[payment][email]" class="m-wrap span8 email" value="<?=($signed_in) ? $this->vars['member']['email']: ''?>">
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
                                 <input id="card-phone" type="text" name="doc[payment][phone]" class="m-wrap span8 phone" value="<?=($signed_in) ? $this->vars['member']['primaryPhone']: ''?>">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>                     
                  </div>
                  <!--/ PAYMENT ELEMENT -->
                  <!-- ERROR -->
                     <div class="alert alert-error hide">
                        <button class="close" data-dismiss="alert"></button>
                        You have some form errors. Please check below.
                     </div>
                     <!--/ ERROR -->
               </form>
               <!-- END FORM--> 
                  <div  id="payment-form-check" class="hide">
                     <h3 class="form-section">6. Pay By Check</h3>
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

                     <div id="submit-registration-buttons" class="form-actions text-center">
                        <button type="button" class="btn green submit-registration"><i class="icon-ok"></i> Submit Balance Due</button>
                        <button type="button" class="btn cancel-registration">Cancel and Go Back</button>
                     </div>


               <? endif; ?>
            

            </div>
         </div>
         <!-- END PAGE CONTENT-->

   </div>
   <!-- END PAGE CONTAINER -->
</div>
<!-- END CONTAINER -->
<? if($this->vars['seminar']['register']['currentStatus'] < \Saw\Model\SeminarRegister::$status['OFF']):?>

<?=$this->element('js/Registration.js');?>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
(function( Payment, $, undefined ) {
   
   var params = {};

   function validateCVC(cvc){
      if(Stripe.validateCVC(cvc.val())){
         cvc.parents('.control-group').removeClass('error');// remove the red highlight
         cvc.next('.help-inline').remove(); // remove the error text
         $('#saw-form .control-group').find('.help-block.error').remove(); // remove help blocks too
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
            $('#saw-form .control-group').find('.help-block.error').remove(); // remove help blocks too
            $('#saw-form .card').css('backgroundPosition','0 -25px');
            switch (Stripe.cardType(card.val())){
               case 'Visa':
                  $('#saw-form .card.visa').css('backgroundPosition','0 0px');
                  break;
               case 'MasterCard':
                  $('#saw-form .card.master').css('backgroundPosition','0 0px');
                  break;
               case 'American Express':
                  $('#saw-form .card.amex').css('backgroundPosition','0 0px');
                  break;
               case 'Discover':
                  $('#saw-form .card.discover').css('backgroundPosition','0 0px');
                  break;         
            }
            $('#saw-form .cardType').html(Stripe.cardType(card.val()));
         }else{
            // bootstrap field to red with error message
            card.parents('.control-group').addClass('error');
            if(card.next('.help-inline').length == 0){
               card.after('<span class="help-inline">A valid card number is required.</span>');
            }
         }
   }
   Payment.initiateRegistration = function (){
      $('.submit-registration').html('<i class="icon-time"></i> Validating Your Card..');
      $('.submit-registration').attr("disabled", "disabled");
      io.saw.Registration.doDepositBalance();      
   }
   Payment.hold_card = '';
   Payment.init = function(){
      
      // validate card number
      $('#saw-form .number').blur(function(){
         validateCardNumber($(this));
      });
      // validate cvc check
      $('#saw-form .cvc').blur(function(){
         validateCVC($(this));
      });
         
   };
   
   
}( io.saw.Payment = io.saw.Payment || {}, io.saw.jQuery || jQuery ));
</script>
<script>
jQuery(document).ready(function() {    
   io.saw.Registration.init();

   // init the credit card fields
   io.saw.Payment.init()
   // prepare the month dropdown
   var select = $("#card-expMonth"),
   month = new Date().getMonth() + 1;
   for (var i = 1; i <= 12; i++) {
      select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
   }

   // prepare the year dropdown
   var select = $("#card-expYear"),
   year = new Date().getFullYear();

   for (var i = 0; i < 12; i++) {
      select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
   }
   // end - init the credit card fields
   
   
   io.saw.Payment.findPos = function(obj) {
       var curtop = 0;
       if (obj.offsetParent) {
          do {
               curtop += obj.offsetTop;
          } while (obj = obj.offsetParent);

          return [curtop];
      }
   }
   // pay by check button clicked
   $('.btn.check').click(function(e){
      $('#currentPaymentType').val(<?=\Saw\Model\Registration::$paymentType['CHECK']?>);
      $('#payment-form-check').show();
      $('#payment-form').hide();
      $(this).hide();
      $('.btn.credit').show();
      var targetElement = document.getElementById('payment-form-check');
      window.setTimeout(function() {
        window.scroll(0, io.saw.Payment.findPos(targetElement));
      }, 5);
   });
   // pay by credit card button clicked
   $('.btn.credit').click(function(e){
      $('#currentPaymentType').val(<?=\Saw\Model\Registration::$paymentType['CREDIT']?>);
      $('#payment-form').show();
      $('#payment-form-check').hide();
      $(this).hide();
      $('.btn.check').show();
      var targetElement = document.getElementById('payment-form');
      window.setTimeout(function() {
        window.scroll(0, io.saw.Payment.findPos(targetElement));
      }, 5);
   });

});      
</script>
<? endif; ?>