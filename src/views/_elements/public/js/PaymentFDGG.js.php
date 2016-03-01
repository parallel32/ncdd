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
	
	Payment.hold_card = '';
	Payment.charge = function (){

		$('#payment-button').html('Processing Your Payment..');
		$('#payment-button').prop("disabled",true);

		$('#description').val('Product purchase by: '+$('#payment-form .name').val())
		$('#title').val('Product purchase by: '+$('#payment-form .name').val())
			

		io.saw.FormPost.activate({postUrl:'/shopping-cart/checkout'
		   ,formName:'#payment-form'
		   ,serializeSelector:':input'
		   ,blockUI:'no'
		   ,postOnComplete:function(responseObj,responseStatus){
		   		//$('#payment-form .number').val(io.saw.Payment.hold_card);
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
				validateCVC($('#payment-form .cvc'));
				Payment.charge();
			}
		});
		$('#payment-button').click(function(e){
			validateCVC($('#payment-form .cvc'));
			Payment.charge();
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
		});
		// validate cvc check
		$('#payment-form .cvc').blur(function(){
			validateCVC($(this));
		});
		
		$.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#payment-form .phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
	};
	
}( io.saw.Payment = io.saw.Payment || {}, io.saw.jQuery || jQuery ));
</script>