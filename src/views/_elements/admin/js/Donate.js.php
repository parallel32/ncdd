<script type="text/javascript">
(function( Donate, $, undefined ) {
	
	Donate.doDonate = function(){
		io.saw.FormPost.activate({postUrl:'/donate'
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
			      	//$('.submit-donation').prop("disabled",true);
			   		$('.submit-donation').html('<i class="icon-ok"></i> Donation Successful');
			   		if(responseObj.hasOwnProperty('paymentId') && responseObj.paymentId.hasOwnProperty('$id')){
			   			io.saw.FormGet.activate({postUrl:'/donate/'+responseObj.paymentId.$id+'/pay/'+responseObj.donationId.$id
					    	,postOnComplete:function(responseObj,responseStatus){}
					      	,postOnSuccess:function(responseObj){
					         //document.location.href='/donations';
					      	}
					   	});
					}
			   }
			   ,postOnErrors:function(responseObj){
			   		$('#payment-form .number').val(io.saw.Payment.hold_card);
			   		$('.submit-donation').removeAttr("disabled");
					$('.submit-donation').html('<i class="icon-ok"></i> Oops, Donate Failed - try again');
			   }
			});      	
	}
	Donate.register = function(){

		switch ($('#currentPaymentType').val()) {
			case "<?=\Saw\Model\Donate::$paymentType['CHECK']?>":
				io.saw.Donate.doDonate();
				break;
		}
		if($('#currentPaymentType').val() == <?=\Saw\Model\Donate::$paymentType['CREDIT']?>){
			io.saw.Payment.initiateDonate();
		}
		
	};
	
	Donate.init = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13 && $(this).attr('id') != 'donationNumber') {
		   	  e.preventDefault();
		      io.saw.Donate.register();
		   }
		});
		
		var DELAY = 500, clicks = 0, timer = null;
		$(function(){
		    $('.submit-donation').on("click", function(e){
		    	if($('#currentPaymentType').val() === ''){
			    	alert('Please click a Payment Option - before you can submit.');
			    }else{
			        clicks++;  //count clicks
			        if(clicks === 1) {
			            timer = setTimeout(function() {
			                io.saw.Donate.register();  //perform single-click action    
			                clicks = 0;             //after action performed, reset counter
			            }, DELAY);
			        } else {
			            clearTimeout(timer);    //prevent single-click action
			            io.saw.Donate.register();  //perform double-click action
			            clicks = 0;             //after action performed, reset counter
			        }
			    }
		    })
		    .on("dblclick", function(e){
		        e.preventDefault();  //cancel system double-click event
		    });
		});


		$('.cancel-donation').click(function(e){
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
		io.saw.FormPost.activate({postUrl:'/donate/edit'
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
	Donate.paymentInit = function(){
		$('#save-success .continue.payment').click(function(e){
			document.location.href='/payment/'+$(this).attr('data-insertid')+'/view';
		});
		$('#save-success .continue.dashboard').click(function(e){
			document.location.href='/';
		});
		$('#save-success .continue.donations').click(function(e){
			document.location.href='/donations/seminar/'+$(this).attr('data-seminar-id');
		});
		$('.btn.cancel').click(function(e){
			document.location.href='/donate/'+$(this).attr('data-id')+'/view';
		});
		$('.btn.green.submit-payment').click(function(e){
			var theThis = $(this);
			io.saw.FormPost.activate({postUrl:'/donate/payment'
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
					   	io.saw.FormGet.activate({postUrl:'/donate/'+responseObj.paymentId.$id+'/pay/'+theThis.attr('data-donation-id')
					    	,postOnComplete:function(responseObj,responseStatus){}
					      	,postOnSuccess:function(responseObj){
					         //document.location.href='/donations';
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
	
	Donate.manageInit = function(){
		$('.offwaitlist').click(function(e){
			e.preventDefault();
			document.location.href='/donations/offwaitlist/'+$(this).attr('data-id');
		});
		$('.onwaitlist').click(function(e){
			e.preventDefault();
			document.location.href='/donations/onwaitlist/'+$(this).attr('data-id');
		});
		$('.manage-donation').click(function(e){
			e.preventDefault();
			document.location.href='/donations/seminar/'+$(this).attr('data-id');
		});
		$('.view.donation').click(function(e){
			e.preventDefault();
			document.location.href='/donate/'+$(this).attr('data-id')+'/view';
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
			document.location.href='/donate/'+$(this).attr('data-id')+'/edit';
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
			document.location.href='/donate/'+$(this).attr('data-id')+'/view';
		});
		// edit save-success button edit again
		$('#save-success .blue.continue').click(function(e){
			e.preventDefault();
			$('#save-success').modal('hide');
		});
		// edit save-success continue 
		$('#save-success .finished.continue').click(function(e){
			e.preventDefault();
			document.location.href='/donations/seminar/'+$(this).attr('data-seminar-id');
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
			io.saw.FormGet.activate({postUrl:'/donate/'+$(this).attr('data-id')+'/delete'
				,postOnComplete:function(responseObj,responseStatus){}
				,postOnSuccess:function(responseObj){
					document.location.href='/donations/seminar/'+theThis.attr('data-seminar-id');
				}
			}); 	
		});
		$('#delete-modal .cancel').click(function(e){
			$('#delete-modal').modal('hide');
		});

		$('#saw-form .view.cancel').click(function(e){
			e.preventDefault();
			document.location.href='/donations/seminar/'+$(this).attr('data-id');
		});
					
	};
	
}( io.saw.Donate = io.saw.Donate || {}, io.saw.jQuery || jQuery ));
</script>