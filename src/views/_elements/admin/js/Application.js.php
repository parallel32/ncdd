<script type="text/javascript">
(function( Application, $, undefined ) {
	function newSustainingMemberAdd (){
		
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
	function newMemberAdd (){
		
		var full_address = $('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val();
		$('#raw').val(full_address);
			
		io.saw.FormPost.activate({postUrl:'/application/new-member'
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
	function saveApplication (){
		
		var full_address = $('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val();
		$('#raw').val(full_address);
			
		io.saw.FormPost.activate({postUrl:'/application/edit'
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
	Application.newMemberInit = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      newMemberAdd();
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			newMemberAdd();
		});
		$('#saw-form .cancel-go-back').click(function(e){
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

        $("#phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $("#fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options

	};
	Application.newSustainingMemberInit = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      newSustainingMemberAdd();
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			newSustainingMemberAdd();
		});
		$('#saw-form .cancel-go-back').click(function(e){
			e.preventDefault();
			document.location.href="https://<?=SAW_CONSUMER_WEBSITE?>";
		});
		$('#save-success .btn.continue').click(function(e){
			e.preventDefault();
			document.location.href="https://<?=SAW_CONSUMER_WEBSITE?>";
		});

		$.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $("#fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
		
	};
	Application.editInit = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      saveApplication();
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			saveApplication();
		});
		$('#saw-form .cancel-go-back').click(function(e){
			e.preventDefault();
			document.location.href='/application/'+$(this).attr('data-id')+'/view';
		});
		$('#save-success .btn.continue-editing').click(function(e){
			$('#save-success').modal('hide');
		});
		$('#save-success .btn.all-applications').click(function(e){
			document.location.href='/application/'+$(this).attr('data-id')+'/view';
		});
		
		$.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $("#fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options

	};
	Application.init = function(){
		$('.btn.blue.mini.view').click(function(e){
			document.location.href='/application/'+$(this).attr('data-id')+'/view';
		});		
		$('.btn.blue.mini.view.member').click(function(e){
			document.location.href='/member/'+$(this).attr('data-id')+'/edit';
		});		
		$('.btn.blue.mini.view.payment').click(function(e){
			document.location.href='/payment/'+$(this).attr('data-id')+'/view';
		});		
	};
	Application.paymentInit = function(){
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
	Application.approveInit = function(){
		$('#saw-form .btn.green.approve').click(function(e){
			approve($(this).attr('data-id'),$(this).attr('data-type'));
		});

		$('#saw-form .btn.purple.trial').click(function(e){
			// pop trial modal to set the end date
			$('#trial-modal').modal({keyboard: false});
		});
		$('#trial-modal .btn.green.continue').click(function(e){
			approveTrial($(this).attr('data-id'));
		});
		$('#trial-modal .btn.cancel').click(function(e){
			e.preventDefault();
			$('#trial-modal').modal('hide');
		});		
		
		
		$('#saw-form .btn.cancel').click(function(e){
			e.preventDefault();
			document.location.href='/applications';			
		});
		$('#saw-form .btn.red').click(function(e){
			// pop delete are you sure modal
			$('#delete-modal').modal({keyboard: false});
		});		
		$('#delete-modal .btn.red.continue').click(function(e){
			$('#delete-modal').modal('hide');
			remove($(this).attr('data-id'));
		});		
		$('#delete-modal .btn.cancel').click(function(e){
			e.preventDefault();
			$('#delete-modal').modal('hide');
		});		
		$('#saw-form .btn.edit').click(function(e){
			e.preventDefault();
			document.location.href='/application/'+$(this).attr('data-id')+'/edit';
		});
		$('#saw-form .btn.pay').click(function(e){
			e.preventDefault();
			document.location.href='/application/'+$(this).attr('data-id')+'/pay-other';
		});
		
	};
	
	Application.updateMemberInit = function(){
		$('#saw-form .form-actions .btn.green').click(function(e){
			e.preventDefault();
			initiateSubmit();
		});
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      initiateSubmit();
		   }
		});
		
		$('#saw-form .form-actions .btn.cancel-go-back').click(function(e){
			e.preventDefault();
			document.location.href='/';
		});
		$('#save-success .finished').click(function(e){
			e.preventDefault();
			document.location.href='/';
		});

		
	};
	function remove (id){
		io.saw.FormGet.activate({postUrl:'/application/'+id+'/delete'
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href='/applications';
			}
		});
	};
	function approve (id,type){
		io.saw.FormGet.activate({postUrl:'/application/'+id+'/approve/'+type
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href='/applications';
			}
		});
	};
	function approveTrial (id){
		io.saw.FormPost.activate({postUrl:'/application/'+id+'/trial'
		   ,formName:'#trial-form'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){
			   	if(responseStatus == 'success'){
			   		$('#trial-modal').modal('hide');
					$('#save-success .modal-body p').html(responseObj.message);
			      	$('#save-success-label').html(responseObj.label);
			      	$('#save-success').modal({keyboard: false});   		
			      	//*
			      	window.setTimeout(function(){
			      		document.location.href='/applications';
			      	},100);
					//*/
			   	}else{
			   		var responseObj = $.parseJSON(responseObj.responseText);
			   	}
		   }
		   ,postOnSuccess:function(responseObj){}
		});      
	};

}( io.saw.Application = io.saw.Application || {}, io.saw.jQuery || jQuery ));
</script>