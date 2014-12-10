<!-- BEGIN CONTAINER -->   
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
               <!-- BEGIN FORM-->
               <form id="saw-form" class="horizontal-form portlet">
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>                  
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
                        
                  
                     <input type="hidden" class="userId" name="doc[userId]" value="<?=(!empty($this->vars['userId'])) ? $this->vars['userId'] : ''?>">
                     <input type="hidden" class="cardType" name="doc[cardType]" value="">
                     <input type="hidden" class="token" name="doc[token]" value="">
                     


                     <? 
                     $user = $this->app['session']->get('user');
                     $accessLevel = $user['accessLevel'];
                     $user_id = $user['user_id'];
                     ?>
                     <? if($accessLevel == ADMIN): ?>
                     <h3 class="form-section">Renewal Credit (appears for admin only)</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label">Add a dollar amount here (numbers only)</label>
                              <div class="controls">
                                 <div class="input-prepend input-append">
                                    <span class="add-on">$</span><input type="text" name="doc[renewalCredit]" class="m-wrap span8 renewalCredit" value="<?=(array_key_exists('renewalCredit',$this->vars['payment'])) ? $this->vars['payment']['renewalCredit']: '';?>"><span class="add-on">.00</span>
                                    <span class="help-inline">This will appear as a line item credit on this member's invoice for membership renewal.</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <br><br>
                     <h3 class="form-section">Designate if this card can be stored and re-used.</h3>
                     <div class="row-fluid">
                        <div class="span8 ">
                           <div class="control-group ">
                              <label class="control-label"></label>
                              <div class="controls">
                                 <input style="margin-left:1px;" <?=(array_key_exists('renewalREUSE',$this->vars['payment'])) ? ($this->vars['payment']['renewalREUSE'] == "yes") ? ' checked' :'' : '';?> type="radio" name="doc[renewalREUSE]" value="yes">&nbsp;&nbsp;Yes, allow this card to be re-used when needed.<br/><br/>
                                 <input style="margin-left:1px;" <?=(array_key_exists('renewalREUSE',$this->vars['payment'])) ? ($this->vars['payment']['renewalREUSE'] == "no" || empty($this->vars['payment']['renewalREUSE'])) ? ' checked' :'' : '';?> type="radio" name="doc[renewalREUSE]" value="no">&nbsp;&nbsp;No, do not re-use this card for automatic payments.<br/><br/>
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     <br><br>
                     <? endif; ?>


                     <h3 class="form-section">Credit Card Information</h3>
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
                                 <input type="text" name="doc[name]" class="m-wrap span8 name" value="<?=(array_key_exists('name',$this->vars['payment'])) ? $this->vars['payment']['name']: '';?>">
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
                                 <input type="text" name="doc[number]" class="m-wrap span8 number" value="<?=(array_key_exists('number',$this->vars['payment'])) ? $this->vars['payment']['number']: '';?>">
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
                                 <input type="text" name="doc[cvc]" class="m-wrap span8 cvc" value="<?=(array_key_exists('cvc',$this->vars['payment'])) ? $this->vars['payment']['cvc']: '';?>">
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
                                 <select id="card-expMonth" class="span4 expMonth" name="doc[expMonth]"></select>
                                 <select id="card-expYear" class="span4 expYear" name="doc[expYear]"></select>
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
                                 <input type="text" name="doc[addressLine1]" class="m-wrap span8 addressLine1" value="<?=(array_key_exists('addressLine1',$this->vars['payment'])) ? $this->vars['payment']['addressLine1']: '';?>">
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
                                 <input type="text" name="doc[addressLine2]" class="m-wrap span8 addressLine2" value="<?=(array_key_exists('addressLine2',$this->vars['payment'])) ? $this->vars['payment']['addressLine2']: '';?>">
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
                                 <input type="text" name="doc[city]" class="m-wrap span8 city" value="<?=(array_key_exists('city',$this->vars['payment'])) ? $this->vars['payment']['city']: '';?>">
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
                                 <input type="text" name="doc[stateProvinceRegion]" class="m-wrap span8 stateProvinceRegion" value="<?=(array_key_exists('stateProvinceRegion',$this->vars['payment'])) ? $this->vars['payment']['stateProvinceRegion']: '';?>">
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
                                 <input type="text" name="doc[zipPostalCode]" class="m-wrap span8 zipPostalCode" value="<?=(array_key_exists('zipPostalCode',$this->vars['payment'])) ? $this->vars['payment']['zipPostalCode']: '';?>">
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
                                 <input type="text" name="doc[country]" class="m-wrap span8 country" value="<?=(array_key_exists('country',$this->vars['payment'])) ? $this->vars['payment']['country']: '';?>">
                              </div>
                           </div>
                        </div>
                        <!--/span-->
                     </div>
                     
                  <!-- SUCCESSFUL SAVE MODAL -->
                  <div id="save-success" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="save-success-label" aria-hidden="true">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3 id="save-success-label">Successful Operation</h3>
                     </div>
                     <div class="modal-body">
                        <p></p>
                     </div>
                     <div class="modal-footer">
                        <a href="javascript:document.location.href=document.referrer" class="btn blue " data-insertid="">Finished</a>
                     </div>
                  </div>
                  <!--/ SUCCESSFUL SAVE MODAL -->
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  
                  <div class="form-actions text-center">
                     <button type="button" class="btn green save"><i class="icon-ok"></i> Save</button>
                     <a href="javascript:document.location.href=document.referrer" class="btn cancel">Cancel and Go Back</a>
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
<script>
jQuery(document).ready(function() {    

});      
</script>

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
            if(card.val().length > 7){
               // bootstrap field to red with error message
               card.parents('.control-group').addClass('error');
               if(card.next('.help-inline').length == 0){
                  card.after('<span class="help-inline">A valid card number is required.</span>');
               }
            }
         }
   }
   Payment.initiateRegistration = function () {
      $('.submit-registration').html('<i class="icon-time"></i> Processing your registration..');
      $('.submit-registration').attr("disabled", "disabled");
      io.saw.Registration.doRegistration();
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


   var smonth = '<?=(array_key_exists('expMonth',$this->vars['payment'])) ? $this->vars['payment']['expMonth']: '';?>';
   var syear = '<?=(array_key_exists('expYear',$this->vars['payment'])) ? $this->vars['payment']['expYear']: '';?>';
   $('#card-expMonth option[value='+smonth+']').attr('selected', 'selected');
   $('#card-expYear option[value=20'+syear+']').attr('selected', true);

   cardSave = function (){
      
      io.saw.FormPost.activate({postUrl:'/card/edit'
         ,serializeSelector:':input'
         ,postOnComplete:function(responseObj,responseStatus){
               if(responseStatus == 'success'){
               }else{
                  var responseObj = $.parseJSON(responseObj.responseText);
               }
         }
         ,postOnSuccess:function(responseObj){
            $('#save-modal .modal-body p').html(responseObj.message);
            //$('#save-modal-label').html(responseObj.label);
            $('#save-modal').modal({keyboard: false});         
         }
      });      
   };

   // SAVE buttons
   $('#saw-form input').keypress(function(e) {
      if (e.which == 13) {
         e.preventDefault();
         cardSave();
      }
   });
   $('#saw-form .btn.save').click(function(e){
      cardSave();
   });


});      
</script>