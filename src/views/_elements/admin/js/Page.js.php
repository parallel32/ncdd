<script type="text/javascript">
(function( Page, $, undefined ) {

	function slugify(str){
		io.saw.FormPost.activate({postUrl:'/blog/slugify'
		   ,blockUI:'no'
		   ,serializeSelector:'.headline'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		   		$('#saw-form .slug').val(responseObj.slug);
		   }
		});      
	};

	Page.init = function(){
		$('#saw-form .headline').keyup(function(e) {
			if (e.which != 13) {
				slugify($(this).val());
			}
		});
		
		$('#saw-form input').keypress(function(e) {
			if (e.which == 13) {
				e.preventDefault();
				Page.save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			Page.save();
		});
		$('#saw-form .btn.cancel').click(function(e){
			document.location.href='/page/';			
		});
		$('#save-modal .btn.continue.edit').click(function(e){
			$('#save-modal').modal('hide');
		});		
		$('#save-modal .btn.continue.dashboard').click(function(e){
			document.location.href='/page/';
		});	

	};
	Page.save = function (){
		tinymce.activeEditor.save();
		$('#input-body').val($('#body').html());
		io.saw.FormPost.activate({postUrl:'/page/edit'
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
	
	
}( io.saw.Page = io.saw.Page || {}, io.saw.jQuery || jQuery ));
</script>