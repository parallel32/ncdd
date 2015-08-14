<script type="text/javascript">
(function( Registration, $, undefined ) {
	
	Registration.doDepositBalance = function(){
		io.saw.FormPost.activate({postUrl:'/registration/seminar/deposit'
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
			   		$('.submit-registration').html('<i class="icon-ok"></i> Deposit Balance Payment Successful');
			   		if(responseObj.hasOwnProperty('paymentId') && responseObj.paymentId.hasOwnProperty('$id')){
			   			io.saw.FormGet.activate({postUrl:'/registration/'+responseObj.paymentId.$id+'/pay/'+responseObj.registrationId.$id
					    	,postOnComplete:function(responseObj,responseStatus){}
					      	,postOnSuccess:function(responseObj){
					         //document.location.href='/registrations';
					      	}
					   	});
					}
			   }
			   ,postOnErrors:function(responseObj){
			   		$('#payment-form .number').val(io.saw.Payment.hold_card);
			   		$('.submit-registration').removeAttr("disabled");
					$('.submit-registration').html('<i class="icon-ok"></i> Oops, Payment Failed - try again');
			   }
			});      	
	}
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
			   		if(responseObj.hasOwnProperty('paymentId') && responseObj.paymentId.hasOwnProperty('$id')){
			   			io.saw.FormGet.activate({postUrl:'/registration/'+responseObj.paymentId.$id+'/pay/'+responseObj.registrationId.$id
					    	,postOnComplete:function(responseObj,responseStatus){}
					      	,postOnSuccess:function(responseObj){
					         //document.location.href='/registrations';
					      	}
					   	});
					}
			   }
			   ,postOnErrors:function(responseObj){
			   		$('#payment-form .number').val(io.saw.Payment.hold_card);
			   		$('.submit-registration').removeAttr("disabled");
					$('.submit-registration').html('<i class="icon-ok"></i> Oops, Registration Failed - try again');
			   }
			});      	
	}
	Registration.register = function(){

		switch ($('#currentPaymentType').val()) {
			case "<?=\Saw\Model\Registration::$paymentType['CHECK']?>":
			case "<?=\Saw\Model\Registration::$paymentType['SCHOLARSHIP']?>":
				io.saw.Registration.doRegistration();
				break;
		}
		if($('#currentPaymentType').val() == <?=\Saw\Model\Registration::$paymentType['CREDIT']?>){
			io.saw.Payment.initiateRegistration();
		}
		
	};
	
	Registration.init = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13 && $(this).attr('id') != 'registrationNumber') {
		   	  e.preventDefault();
		      io.saw.Registration.register();
		   }
		});
		
		var DELAY = 500, clicks = 0, timer = null;
		$(function(){
		    $('.submit-registration').on("click", function(e){
		    	if($('#currentPaymentType').val() === ''){
			    	alert('Please click a Payment Option - before you can submit.');
			    }else{
			        clicks++;  //count clicks
			        if(clicks === 1) {
			            timer = setTimeout(function() {
			                io.saw.Registration.register();  //perform single-click action    
			                clicks = 0;             //after action performed, reset counter
			            }, DELAY);
			        } else {
			            clearTimeout(timer);    //prevent single-click action
			            io.saw.Registration.register();  //perform double-click action
			            clicks = 0;             //after action performed, reset counter
			        }
			    }
		    })
		    .on("dblclick", function(e){
		        e.preventDefault();  //cancel system double-click event
		    });
		});


		$('.cancel-registration').click(function(e){
			e.preventDefault();
			document.location.href="https://<?=SAW_CONSUMER_WEBSITE?>";
		});
		
		$('#save-success .btn.continue').click(function(e){
			e.preventDefault();
			window.location.href="https://<?=SAW_CONSUMER_WEBSITE?>";
		});

		$.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $(".phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $(".fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
	
        // payment
		// $('#save-success .continue.payment').attr('data-insertid',responseObj.paymentId.$id);
		// $(this).attr('data-insertid')
		
	};

	function save (){
		io.saw.FormPost.activate({postUrl:'/registration/edit'
			   ,serializeSelector:':input'
			   ,postOnComplete:function(responseObj,responseStatus){
				   	if(responseStatus == 'success'){
						$('#save-success .modal-body p').html(responseObj.message);
				      	$('#save-success-label').html(responseObj.label);
				      	$('#save-success').modal({keyboard: false});   		
				   	}else{
				   		var responseObj = $.parseJSON(responseObj.responseText);
				   	}
			   }
			   ,postOnSuccess:function(responseObj){}
			});      
	};
	Registration.paymentInit = function(){
		$('#save-success .continue.payment').click(function(e){
			document.location.href='/payment/'+$(this).attr('data-insertid')+'/view';
		});
		$('#save-success .continue.dashboard').click(function(e){
			document.location.href='/';
		});
		$('#save-success .continue.registrations').click(function(e){
			document.location.href='/registrations/seminar/'+$(this).attr('data-seminar-id');
		});
		$('.btn.cancel').click(function(e){
			document.location.href='/registration/'+$(this).attr('data-id')+'/view';
		});
		$('.btn.green.submit-payment').click(function(e){
			var theThis = $(this);
			io.saw.FormPost.activate({postUrl:'/registration/payment'
			   ,formName:'#payment-form'
			   ,serializeSelector:':input'
			   ,postOnComplete:function(responseObj,responseStatus){
			   		
					if(responseStatus == 'success'){
					
					}else{
				   		var responseObj = $.parseJSON(responseObj.responseText);
				   	}
			   }
			   ,postOnSuccess:function(responseObj){
			   		$('#save-success').modal({keyboard: false});   		
			   		$('#payment-form .btn.green').prop("disabled",true);
			   		$('#payment-form .btn.green').html('<i class="icon-ok"></i> Payment Successful');
		            
		            if(responseObj.hasOwnProperty('paymentId') && responseObj.paymentId.hasOwnProperty('$id')){
		               	$('#save-success .continue.payment').attr('data-insertid',responseObj.paymentId.$id);
					   	io.saw.FormGet.activate({postUrl:'/registration/'+responseObj.paymentId.$id+'/pay/'+theThis.attr('data-registration-id')
					    	,postOnComplete:function(responseObj,responseStatus){}
					      	,postOnSuccess:function(responseObj){
					         //document.location.href='/registrations';
					      	}
					   	});
					}
			   }
			   ,postOnErrors:function(responseObj){
			   		$('#payment-form .btn.green').removeAttr("disabled");
					$('#payment-form .btn.green').html('<i class="icon-ok"></i> Submit Payment - try again');
			   }
			});
		});		
		
	};
	
	Registration.manageInit = function(){
		$('.offwaitlist').click(function(e){
			e.preventDefault();
			document.location.href='/registrations/offwaitlist/'+$(this).attr('data-id');
		});
		$('.onwaitlist').click(function(e){
			e.preventDefault();
			document.location.href='/registrations/onwaitlist/'+$(this).attr('data-id');
		});
		$('.manage-registration').click(function(e){
			e.preventDefault();
			document.location.href='/registrations/seminar/'+$(this).attr('data-id');
		});
		$('.view.registration').click(function(e){
			e.preventDefault();
			document.location.href='/registration/'+$(this).attr('data-id')+'/view';
		});
		$('.view.member').click(function(e){
			e.preventDefault();
			document.location.href='/member/'+$(this).attr('data-id')+'/edit';
		});
		$('.view.payment').click(function(e){
			e.preventDefault();
			document.location.href='/payment/'+$(this).attr('data-id')+'/view';
		});
		
		//go to edit screen
		$('#saw-form .edit').click(function(e){
			e.preventDefault();
			document.location.href='/registration/'+$(this).attr('data-id')+'/edit';
		});
		//do edit save action
		$('#saw-form .green.save').click(function(e){
			save();
		});
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      save();
		   }
		});
		
		//do edit cancel action
		$('#saw-form .edit.cancel').click(function(e){
			e.preventDefault();
			document.location.href='/registration/'+$(this).attr('data-id')+'/view';
		});
		// edit save-success button edit again
		$('#save-success .blue.continue').click(function(e){
			e.preventDefault();
			$('#save-success').modal('hide');
		});
		// edit save-success continue 
		$('#save-success .finished.continue').click(function(e){
			e.preventDefault();
			document.location.href='/registrations/seminar/'+$(this).attr('data-seminar-id');
		});
		

		//launch delete modal
		$('#saw-form .delete').click(function(e){
			e.preventDefault();
			$('#delete-modal').modal({keyboard: false});
		});
		//do delete actoin
		$('#delete-modal .delete').click(function(e){
			var theThis = $(this);
			$('#delete-modal').modal('hide');
			io.saw.FormGet.activate({postUrl:'/registration/'+$(this).attr('data-id')+'/delete'
				,postOnComplete:function(responseObj,responseStatus){}
				,postOnSuccess:function(responseObj){
					document.location.href='/registrations/seminar/'+theThis.attr('data-seminar-id');
				}
			}); 	
		});
		$('#delete-modal .cancel').click(function(e){
			$('#delete-modal').modal('hide');
		});

		$('#saw-form .view.cancel').click(function(e){
			e.preventDefault();
			document.location.href='/registrations/seminar/'+$(this).attr('data-id');
		});
					
	};
	
}( io.saw.Registration = io.saw.Registration || {}, io.saw.jQuery || jQuery ));
</script>