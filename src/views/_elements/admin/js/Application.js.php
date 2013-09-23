<script type="text/javascript">
(function( Application, $, undefined ) {
	function bindAddressFieldsBlur(){
		$('#address1').keyup(function(e){
			onBlur();
		})
		$('#address1').keyup(function(e){
			onBlur();
		})
		$('#city').keyup(function(e){
			onBlur();
		})
		$('#state').keyup(function(e){
			onBlur();
		})
		$('#postalCode').keyup(function(e){
			onBlur();
		})
		$('#country').keyup(function(e){
			onBlur();
		})
		
	};
	function onBlur(){
		formatted_addr = $('#address1').val();
		if($('#address2').val().length > 0){
			formatted_addr+= ' '+$('#address2').val();
		}
		formatted_addr+= ' '+$('#city').val();
		formatted_addr+= ', '+$('#state').val();
		formatted_addr+= ' '+$('#zip').val();
		formatted_addr+= ', '+$('#country').val();

		$('#geocodeaddress').val(formatted_addr);
	}
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

        bindAddressFieldsBlur();
		
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
			document.location.href="http://<?=SAW_CONSUMER_WEBSITE?>";
		});
		$('#save-success .btn.continue').click(function(e){
			e.preventDefault();
			document.location.href="http://<?=SAW_CONSUMER_WEBSITE?>";
		});

		$.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $("#fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
		
		bindAddressFieldsBlur();
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
	Application.approveInit = function(){
		$('#saw-form .btn.green.approve').click(function(e){
			approve($(this).attr('data-id'),$(this).attr('data-type'));
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
}( io.saw.Application = io.saw.Application || {}, io.saw.jQuery || jQuery ));
</script>