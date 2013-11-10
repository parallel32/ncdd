<script type="text/javascript">
(function( Registration, $, undefined ) {
	
	Registration.doRegistration = function(){
		io.saw.FormPost.activate({postUrl:'/registration/seminar'
			   ,serializeSelector:':input'
			   ,postOnComplete:function(responseObj,responseStatus){
			   		if(responseStatus == 'success'){
					
					}else{
				   		var responseObj = $.parseJSON(responseObj.responseText);
				   	}
			   }
			   ,postOnSuccess:function(responseObj){
			   		$('#save-success .modal-body p').html(responseObj.message);
			      	$('#save-success-label').html(responseObj.label);
			      	$('#save-success').modal({keyboard: false});   		
			      	//$('.submit-registration').prop("disabled",true);
			   		$('.submit-registration').html('<i class="icon-ok"></i> Registration Successful');
			   }
			   ,postOnErrors:function(responseObj){
			   		$('#payment-form .number').val(io.saw.Payment.hold_card);
			   		$('.submit-registration').removeAttr("disabled");
					$('.submit-registration').html('<i class="icon-ok"></i> Oops, Registration Failed - try again');
			   }
			});      	
	}
	Registration.register = function(){

		if($('#currentPaymentType').val() == <?=\Saw\Model\Registration::$paymentType['CHECK']?>){
			io.saw.Registration.doRegistration();
		}

		if($('#currentPaymentType').val() == <?=\Saw\Model\Registration::$paymentType['CREDIT']?>){
			io.saw.Payment.createStripeToken();
		}
		
	};
	
	Registration.init = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      io.saw.Registration.register();
		   }
		});
		$('.submit-registration').click(function(e){
			e.preventDefault();
			io.saw.Registration.register();
		});
		$('.cancel-registration').click(function(e){
			e.preventDefault();
			document.location.href="http://<?=SAW_CONSUMER_WEBSITE?>";
		});
		$('#save-success .btn.continue').click(function(e){
			e.preventDefault();
			window.location.href="http://<?=SAW_CONSUMER_WEBSITE?>";
		});

		$.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $("#fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
	
        // payment
		// $('#save-success .continue.payment').attr('data-insertid',responseObj.paymentId.$id);
		// $(this).attr('data-insertid')
		
	};
	
}( io.saw.Registration = io.saw.Registration || {}, io.saw.jQuery || jQuery ));
</script>