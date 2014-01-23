<script type="text/javascript">
(function( Product, $, undefined ) {
	function slugify(str){
		io.saw.FormPost.activate({postUrl:'/product/slugify'
		   ,blockUI:'no'
		   ,serializeSelector:'.name'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		   		$('#saw-form .slug').val('/'+responseObj.slug);
		   }
		});      
	};
	
	function remove(){
		io.saw.FormGet.activate({postUrl:'/product/'+$('#_id').val()+'/remove'
			,postOnComplete:function(responseObj,responseStatus){
				$('#delete-modal').modal('hide');
			}
			,postOnSuccess:function(responseObj){
				document.location.href = '/product';
			}
		});    
	};
	Product.init = function(){
		
		// SAVE buttons and publish workflow buttons
		$('#saw-form .name').keyup(function(e) {
			if (e.which != 13) {
				slugify($(this).val());
			}
		});
		// SAVE buttons and publish workflow buttons
		$('#saw-form input').keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault();
				Product.save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			Product.saveDraft();
		});
		$('#saw-form .btn.save-publish').click(function(e){
			Product.savePublish();
		});
		$('#saw-form .btn.delete').click(function(e){
	      	$('#delete-modal').modal({keyboard: false});   
		});
		$('#delete-modal .btn.yes').click(function(e){
			remove();	
		});
		$('#delete-modal .btn.no').click(function(e){
			$('#delete-modal').modal('hide');
		});


		// Modal Button handlers:
		$('#saw-form .btn.cancel').click(function(e){
			document.location.href='/product';
		});
		$('#save-modal .btn.continue.edit').click(function(e){
			$('#save-modal').modal('hide');
		});		
		$('#save-modal .btn.dashboard').click(function(e){
			document.location.href='/';
		});	
		$('#save-modal .btn.all-posts').click(function(e){
			document.location.href='/product';
		});	
		$('#saw-form .btn.manage-picture').click(function(e){
			Product.save(function(responseObj){
				document.location.href='/product/edit/'+responseObj.productId+'/edit-photo';	
			});
			
		});	

	};
	Product.savePublish = function (){
		$('#currentStatus').val(<?=\Saw\Model\Product::$status['PUBLISH'];?>);
		Product.save();
	};
	Product.saveDraft = function (){
		$('#currentStatus').val(<?=\Saw\Model\Product::$status['UNPUBLISH'];?>);
		Product.save();
	};
	Product.save = function (postSuccess){
		
		$('#input-description').val($('#description').html());

		var postSuccess = postSuccess || function(responseObj){
		   		$('#_id').val(responseObj.productId);
		   		$('#add').val('no');
		   		$('#save-modal .modal-body p').html(responseObj.message);
		      	//$('#save-modal-label').html(responseObj.label);
		      	$('#save-modal').modal({keyboard: false});   		
		   };

		io.saw.FormPost.activate({postUrl:'/product/edit'
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
	
	
}( io.saw.Product = io.saw.Product || {}, io.saw.jQuery || jQuery ));
</script>