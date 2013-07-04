<script type="text/javascript">
(function( ModuleAvailable, $, undefined ) {
	function add (){
		io.saw.FormPost.activate({postUrl:'/modules/available/add'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		   }
		});      
	};
	function edit (){
		io.saw.FormPost.activate({postUrl:'/modules/available/edit'
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
	ModuleAvailable.init = function(saveMode){
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
			document.location.href='/modules/available';
		});
		// modal buttons
		$('#save-success .finished').click(function(e){
			document.location.href='/modules/available';
		});
		$('#save-success .add-more').click(function(e){
			if(saveMode == 'add'){
				document.location.href='/modules/available/add';
			}else if(saveMode == 'edit'){
				document.location.href="/modules/available/edit/<?=(array_key_exists('module',$this->vars)) ? $this->vars['module']['_id']: '';?>";	
			}			
		});
	};
	ModuleAvailable.delete = function(moduleId){
		io.saw.FormGet.activate({postUrl:'/modules/available/delete/'+moduleId
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				console.log('#'+responseObj.id.$id+'-disable-btn');
				$('#'+responseObj.id.$id).remove();
			}
		});
	};  
}( io.saw.ModuleAvailable = io.saw.ModuleAvailable || {}, io.saw.jQuery || jQuery ));
</script>