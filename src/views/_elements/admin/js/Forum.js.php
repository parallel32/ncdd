<? 
$user = $this->app['session']->get('user');
$accessLevel = $user['accessLevel'];
$user_id = $user['user_id'];
?>
<script type="text/javascript">
(function( Forum, $, undefined ) {

	function remove(){
		io.saw.FormGet.activate({postUrl:'/forum/'+$('#_id').val()+'/remove'
			,postOnComplete:function(responseObj,responseStatus){
				$('#delete-modal').modal('hide');
			}
			,postOnSuccess:function(responseObj){
				<? if($accessLevel >= EDITOR): ?>
		   			document.location.href = '/forum/admin';
		   		<? elseif($accessLevel == MEMBER): ?>
		   			document.location.href = '/forum/my-admin';
		   		<? endif; ?>		   		
			}
		});    
	};
	Forum.init = function(){
		

		$('#saw-form input').keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault();
				Forum.save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			Forum.save();
		});
		$('#saw-form .btn.save-draft').click(function(e){
			Forum.saveDraft();
		});
		$('#saw-form .btn.review').click(function(e){
			Forum.saveReivew();
		});
		
		<? 	 
		if($accessLevel >= EDITOR): ?>
			$('#saw-form .btn.publish').click(function(e){
				Forum.savePublish();
			});
			$('#saw-form .btn.unpublish').click(function(e){
				Forum.saveUnPublish();
			});

		<? endif; ?>

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
			<? 
			if($accessLevel == MEMBER): 
			?>
				document.location.href='/forum/my-admin';
			<? elseif($accessLevel >= EDITOR): ?>
				document.location.href='/forum/admin';
			<? endif; ?>
		});
		$('#save-modal .btn.continue.edit').click(function(e){
			$('#save-modal').modal('hide');
		});		
		$('#save-modal .btn.dashboard').click(function(e){
			document.location.href='/';
		});	
		$('#save-modal .btn.my-admin').click(function(e){
			document.location.href='/forum/my-admin';
		});	
		$('#save-modal .btn.admin').click(function(e){
			document.location.href='/forum/admin';
		});	
		$('#saw-form .btn.manage-picture').click(function(e){
			Forum.save(function(responseObj){
				document.location.href='/forum/edit/'+responseObj.forumId+'/edit-photo';	
			});
			
		});	

	};
	Forum.saveReivew = function (){
		$('#currentStatus').val(<?=\Saw\Model\Forum::$status['REVIEW'];?>);
		Forum.save();
	};
	Forum.saveDraft = function (){
		$('#currentStatus').val(<?=\Saw\Model\Forum::$status['DRAFT'];?>);
		Forum.save();
	};
	<? 	$user = $this->app['session']->get('user'); 
		if($user['accessLevel'] >= EDITOR): ?>
			Forum.savePublish = function (){
				$('#currentStatus').val(<?=\Saw\Model\Forum::$status['PUBLISH'];?>);
				Forum.save();
			};
			Forum.saveUnPublish = function (){
				$('#currentStatus').val(<?=\Saw\Model\Forum::$status['UNPUBLISH'];?>);
				Forum.save();
			};
	<? endif; ?>
	Forum.save = function (postSuccess){
		
	
		var postSuccess = postSuccess || function(responseObj){
		   		$('#_id').val(responseObj.forumId);
		   		$('#add').val('no');
		   		$('#save-modal .modal-body p').html(responseObj.message);
		      	//$('#save-modal-label').html(responseObj.label);
		      	$('#save-modal').modal({keyboard: false});   		
		   };

		io.saw.FormPost.activate({postUrl:'/forum/edit'
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
	
	
}( io.saw.Forum = io.saw.Forum || {}, io.saw.jQuery || jQuery ));
</script>