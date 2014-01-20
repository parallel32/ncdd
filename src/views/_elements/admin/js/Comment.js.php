<script type="text/javascript">
(function( Comment, $, undefined ) {

	Comment.refresh_loc = '';
	Comment.init = function(refresh_loc){
		Comment.refresh_loc = refresh_loc;
		$('#saw-form input').keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault();
				Comment.save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			Comment.save();
		});
		$('#save-modal .btn.continue.edit').click(function(e){
			$('#save-modal').modal('hide');
		});		
		$('#save-modal .btn.continue.dashboard').click(function(e){
			document.location.href='/comment/';
		});	

	};
	Comment.save = function (){
		$('#saw-form .btn.save').html('Posting...');
		io.saw.FormPost.activate({postUrl:'/comment/private/post'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){
			   	if(responseStatus == 'success'){
			   		$('#saw-form .btn.save').html('Your Comment Saved. Post another Comment.');
			   		$('#comment-message').val('');
			   		document.location.href=Comment.refresh_loc+'#comments';
			   	}else{
			   		var responseObj = $.parseJSON(responseObj.responseText);
			   		$('#saw-form .btn.save').html('Posting failed. Try again.');
			   	}
		   }
		   ,postOnSuccess:function(responseObj){
		   		
		   }
		});      
	};
	
	
}( io.saw.Comment = io.saw.Comment || {}, io.saw.jQuery || jQuery ));
</script>