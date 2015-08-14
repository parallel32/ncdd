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
            Payment.hold_card = card.val();
         }else{
            // bootstrap field to red with error message
            card.parents('.control-group').addClass('error');
            if(card.next('.help-inline').length == 0){
               card.after('<span class="help-inline">A valid card number is required.</span>');
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
   
   // prepare the hard copy change handler to update the total
   $('#saw-form .hardcopyYesNo').change(function(e){
      var hard_copy_fee = <?=($this->vars['seminar']['register']['hardCopyPrice'] > 0) ? $this->vars['seminar']['register']['hardCopyPrice'] : 0?>;
      if($(this).val() == 'YES'){
         $('#total').val(parseInt($('#total').val())+parseInt(hard_copy_fee));
      }else{
         var val = $('#deposit-group input[type=radio]:checked').val();
         if(val=='yes'){
            $('#total').val(parseInt($('#deposit').val()));   
         }else{
            $('#total').val(parseInt($('#total_orig').val()));
         }
         
      }
      $('#saw-form .amount').val($('#total').val());
   });

   // prepare the deposit change handler to update the total
   $('#deposit-group input[type=radio]').change(function(e){
      var val = $('#deposit-group input[type=radio]:checked').val();
      var hard_copy_fee = $('#hardcopyfee').val();
      var hard_copy_set = $('#saw-form .hardcopyYesNo').val();
      
      if(val=='yes' || val=='card'){
         if(hard_copy_set == 'YES'){
            $('#total').val(parseInt($('#deposit').val())+parseInt(hard_copy_fee));
         }else{
            $('#total').val(parseInt($('#deposit').val()));
         }
         
      }
      if(val=='no'){
         if(hard_copy_set == 'YES'){
            $('#total').val(parseInt($('#total_orig').val())+parseInt(hard_copy_fee));  
         }else{
            $('#total').val(parseInt($('#total_orig').val()));  
         }
         
      }
      $('#saw-form .amount').val($('#total').val());
   });

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
      $('#payment-form-scholarship').hide("slow");
      $('#payment-form-check').show("slow");
      $('#payment-form').hide("slow");     
      var targetElement = document.getElementById('payment-form-check');
      window.setTimeout(function() {
        window.scroll(0, io.saw.Payment.findPos(targetElement));
      }, 1000);
   });
   // pay by credit card button clicked
   $('.btn.credit').click(function(e){
      $('#currentPaymentType').val(<?=\Saw\Model\Registration::$paymentType['CREDIT']?>);
      $('#payment-form-scholarship').hide("slow");
      $('#payment-form').show("show");
      $('#payment-form-check').hide("slow");      
      var targetElement = document.getElementById('payment-form');
      window.setTimeout(function() {
        window.scroll(0, io.saw.Payment.findPos(targetElement));
      }, 1000);
   });
   // pay by scholarship button clicked
   $('.btn.scholarship').click(function(e){
      $('#currentPaymentType').val(<?=\Saw\Model\Registration::$paymentType['SCHOLARSHIP']?>);
      $('#payment-form-scholarship').show("slow");
      $('#payment-form-check').hide("slow");
      $('#payment-form').hide("slow");      
      var targetElement = document.getElementById('payment-form-scholarship');
      window.setTimeout(function() {
        window.scroll(0, io.saw.Payment.findPos(targetElement));
      }, 1000);
   });
   
});      
</script>