<script type="text/javascript">
(function( FormGet, $, undefined ) {
    
    var params = {};
	
	function init (p){
		params = p; 
	    params.postUrl = params.postUrl || '';
	    params.postOnComplete = params.postOnComplete || function(){};
		params.postOnSuccess = params.postOnSuccess || function(){};
		params.postOnErrors = params.postOnErrors || function(){};
		params.blockUI = params.blockUI || 'yes';
		params.validate = params.validate || 'yes';
	};
	FormGet.getParams = function(){
		return params;
	};
	FormGet.activate = function(p){
		init(p);
		if(params.blockUI == 'yes'){
			io.saw.BlockUI.block({});	
		}		
		$.get(
			params.postUrl
		)
		.done(function(response){
			if(params.validate == 'yes'){
				// hide previous alerts
				if(!$('.alert-success').hasClass('hide')){$('.alert-success').addClass('hide');}
				if(!$('.alert-error').hasClass('hide')){$('.alert-error').addClass('hide')};

				$('.alert-success').removeClass('hide').find('#response-message').html(response.message);
				window.setTimeout(function(){
					$('.alert-success').addClass('hide');
				}, 5000);
			}
			params.postOnSuccess(response);
		})
		.fail(function(response){
			if(params.validate == 'yes'){
				// hide previous alerts
				if(!$('.alert-success').hasClass('hide')){$('.alert-success').addClass('hide');}
				if(!$('.alert-error').hasClass('hide')){$('.alert-error').addClass('hide')};

				var responseObj = jQuery.parseJSON(response.responseText);
				if(responseObj == null){
					$('.alert-error').removeClass('hide').find('#response-message').html('Internal Server Error..');
				}else if(typeof responseObj == 'object' && responseObj.hasOwnProperty('errors') && responseObj.errors.length > 0){
					params.postOnErrors(responseObj);		
				}else if(typeof responseObj == 'object' && responseObj.hasOwnProperty('message') && responseObj.message.length > 0){
					$('.alert-error').removeClass('hide').find('#response-message').html(responseObj.message);				
				}
			}
		})
		.always(function(response){
			params.postOnComplete(jQuery.parseJSON(response.responseText),response.status);
			if(params.blockUI == 'yes'){
				io.saw.BlockUI.unblock();
			}
		});

	};
    
}( io.saw.FormGet = io.saw.FormGet || {}, io.saw.jQuery || jQuery ));
</script>  