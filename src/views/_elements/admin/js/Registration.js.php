<script type="text/javascript">
(function( Registration, $, undefined ) {
	function register (){
		
		var full_address = $('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val();
		$('#raw').val(full_address);

		io.saw.FormPost.activate({postUrl:'/application/new-sustaining-member'
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
	
	Registration.init = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      register();
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			register();
		});
		$('#saw-form .cancel-go-back').click(function(e){
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
		$('#save-success .continue.payment').click(function(e){
			document.location.href='/payment/'+$(this).attr('data-insertid')+'/view';
		});
		$('#save-success .continue.dashboard').click(function(e){
			document.location.href='/';
		});
		$('#save-success .continue.applications').click(function(e){
			document.location.href='/applications';
		});
		$('.btn.cancel').click(function(e){
			document.location.href='/application/'+$(this).attr('data-id')+'/view';
		});
		$('.btn.green.submit-payment').click(function(e){
			var theThis = $(this);
			io.saw.FormPost.activate({postUrl:'/application/payment'
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
		            
	               	$('#save-success .continue.payment').attr('data-insertid',responseObj.paymentId.$id);
				   	io.saw.FormGet.activate({postUrl:'/application/'+responseObj.paymentId.$id+'/pay/'+theThis.attr('data-application-id')+'/no'
				    	,postOnComplete:function(responseObj,responseStatus){}
				      	,postOnSuccess:function(responseObj){
				         //document.location.href='/applications';
				      	}
				   	});
			   }
			   ,postOnErrors:function(responseObj){
			   		$('#payment-form .btn.green').removeAttr("disabled");
					$('#payment-form .btn.green').html('<i class="icon-ok"></i> Submit Payment - try again');
			   }
			});
		});		
		
	};
	
}( io.saw.Registration = io.saw.Registration || {}, io.saw.jQuery || jQuery ));
</script>