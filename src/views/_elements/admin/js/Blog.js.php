<? 
$user = $this->app['session']->get('user');
$accessLevel = $user['accessLevel'];
$user_id = $user['user_id'];
?>
<script type="text/javascript">
(function( Blog, $, undefined ) {

	function slugify(str){
		io.saw.FormPost.activate({postUrl:'/blog/slugify'
		   ,blockUI:'no'
		   ,serializeSelector:'.headline'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		   		$('#saw-form .slug').val('/'+responseObj.slug);
		   }
		});      
	};
	function remove(){
		io.saw.FormGet.activate({postUrl:'/blog/'+$('#_id').val()+'/remove'
			,postOnComplete:function(responseObj,responseStatus){
				$('#delete-modal').modal('hide');
			}
			,postOnSuccess:function(responseObj){
				<? if($accessLevel >= EDITOR): ?>
		   			document.location.href = '/blog/all-posts';
		   		<? elseif($accessLevel == MEMBER): ?>
		   			document.location.href = '/blog/<?=$user_id?>';
		   		<? endif; ?>		   		
			}
		});    
	};
	Blog.init = function(){
		<?/**
		To Do
		*/?>
		//init autosave
		setTimeout(io.saw.Blog.autosave, 5000);

		// SAVE buttons and publish workflow buttons
		$('#saw-form .headline').keyup(function(e) {
			if (e.which != 13) {
				slugify($(this).val());
			}
		});
		$('#saw-form input').keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault();
				Blog.save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			Blog.save();
		});
		$('#saw-form .btn.save-draft').click(function(e){
			Blog.saveDraft();
		});
		$('#saw-form .btn.review').click(function(e){
			Blog.saveReivew();
		});
		<? 	 
		if($accessLevel >= EDITOR): ?>
			$('#saw-form .btn.schedule').click(function(e){
				Blog.saveSchedule();
			});
			$('#saw-form .btn.publish').click(function(e){
				Blog.savePublish();
			});
			$('#saw-form .btn.unpublish').click(function(e){
				Blog.saveUnPublish();
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
				document.location.href='/blog/<?=$this->vars['memberId']?>';
			<? elseif($accessLevel >= EDITOR): ?>
				document.location.href='/blog/all-posts';
			<? endif; ?>
		});
		$('#save-modal .btn.continue.edit').click(function(e){
			$('#save-modal').modal('hide');
		});		
		$('#save-modal .btn.dashboard').click(function(e){
			document.location.href='/';
		});	
		$('#save-modal .btn.my-posts').click(function(e){
			document.location.href='/blog/<?=$this->vars['memberId']?>';
		});	
		$('#save-modal .btn.all-posts').click(function(e){
			document.location.href='/blog/all-posts';
		});	
		$('#saw-form .btn.manage-picture').click(function(e){
			Blog.save(function(responseObj){
				document.location.href='/blog/<?=$this->vars['memberId']?>/edit/'+responseObj.blogId+'/edit-photo';	
			});
			
		});	

	};
	Blog.saveReivew = function (){
		$('#currentStatus').val(<?=\Saw\Model\Blog::$status['REVIEW'];?>);
		Blog.save();
	};
	Blog.saveDraft = function (){
		$('#currentStatus').val(<?=\Saw\Model\Blog::$status['DRAFT'];?>);
		Blog.save();
	};
	<? 	$user = $this->app['session']->get('user'); 
		if($user['accessLevel'] >= EDITOR): ?>
			Blog.saveSchedule = function (){
				$('#currentStatus').val(<?=\Saw\Model\Blog::$status['SCHEDULE'];?>);
				Blog.save();
			};
			Blog.savePublish = function (){
				$('#currentStatus').val(<?=\Saw\Model\Blog::$status['PUBLISH'];?>);
				Blog.save();
			};
			Blog.saveUnPublish = function (){
				$('#currentStatus').val(<?=\Saw\Model\Blog::$status['UNPUBLISH'];?>);
				Blog.save();
			};
	<? endif; ?>
	Blog.save = function (postSuccess,posturl,blockuiformpost){
		<?/**
        TODO
     */?>
		tinymce.activeEditor.save();
		var posturl = posturl || '/blog/<?=$this->vars['memberId']?>/edit'
		var blockuiformpost = blockuiformpost || 'yes'
		var postSuccess = postSuccess || function(responseObj){
			 <?/**
	            TODO
	         */?>
		   		$('#editor-drive-file-iframe').attr('src','/drive/file/'+responseObj.blogId);
		   		$('#editor-drive-image-iframe').attr('src','/drive/image/'+responseObj.blogId);
		   		$('#_id').val(responseObj.blogId);
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
	Blog.autosave = function(){
		if(tinymce.activeEditor.isDirty()){
			$('#currentStatus').val(<?=\Saw\Model\Blog::$status['DRAFT'];?>);
			Blog.save(undefined,'/blog/<?=$this->vars['memberId']?>/autosave','no')
		}
		setTimeout(Blog.autosave, 5000);
	};
	
	
}( io.saw.Blog = io.saw.Blog || {}, io.saw.jQuery || jQuery ));
</script>