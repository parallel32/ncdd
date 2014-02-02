<script type="text/javascript">
(function( Category, $, undefined ) {

	function remove(){
		io.saw.FormGet.activate({postUrl:'/category/'+$('#_id').val()+'/remove'
			,postOnComplete:function(responseObj,responseStatus){
				$('#delete-modal').modal('hide');
			}
			,postOnSuccess:function(responseObj){
				document.location.href = '/category';
			}
		});    
	};
	Category.init = function(){
		

		// SAVE buttons and publish workflow buttons
		$('#saw-form input').keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault();
				Category.save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			Category.save();
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
			document.location.href='/category';
		});
		$('#save-modal .btn.continue.edit').click(function(e){
			$('#save-modal').modal('hide');
		});		
		$('#save-modal .btn.dashboard').click(function(e){
			document.location.href='/';
		});	
		$('#save-modal .btn.all-categories').click(function(e){
			document.location.href='/category';
		});	
		$('#saw-form .btn.manage-picture').click(function(e){
			Category.save(function(responseObj){
				document.location.href='/category/edit/'+responseObj.categoryId+'/edit-photo';	
			});
			
		});	

	};
	Category.save = function (postSuccess){
		
		var postSuccess = postSuccess || function(responseObj){
		   		$('#_id').val(responseObj.categoryId);
		   		$('#add').val('no');
		   		$('#save-modal .modal-body p').html(responseObj.message);
		      	//$('#save-modal-label').html(responseObj.label);
		      	$('#save-modal').modal({keyboard: false});   		
		   };

		io.saw.FormPost.activate({postUrl:'/category/edit'
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
	
	
}( io.saw.Category = io.saw.Category || {}, io.saw.jQuery || jQuery ));
</script>