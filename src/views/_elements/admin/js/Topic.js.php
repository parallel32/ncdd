<? 
$user = $this->app['session']->get('user');
$accessLevel = $user['accessLevel'];
$user_id = $user['user_id'];
?>
<script type="text/javascript">
(function( Topic, $, undefined ) {

	function remove(){
		io.saw.FormGet.activate({postUrl:'/topic/'+$('#_id').val()+'/remove'
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
	Topic.init = function(){
		
		//init autosave
		setTimeout(io.saw.Topic.autosave, 5000);

		// SAVE buttons and publish workflow buttons
		$('#saw-form input').keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault();
				Topic.save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			Topic.save();
		});
		$('#saw-form .btn.save-draft').click(function(e){
			Topic.saveDraft();
		});
		$('#saw-form .btn.review').click(function(e){
			Topic.saveReivew();
		});
		 	 
		
		$('#saw-form .btn.schedule').click(function(e){
			Topic.saveSchedule();
		});
		$('#saw-form .btn.publish').click(function(e){
			Topic.savePublish();
		});
		$('#saw-form .btn.unpublish').click(function(e){
			Topic.saveUnPublish();
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
		$('#save-modal .btn.my-posts').click(function(e){
			document.location.href='/forum/my-admin';
		});	
		$('#save-modal .btn.all-posts').click(function(e){
			document.location.href='/forum/admin';
		});	
		$('#saw-form .btn.manage-picture').click(function(e){
			Topic.save(function(responseObj){
				document.location.href='/topic/edit/'+responseObj.topicId+'/edit-photo';	
			});
			
		});	

	};
	Topic.saveReivew = function (){
		$('#currentStatus').val(<?=\Saw\Model\Topic::$status['REVIEW'];?>);
		Topic.save();
	};
	Topic.saveDraft = function (){
		$('#currentStatus').val(<?=\Saw\Model\Topic::$status['DRAFT'];?>);
		Topic.save();
	};

	Topic.saveSchedule = function (){
		$('#currentStatus').val(<?=\Saw\Model\Topic::$status['SCHEDULE'];?>);
		Topic.save();
	};
	Topic.savePublish = function (){
		$('#currentStatus').val(<?=\Saw\Model\Topic::$status['PUBLISH'];?>);
		Topic.save();
	};
	Topic.saveUnPublish = function (){
		$('#currentStatus').val(<?=\Saw\Model\Topic::$status['UNPUBLISH'];?>);
		Topic.save();
	};
	Topic.save = function (postSuccess,posturl,blockuiformpost){
		
		$('#files').val(JSON.stringify(files));

		tinymce.activeEditor.save();
		$('#input-body').val($('#body').html());

		var posturl = posturl || '/topic/edit'
		var blockuiformpost = blockuiformpost || 'yes'
		var postSuccess = postSuccess || function(responseObj){
				$('#editor-drive-file-iframe').attr('src','/drive/file/'+responseObj.topicId);
		   		$('#editor-drive-image-iframe').attr('src','/drive/image/'+responseObj.topicId);
		   		$('#_id').val(responseObj.topicId);
		   		$('#add').val('no');
		      	if(blockuiformpost == 'yes'){
			   		$('#save-modal .modal-body p').html(responseObj.message);
			      	//$('#save-modal-label').html(responseObj.label);
			    	$('#save-modal').modal({keyboard: false});   		
			    }   		
		   };

		io.saw.FormPost.activate({postUrl:posturl
		   ,serializeSelector:':input'
		   ,blockUI:blockuiformpost
		   ,postOnComplete:function(responseObj,responseStatus){
			   	if(responseStatus == 'success'){
			   	}else{
			   		var responseObj = $.parseJSON(responseObj.responseText);
			   	}
		   }
		   ,postOnSuccess:postSuccess
		});      
	};
	
	Topic.autosave = function(){
		if(tinymce.activeEditor.isDirty()){
			Topic.save(undefined,'/topic/edit/autosave','no')
		}
		setTimeout(Topic.autosave, 5000);
	};
	
	
}( io.saw.Topic = io.saw.Topic || {}, io.saw.jQuery || jQuery ));
</script>