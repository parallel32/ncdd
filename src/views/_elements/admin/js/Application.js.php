<?
	$return_to_app_index = (array_key_exists('application', $this->vars)) ? (array_key_exists('_id', $this->vars['application']) && strpos(strtolower($this->vars['application']['class']),'update') !== false) ? "document.location.href='/renewals';": "document.location.href='/applications';" : '';
?>
<script type="text/javascript">

(function( Application, $, undefined ) {
	function yearsinlawpracticelogic (){
		var the_element = $('#saw-form .control-group :input.yearsInLawPractice').parents('.control-group');
    	the_element.find('.help-block.error').remove();
		the_element.removeClass('error');
   	    if($('#saw-form .yearsInLawPractice').val() != '' && new Date($('#saw-form .yearsInLawPractice').val(),1,1) !== "Invalid Date" && !isNaN(new Date($('#saw-form .yearsInLawPractice').val(),1,1)) ){
        	var yilp = new Date($('#saw-form .yearsInLawPractice').val(), 1,1).getFullYear();
        	var now = new Date().getFullYear();
        	if(now - yilp >= 6){
        		var amount = (window.gsix_amount-window.gsix_prorated == window.gsix_amount) ? window.gsix_amount : window.gsix_prorated; 
        		$('.payment.amount').val(amount);
        		$('.payment.amount').html(amount+' - '+window.gsix_message);
        	}else if (now - yilp < 6){
        		var amount = (window.lsix_amount-window.lsix_prorated == window.lsix_amount) ? window.lsix_amount : window.lsix_prorated; 
        		$('.payment.amount').val(amount);
        		$('.payment.amount').html(amount+' - '+window.lsix_message);
        	}
        }else{
        	the_element.addClass('error');
   			if(the_element.find('.help-block.error').length == 0){
   				the_element.append('<span for="yearsInLawPractice" class="help-block error " style="">Please enter a valid year only.  Alpha characters and full dates will cause this to keep appearing. </span>');
   			}
        }
        publicdefenderlogic();
        promocodelogic();
	};
	function publicdefenderlogic (){
		if($('#saw-form .publicDefender').val() == 'yes'){
    		var amount = (window.pd_amount-window.pd_prorated == window.pd_amount) ? window.pd_amount : window.pd_prorated; 
    		$('.payment.amount').val(amount);
    		$('.payment.amount').html(amount+' - '+window.pd_message);
    		promocodelogic();
    	}
	};
	function promocodelogic (){
		$('#payment-information').show();
		$('.payment.amount').val(0);
		$('.payment.amount').html();
		var promocodetype = $('#promocodetype').val().split('-');
		if(promocodetype[0] == 'discount'){
			if(promocodetype[1] == 'NCDD2014' && document.location.href.indexOf("update-member") > -1){
				var promo_message = ' - 2015 Membership dues.  The remainder of 2014 is free with this promo code.  Please Continue to fill out the payment information.';
			}
			if(promocodetype[1] == 'NCDD2015'){
				var promo_message = ' - $50 discount when you allow us to keep your card on-file for membership renewals.  Please Continue to fill out the payment information.';
			}

			var the_element = $('#saw-form .control-group :input.yearsInLawPractice').parents('.control-group');
	    	the_element.find('.help-block.error').remove();
			the_element.removeClass('error');
	   	    if($('#saw-form .yearsInLawPractice').val() != '' && new Date($('#saw-form .yearsInLawPractice').val(),1,1) !== "Invalid Date" && !isNaN(new Date($('#saw-form .yearsInLawPractice').val(),1,1)) ){
	        	var yilp = new Date($('#saw-form .yearsInLawPractice').val(), 1,1).getFullYear();
	        	var now = new Date().getFullYear();
	        	if(now - yilp >= 6){
	        		if(promocodetype[1] == 'NCDD2015'){
	        			var amount = window.gsix_amount-50; 
		        	}else{
		        		var amount = window.gsix_amount; 
		        	}
	        		$('.payment.amount').val(amount);
	        		$('.payment.amount').html(amount+' - '+window.gsix_message+promo_message);
	        	}else if (now - yilp < 6){
	        		if(promocodetype[1] == 'NCDD2015'){
	        			var amount = window.lsix_amount-50; 
		        	}else{
		        		var amount = window.lsix_amount; 
		        	}
	        		$('.payment.amount').val(amount);
	        		$('.payment.amount').html(amount+' - '+window.lsix_message+promo_message);
	        	}

	        	if($('#saw-form .publicDefender').val() == 'yes'){
	        		var promo_message = ''; // NCDD2015 promo is not in effect for public defenders so promo message must be blank.
		    		var amount = window.pd_amount; 
		    		$('.payment.amount').val(amount);
		    		$('.payment.amount').html(amount+' - '+window.pd_message+promo_message);
		    	}

	        }else{
	        	the_element.addClass('error');
	   			if(the_element.find('.help-block.error').length == 0){
	   				the_element.append('<span for="yearsInLawPractice" class="help-block error " style="">Please enter a valid year only.  Alpha characters and full dates will cause this to keep appearing. </span>');
	   				$('.payment.amount').html('<span for="yearsInLawPractice" class="help-block error " style="">Please scroll up and enter a valid year for question #3 "Year of admission to practice."</span>');
	   			}
	        }

    	}
    	if(promocodetype[0] == 'trial'){
    		$('.payment.amount').val('0');
    		$('.payment.amount').html('0'+' - Trial membership.');
    		$('#payment-information').hide();
    	}
	};
	function newSustainingMemberAdd (){
		
		var full_address = $('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val();
		$('#raw').val(full_address);

		io.saw.FormPost.activate({postUrl:'/application/new-sustaining-member'
		   ,serializeSelector:':input'
		   ,invalidFieldsString:'no'
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
		$('#saw-form .btn.green').prop('disabled', true);
		var full_address = $('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val();
		$('#raw').val(full_address);
			
		io.saw.FormPost.activate({postUrl:'/application/new-member'
		   ,serializeSelector:':input'
		   ,invalidFieldsString:'no'
		   ,postOnComplete:function(responseObj,responseStatus){
			   	if(responseStatus == 'success'){
					$('#save-success .modal-body p').html(responseObj.message);
			      	$('#save-success-label').html(responseObj.label);
			      	$('#save-success').modal({keyboard: false});   		
			   	}else{
			   		var responseObj = $.parseJSON(responseObj.responseText);
			   	}
			   	$('#saw-form .btn.green').prop('disabled', false);
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
		/*
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			newMemberAdd();
		});
		*/

		var DELAY = 500, clicks = 0, timer = null;
		$(function(){
		    $('#saw-form .btn.green').on("click", function(e){
		        clicks++;  //count clicks
		        if(clicks === 1) {
		            timer = setTimeout(function() {
		                newMemberAdd();  //perform single-click action    
		                clicks = 0;             //after action performed, reset counter
		            }, DELAY);
		        } else {
		            clearTimeout(timer);    //prevent single-click action
		            newMemberAdd();  //perform double-click action
		            clicks = 0;             //after action performed, reset counter
		        }
		    })
		    .on("dblclick", function(e){
		        e.preventDefault();  //cancel system double-click event
		    });
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


        $('#saw-form .publicDefender').change(function(){
        	publicdefenderlogic();
        	promocodelogic();
        });
        $('#saw-form .yearsInLawPractice').keyup(function(){
        	yearsinlawpracticelogic();        	
        	promocodelogic();
        });
        $('#saw-form .promocode').keyup(function(){
        	window.clearTimeout(window.promocodetimeoutid);//cancel previous timer so they don't queue up when you're typing
			window.promocodetimeoutid = window.setTimeout(function(theThis){ // delay so it's not in every key-up stroke
				if(theThis.val().length == 0){
	        		$('#promocodetype').val('');
	        	}
	        	io.saw.FormPost.activate({postUrl:'/application/promocode'
				   ,blockUI:'no'
				   ,serializeSelector:'.promocode'
				   ,postOnComplete:function(responseObj,responseStatus){}
				   ,postOnSuccess:function(responseObj){
				   		var the_element = $('#saw-form .control-group :input.promocode').parents('.control-group');
				   		if(responseObj.valid == 'yes'){
				   			$('#promocodetype').val(responseObj.type);
				   			the_element.addClass('success');
				   			if(the_element.find('.help-block.success').length == 0){
				   				the_element.append('<span for="promocode" class="help-block success " style="">'+responseObj.message+'</span>');
				   			}
				   		}
				   		if(responseObj.valid == 'no'){
				   			$('#promocodetype').val('invalid');
				   			the_element.find('.help-block.success').remove();
							the_element.removeClass('success');
				   		}
					yearsinlawpracticelogic();
					promocodelogic();   		
				   }
				});
			},500,$(this));
        });
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
		$('.btn.mini.view.card').click(function(e){
			document.location.href='/card/'+$(this).attr('data-id');
		});		
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
			<?=$return_to_app_index?>
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
	               	if($('input[name="suppress_emails"]:checked').length > 0){
						var suppress_emails = '?suppress_emails=yes';
					}else{
						var suppress_emails = '';
					}
				   	io.saw.FormGet.activate({postUrl:'/application/'+responseObj.paymentId.$id+'/pay/'+theThis.attr('data-application-id')+'/no'+suppress_emails
				    	,postOnComplete:function(responseObj,responseStatus){}
				      	,postOnSuccess:function(responseObj){
				          /*<?=$return_to_app_index?>*/
				          
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
			<?=$return_to_app_index?>	
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
				<?=$return_to_app_index?>
			}
		});
	};
	function approve (id,type){
		if($('input[name="suppress_emails"]:checked').length > 0){
			var suppress_emails = '?suppress_emails=yes';
		}else{
			var suppress_emails = '';
		}
		io.saw.FormGet.activate({postUrl:'/application/'+id+'/approve/'+type+suppress_emails
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				<?=$return_to_app_index?>
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
			      		<?=$return_to_app_index?>
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