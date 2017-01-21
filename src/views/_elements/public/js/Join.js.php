<script type="text/javascript">
(function( Join, $, undefined ) {
	
	Join.promocodetimeoutid = 0;

	function checkPromocode(){
		setTimeout(function() {
	        io.saw.FormPost.activate({postUrl:'/join/promocode-validate'
			   ,blockUI:'no'
			   ,serializeSelector:':input'
			   ,postOnComplete:function(responseObj,responseStatus){
			   	if($('.promocode').val().length == 0){
					var the_element = $('.control-group :input.promocode').parents('.control-group');
		   			the_element.removeClass('success');the_element.removeClass('error');
		   			the_element.find('.help-block.success').remove();the_element.find('.help-block.error').remove();
		   		}
			   }
			   ,postOnSuccess:function(responseObj){
			   		var the_element = $('.control-group :input.promocode').parents('.control-group');
		   			the_element.addClass('success');
		   			the_element.removeClass('error');
		   			if(the_element.find('.help-block.success').length == 0){
		   				the_element.append('<span for="promocode" class="help-block success " style="">'+responseObj.message+'</span>');
		   				if(responseObj.hasOwnProperty('amount') && responseObj.amount > 0){
		   					$('.promo-discount').show();
		   				}else{
		   					$('.promo-discount').hide();
		   				}
		   			}
			   }
			   ,postOnErrors:function(responseObj){
			   		var the_element = $('.control-group :input.promocode').parents('.control-group');
		   			the_element.removeClass('success');
		   			the_element.find('.help-block.success').remove();
			   }
			});
		}, 500);
	};





	function checkPromocodeMembershipRestrictions(){
		setTimeout(function() {
	        io.saw.FormPost.activate({postUrl:'/application/promocodeisvalidmemberhsip'
			   ,blockUI:'no'
			   ,serializeSelector:':input'
			   ,postOnComplete:function(responseObj,responseStatus){}
			   ,postOnSuccess:function(responseObj){
			   		var the_element = $('.control-group :input.promocode').parents('.control-group');
			   		if(responseObj.valid == 'yes'){
			   			window.promocodeisvalidmemberhsip = 'yes';
			   			$('#promocodetype').val(responseObj.type);
			   			the_element.addClass('success');
			   			the_element.removeClass('error');
			   			if(the_element.find('.help-block.success').length == 0){
			   				the_element.append('<span for="promocode" class="help-block success " style="">'+responseObj.message+'</span>');
			   				$('#promocodeverification').show();
			   				$('.promocodeblocks').hide();
			   				$('.'+responseObj.type).show();
			   				if(responseObj.hasOwnProperty('amount') && responseObj.amount > 0){
			   					window.promocodeamount = responseObj.amount;
			   					$('.promo-discount').show();
			   				}else{
			   					$('.promo-discount').hide();
			   					window.promocodeamount = 0;
			   				}
			   				
			   			}
			   		}
			   		if(responseObj.valid == 'no'){
			   			window.promocodeisvalidmemberhsip = 'no';
			   			$('#promocodetype').val('invalid');
			   			the_element.find('.help-block.success').remove();
						the_element.removeClass('success');
						$('#promocodeverification').hide();

						var the_element = $('.control-group :input.promocode').parents('.control-group');
			   			the_element.addClass('error');
			   			the_element.removeClass('success');
						if(the_element.find('.help-block.error').length == 0){
			   				the_element.append('<span for="promocode" class="help-block error " style="">'+responseObj.message+'</span>');				   				
			   			}
			   		}
			   		promocodelogic();
			   }
			});
		}, 500);
		
	};




	function purchase(){
		io.saw.FormPost.activate({postUrl:'/join'
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
	Join.init = function(){
		
		// BEGIN submit button triggers
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      purchase();
		   }
		});
		var DELAY = 500, clicks = 0, timer = null;
		$(function(){
		    $('#saw-form .btn.green').on("click", function(e){
		        clicks++;  //count clicks
		        if(clicks === 1) {
		            timer = setTimeout(function() {
		                purchase();  //perform single-click action    
		                clicks = 0;             //after action performed, reset counter
		            }, DELAY);
		        } else {
		            clearTimeout(timer);    //prevent single-click action
		            purchase();  //perform double-click action
		            clicks = 0;             //after action performed, reset counter
		        }
		    })
		    .on("dblclick", function(e){
		        e.preventDefault();  //cancel system double-click event
		    });
		});
		// END submit button triggers

		// prepare the CC month dropdown
	   	var select = $("#card-expMonth"),
	   	month = new Date().getMonth() + 1;
	   	for (var i = 1; i <= 12; i++) {
	   	   select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
	   	}

	   	// prepare the CC year dropdown
	   	var select = $("#card-expYear"),
	   	year = new Date().getFullYear();
	   	for (var i = 0; i < 12; i++) {
	   	   select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
	   	}
		// mask the phone field
		$.extend($.inputmask.defaults, {
            'autounmask': true
        });
        $("#phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $("#fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options

        // this calcutlates the membership fee based on profession and years in it
        $('#saw-form .specialLogic').change(function(){
        	calculateDues();
        });
        $('.promocode').keyup(function(){
        	window.clearTimeout(io.saw.Join.promocodetimeoutid);//cancel previous timer so they don't queue up when you're typing
			io.saw.Join.promocodetimeoutid = window.setTimeout(function(theThis){ // delay so it's not in every key-up stroke
				checkPromocode();
			},500,$(this));
        });
	};
	
}( io.saw.Join = io.saw.Join || {}, io.saw.jQuery || jQuery ));
</script>