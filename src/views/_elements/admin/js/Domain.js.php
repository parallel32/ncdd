<script type="text/javascript">
(function( Domain, $, undefined ) {

	function add (){
		io.saw.FormPost.activate({postUrl:'/domains/add'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		   }
		});      
	}
	function edit (){
		io.saw.FormPost.activate({postUrl:'/domains/edit'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		   }
		});      
	}
	//sets the alias automatically on name change
	function onNameChange(){
		$('#saw-form .name').keyup(function(e){
		   $('#saw-form .serverAliasSaw').val($(this).val());
		});
	}
	Domain.init = function(saveMode){
		onNameChange();
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		      if(saveMode == 'edit'){
		         edit();
		      }else if(saveMode == 'add'){
		         add();
		      }
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			if(saveMode == 'edit'){
				edit();
			}else if(saveMode == 'add'){
				add();
			}
		});
		$('#saw-form .cancel').click(function(e){
			document.location.href='/domains/<?=$this->vars['clientId']?>';
		});
		$('#save-success .finished').click(function(e){
			document.location.href='/domains/<?=$this->vars['clientId']?>';
		});
		$('#save-success .add-more').click(function(e){
			if(saveMode == 'add'){
				document.location.href='/domains/<?=$this->vars['clientId']?>/add';
			}else if(saveMode == 'edit'){
				document.location.href="/domains/edit/<?=(array_key_exists('domain',$this->vars)) ? $this->vars['domain']['_id']: '';?>";	
			}			
		});
	};
	Domain.enable = function(domainName){
		io.saw.FormGet.activate({postUrl:'/domains/enable/'+domainName
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				$('#'+responseObj.id.$id+'-enable-btn').hide();
				$('#'+responseObj.id.$id+'-disable-btn').show();
			}
		});		
	};

	Domain.disable = function(domainName){
		io.saw.FormGet.activate({postUrl:'/domains/disable/'+domainName
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				$('#'+responseObj.id.$id+'-enable-btn').show();
				$('#'+responseObj.id.$id+'-disable-btn').hide();
			}
		});
	};
	Domain.delete = function(domainName){
		io.saw.FormGet.activate({postUrl:'/domains/delete/'+domainName
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				$('#'+responseObj.id.$id).remove();
			}
		});
	};
  	Domain.modulesAdd = function(domainId, moduleId){
		io.saw.FormGet.activate({postUrl:'/domains/modules/add/'+domainId+'/'+moduleId
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){}
		});
	};
  	Domain.modulesRemove = function(domainId, moduleId){
		io.saw.FormGet.activate({postUrl:'/domains/modules/remove/'+domainId+'/'+moduleId
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){}
		});
	};
}( io.saw.Domain = io.saw.Domain || {}, io.saw.jQuery || jQuery ));
</script>