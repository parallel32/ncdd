<?php
// set the domainId for the add / edit URL's

if(array_key_exists('domainId',$this->vars)){
	$domainId = $this->vars['domainId'];
}else if(array_key_exists('link',$this->vars)){
	$domainId = $this->vars['link']['domainId'];
}else{
	$domainId = '';
}
?>
<script type="text/javascript">
(function( Link, $, undefined ) {
	function addBatch (){
		io.saw.FormPost.activate({postUrl:'/links/addbatch'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		   }
		   ,postOnErrors:function(responseObj){
				var params = io.saw.FormPost.getParams();
				var error_str = '';
				$.each(responseObj.errors, function(index,value){
					error_str+='<li>'+value+'</li>';
				});
				$(params.formName+' .alert-error').removeClass('hide').html('<span>'+responseObj.message+'</span>'+error_str);
		   }
		});      
	};
	function add (){
		io.saw.FormPost.activate({postUrl:'/links/add'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		   }
		});      
	};
	function edit (){
		io.saw.FormPost.activate({postUrl:'/links/edit'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		   }
		});      
	};
	//sets the alias automatically on name change
	function onNameChange(){
		$('#saw-form .name').keyup(function(e){
		   $('#saw-form .serverAliasSaw').val($(this).val());
		});
	};
	Link.init = function(saveMode){
		onNameChange();
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		      if(saveMode == 'edit' || saveMode == 'editroute'){
		         edit();
		      }else if(saveMode == 'add'){
		         add();
		      }else if(saveMode == 'addbatch'){
		         addBatch();
		      }
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			if(saveMode == 'edit' || saveMode == 'editroute'){
				edit();
			}else if(saveMode == 'add'){
				add();
			}else if(saveMode == 'addbatch'){
				addBatch();
			}
		});
		$('#saw-form .cancel').click(function(e){
			document.location.href='/links/<?=$domainId?>';
		});
		// modal buttons
		$('#save-success .finished').click(function(e){
			document.location.href='/links/<?=$domainId?>';
		});
		$('#save-success .add-more').click(function(e){
			if(saveMode == 'add'){
				document.location.href='/links/<?=$domainId?>/add';
			}else if(saveMode == 'edit'){
				document.location.href="/links/edit/<?=(array_key_exists('link',$this->vars)) ? $this->vars['link']['_id']: '';?>";	
			}else if(saveMode == 'editroute'){
				document.location.href="/links/<?=$domainId?>/editroute";	
			}else if(saveMode == 'addbatch'){
				document.location.href='/links/<?=$domainId?>/addbatch';
			}			
		});
	};
	Link.delete = function(linkId){
		io.saw.FormGet.activate({postUrl:'/links/delete/'+linkId
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				$('#'+responseObj.id.$id).remove();
			}
		});
	};
	Link.sluggifyTimeoutId = undefined;
	Link.sluggify = function(inputEl,targetEl){
		$('.'+inputEl).bind("paste keyup", function(e) {
			if (e.which != 13) { // don't let it slugify when the enter key is hit because it interferes with the form post
				$('#slug-str').val($(this).val());
				window.clearTimeout(this.sluggifyTimeoutId);//cancel previous timer so they don't queue up when you're typing
				this.sluggifyTimeoutId = window.setTimeout(function(){ // delay the post so it's not in every key-up stroke
					io.saw.FormPost.activate({postUrl:'/links/slugify'
			    		,formName:'#saw-slug'
						,postOnComplete:function(responseObj,responseStatus){}
						,postOnSuccess:function(responseObj){
							if (!/\//i.test(responseObj.slug)){
								responseObj.slug = '/'+responseObj.slug;
							}
							if($('#'+targetEl+'-slug').is('input')){
								$('#'+targetEl+'-slug').val(responseObj.slug);
							}else{
								$('#'+targetEl+'-slug').html(responseObj.slug);
							}
							
						}
						,blockUI:'no'
						,validate:'no'
					});	
				},1000);
		    	
			}
		});

	};
}( io.saw.Link = io.saw.Link || {}, io.saw.jQuery || jQuery ));
</script>