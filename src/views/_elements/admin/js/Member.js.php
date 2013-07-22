<script type="text/javascript">
(function( Member, $, undefined ) {

	Member.init = function(){
		$('#saw-form input').keypress(function (e) {
			if (e.which == 13) {
				save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			save();
		});
		$('#saw-form .btn.cancel').click(function(e){
			document.location.href='/';			
		});
		$('#save-modal .btn.continue.edit').click(function(e){
			$('#save-modal').modal('hide');
		});		
		$('#save-modal .btn.continue.dashboard').click(function(e){
			document.location.href='/';
		});	

		$('#location .add').click(function(e){
			
		});		
		$('#location .delete').click(function(e){
			
		});		
		$('#location .edit').click(function(e){
			
		});		
		$('#location .cancel').click(function(e){
			
		});		
		

	};
	function save (){
		io.saw.FormPost.activate({postUrl:'/member/edit'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){
			   	if(responseStatus == 'success'){
			   	}else{
			   		var responseObj = $.parseJSON(responseObj.responseText);
			   	}
		   }
		   ,postOnSuccess:function(responseObj){
		   		$('#save-modal .modal-body p').html(responseObj.message);
		      	//$('#save-modal-label').html(responseObj.label);
		      	$('#save-modal').modal({keyboard: false});   		
		   }
		});      
	};
	
}( io.saw.Member = io.saw.Member || {}, io.saw.jQuery || jQuery ));
</script>