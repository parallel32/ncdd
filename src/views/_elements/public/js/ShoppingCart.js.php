<script type="text/javascript">
(function( ShoppingCart, $, undefined ) {
	
	// remove a product
	function remove(theThis){

		io.saw.FormGet.activate({
			blockUIParams:{
				elementToBlock:'.productDescrrr'
				,loadingImg:'/assets/img/subtract_from_cart.png'
			}
			,postUrl:'/shopping-cart/remove/'+theThis.attr('data-id')
			,postOnComplete:function(responseObj,responseStatus){
				
			}
			,postOnSuccess:function(responseObj){
				//$('#sup-cart').html($('#sup-cart').html()-1);
				//theThis.parents('tr').remove();
				document.location.href='/shopping-cart';
			}
		});    
	};
	ShoppingCart.init = function(){
		
		// SAVE buttons and publish workflow buttons
		$('#quantity').keyup(function(e) {
			$('#doc-quantity').val($(this).val());
		});
		// SAVE buttons and publish workflow buttons
		$('#saw-form2 input').keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault();
				ShoppingCart.save();
			}
		});
		$('#add-to-cart').click(function(e){
			e.preventDefault();
			ShoppingCart.save();
		});
		$('.addToCardBtn').click(function(e){
			e.preventDefault();
			var theThis = $(this);
			ShoppingCart.saveByGet(theThis);
		});
		$('.btn.update').click(function(e){
			e.preventDefault();
			var theThis = $(this);
			ShoppingCart.saveFromCart(theThis);
		});
		
		$('.remove').click(function(e){
			e.preventDefault();
	      	remove($(this));
		});
			

	};
	ShoppingCart.saveFromCart = function (theThis){
		$('#preference-hidden-'+theThis.attr('data-id')).val($('#preference-'+theThis.attr('data-id')).val())
		$('#quantity-hidden-'+theThis.attr('data-id')).val($('#quantity-'+theThis.attr('data-id')).val())
		var postSuccess = postSuccess || function(responseObj){
	   		document.location.href='/shopping-cart';
		};
		io.saw.FormPost.activate({
			blockUIParams:{
				elementToBlock:'#cell-'+theThis.attr('data-id')
			}
			,formName:'#saw-form-'+theThis.attr('data-id')
			,postUrl:'/shopping-cart/add'
			,serializeSelector:':input'
		 	,postOnComplete:function(responseObj,responseStatus){
			   	if(responseStatus == 'success'){
			   	}else{
			   		var responseObj = $.parseJSON(responseObj.responseText);
			   	}
		   	}
		   ,postOnSuccess:postSuccess
		});      
	};
	ShoppingCart.save = function (postSuccess){
		$('#doc-quantity').val($('#quantity').val());
		var postSuccess = postSuccess || function(responseObj){
	   		//console.log(responseObj.message);
		};
		io.saw.FormPost.activate({
			blockUIParams:{
				elementToBlock:'.productDescr'
				,loadingImg:'/assets/img/add_to_cart.png'
			}
			,postUrl:'/shopping-cart/add'
			,serializeSelector:':input'
		 	,postOnComplete:function(responseObj,responseStatus){
			   	if(responseStatus == 'success'){
			   	}else{
			   		var responseObj = $.parseJSON(responseObj.responseText);
			   	}
		   	}
		   ,postOnSuccess:postSuccess
		});      
	};
	ShoppingCart.saveByGet = function (elementClicked){

		if(elementClicked.parent().find('.quantity-input').val() > 1){
			var quantity = elementClicked.parent().find('.quantity-input').val();
		}else{
			var quantity = 1;
		}
		io.saw.FormGet.activate({blockUIParams:{loadingImg:'/assets/img/add_to_cart.png',elementToBlock:elementClicked.parents('.productDescr')},postUrl:'/shopping-cart/add/'+elementClicked.attr('data-id')+'/'+quantity
	    	,postOnComplete:function(responseObj,responseStatus){}
	      	,postOnSuccess:function(responseObj){
	         //document.location.href='/registrations';
	      	}
	   	});
	};
	
	
}( io.saw.ShoppingCart = io.saw.ShoppingCart || {}, io.saw.jQuery || jQuery ));
</script>