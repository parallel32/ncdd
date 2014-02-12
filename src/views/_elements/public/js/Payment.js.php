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
		$('#payment-button').html('Validating Your Card..');
		$('#payment-button').prop("disabled",true);

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
				$('#payment-button').removeAttr("disabled");
				$('#payment-button').html('Submit Payment');

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
				$('#payment-button').html('Processing Your Payment..');
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

		$('#description').val('Product purchase by: '+$('#payment-form .name').val())
		$('#title').val('Product purchase by: '+$('#payment-form .name').val())
			

		io.saw.FormPost.activate({postUrl:'/shopping-cart/checkout'
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
		   		$('#payment-button').hide();
		   		$('#payment-button').html('Payment Successful');
		   		$('#print-button').show();
		   		$('#payment-success-alert').show();
		   		$('#orderId').val(responseObj.orderId.$id);
		   		$('#print-button').click(function(e){
					document.location.href='/shopping-cart/checkout/receipt/'+responseObj.orderId.$id
				});
		   }
		   ,postOnErrors:function(responseObj){
		   		$('#payment-button').removeAttr("disabled");
				$('#payment-button').html('Submit Payment - try again');
				
		   }
		});      
	};
	Payment.init = function(p){
		params = p;
		
		$('#payment-form input').keypress(function (e) {
			if (e.which == 13) {
				validateCardNumber($('#payment-form .number'));
				validateCVC($('#payment-form .cvc'));
				createStripeToken();
			}
		});
		$('#payment-button').click(function(e){
			validateCardNumber($('#payment-form .number'));
			validateCVC($('#payment-form .cvc'));
			createStripeToken();
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
	
}( io.saw.Payment = io.saw.Payment || {}, io.saw.jQuery || jQuery ));
</script>