<script type="text/javascript">
(function( StateSeminar, $, undefined ) {

	function slugify(str){
		io.saw.FormPost.activate({postUrl:'/stateseminar/slugify'
		   ,blockUI:'no'
		   ,serializeSelector:'.name'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		   		$('#saw-form .slug').val('/'+responseObj.slug);
		   }
		});      
	};
	
	function remove(){
		io.saw.FormGet.activate({postUrl:'/stateseminar/'+$('#_id').val()+'/remove'
			,postOnComplete:function(responseObj,responseStatus){
				$('#delete-modal').modal('hide');
			}
			,postOnSuccess:function(responseObj){
				document.location.href = '/stateseminar';
			}
		});    
	};
	StateSeminar.init = function(){
		
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
				StateSeminar.save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			StateSeminar.save();
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
			document.location.href='/stateseminar';
		});
		$('#save-modal .btn.continue.edit').click(function(e){
			$('#save-modal').modal('hide');
		});		
		$('#save-modal .btn.dashboard').click(function(e){
			document.location.href='/';
		});	
		$('#save-modal .btn.all-stateseminars').click(function(e){
			document.location.href='/stateseminar';
		});	
		$('#saw-form .btn.manage-picture').click(function(e){
			StateSeminar.save(function(responseObj){
				document.location.href='/stateseminar/edit/'+responseObj.stateseminarId+'/edit-photo';	
			});
			
		});	

	};
	StateSeminar.save = function (postSuccess){
		
		var postSuccess = postSuccess || function(responseObj){
		   		$('#_id').val(responseObj.stateseminarId);
		   		$('#add').val('no');
		   		$('#save-modal .modal-body p').html(responseObj.message);
		      	//$('#save-modal-label').html(responseObj.label);
		      	$('#save-modal').modal({keyboard: false});   		
		   };

		io.saw.FormPost.activate({postUrl:'/stateseminar/edit'
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
	
	
}( io.saw.StateSeminar = io.saw.StateSeminar || {}, io.saw.jQuery || jQuery ));
</script>