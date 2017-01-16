<script type="text/javascript">
(function( FormPost, $, undefined ) {
    
    var params = {};
	
	function init (p){
		params = p; 
		params.formName = params.formName || '#saw-form';
	    params.postUrl = params.postUrl || '';
	    params.serialized = params.serialized || '';
	    params.serializeSelector = params.serializeSelector || ':input';
	    params.serialize = $(params.formName+' '+params.serializeSelector).serialize();
	    params.serialize = params.serialized || params.serialize;
	    params.postOnComplete = params.postOnComplete || function(){};
		params.postOnSuccess = params.postOnSuccess || function(){};
		params.postOnErrors = params.postOnErrors || function(){};
		params.blockUI = params.blockUI || 'yes';
		params.blockUIParams = params.blockUIParams || {};
		params.validate = params.validate || 'yes';
		params.attachInvalidFieldsToMessage = params.attachInvalidFieldsToMessage || 'yes';
		params.blockObj = undefined;
	};
	FormPost.getParams = function(){
		return params;
	};
	FormPost.activate = function(p){
		init(p);
		if(params.blockUI == 'yes'){
			params.blockObj = io.saw.BlockUI.block(params.blockUIParams);	
		}
		return $.post(
			params.postUrl
			,params.serialize
			,"json"
		)
		.done(function(response){
			if(params.validate == 'yes'){
				// clear all validation colors
				$('.control-group').find('.help-block.error').remove();
				$('.error').removeClass('error');			
				$(params.formName+' .alert-error').addClass('hide').html('');
			}
			params.postOnSuccess(response);

		})
		.fail(function(response){
			var responseObj = jQuery.parseJSON(response.responseText);
			if(params.validate == 'yes'){
				// clear all validation colors
				$('.control-group').find('.help-block.error').remove();
				$('.error').removeClass('error');
				
				// set new validation errors
				var invalid_fields_str = '';
				if(responseObj == null){
					$(params.formName+' .alert-error').removeClass('hide').html('<span>Internal Server Error..</span>');
				}else if(responseObj.hasOwnProperty('invalidFields') && responseObj.invalidFields.length > 0){
					$.each(responseObj.invalidFields, function(index,fieldObj){
						if(fieldObj.name.length > 0){
							$(params.formName+' .control-group :input.'+fieldObj.name).parents('.control-group').addClass('error');
							var input_selected = $(params.formName+' .control-group :input.'+fieldObj.name).parents('.controls');
							input_selected.append(
							'<span for="'+fieldObj.name+'" class="help-block error pulsate" style="">'+fieldObj.message+'</span>'
							);
						}
						invalid_fields_str+='<li>'+fieldObj.name+'</li>';
					});
					if(params.attachInvalidFieldsToMessage == 'yes'){
						$(params.formName+' .alert-error').removeClass('hide').html('<span>'+responseObj.message+'</span>'+invalid_fields_str);
					}else{
						$(params.formName+' .alert-error').removeClass('hide').html('<span>'+responseObj.message+'</span>');
					}					
				}else if(responseObj.hasOwnProperty('message') && responseObj.message.length > 0){
					$(params.formName+' .alert-error').removeClass('hide').html('<span>'+responseObj.message+'</span>');
				}
				params.postOnErrors(responseObj);
			}
		})
		.always(function(response,status){
			if(params.validate == 'yes'){
				if (jQuery().animate) {
		            /*
		            jQuery('.error.pulsate').pulsate({
		                color: "#bf1c56",
		                repeat: false
		            });
		            //*/
		            //jQuery('.error.pulsate').animate({backgroundColor: "#f2dede"},{duration:800}).delay(1000).animate({backgroundColor: "#fff"}).animate({color:'red'})
		        }
		    }
		    params.postOnComplete(response,status);
			if(params.blockObj != undefined){
				params.blockObj.unblock();
			}
		});
	};
    
}( io.saw.FormPost = io.saw.FormPost || {}, io.saw.jQuery || jQuery ));
</script>  