<script type="text/javascript">
(function( Reference, $, undefined ) {
	function add (){		
		io.saw.FormPost.activate({postUrl:'/reference/'+$('#applicationId').val()
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
	Reference.init = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      add();
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			add();
		});
		$('#saw-form .cancel-go-back').click(function(e){
			e.preventDefault();
			document.location.href="https://<?=SAW_CONSUMER_WEBSITE?>";
		});
		$('#save-success .btn.continue').click(function(e){
			e.preventDefault();
			window.location.href="https://<?=SAW_CONSUMER_WEBSITE?>";
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
		io.saw.FormGet.activate({postUrl:'/reference/'+id+'/delete'
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href='/reference';
			}
		});
	};
	
	
}( io.saw.Reference = io.saw.Reference || {}, io.saw.jQuery || jQuery ));
</script>