<script type="text/javascript">
(function( Application, $, undefined ) {
	function newMemberAdd (){
		io.saw.FormPost.activate({postUrl:'/application/add'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		      $('#save-success .continue').attr('data-insertid',responseObj.id.$id);
		   }
		});      
	};
	function add (){
		io.saw.FormPost.activate({postUrl:'/application/add'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		      $('#save-success .continue').attr('data-insertid',responseObj.id.$id);
		   }
		});      
	};
	function edit (){
		io.saw.FormPost.activate({postUrl:'/application/edit'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      $('#save-success .modal-body p').html(responseObj.message);
		      $('#save-success').modal({keyboard: false});
		   }
		});      
	};
	Application.newMemberInit = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		      newMemberAdd();
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			newMemberAdd();
		});
		$('#saw-form .cancel').click(function(e){
			document.location.href="http://<?=SAW_CONSUMER_WEBSITE?>";
		});

		$.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $("#fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
		
	};
	Application.init = function(saveMode){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  $('#description').val($('.description').html());
		      if(saveMode == 'edit'){
		         edit();
		      }else if(saveMode == 'add'){
		         add();
		      }
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			$('#description').val($('.description').html());
			if(saveMode == 'edit'){
				edit();
			}else if(saveMode == 'add'){
				add();
			}
		});
		$('#saw-form .cancel').click(function(e){
			document.location.href="/application/view/<?=(array_key_exists('application',$this->vars)) ? $this->vars['application']['_id']: '';?>";	
		});
		
	};
	Application.delete = function(id){
		io.saw.FormGet.activate({postUrl:'/application/delete/'+id
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href='/application/';
			}
		});
	};
}( io.saw.Application = io.saw.Application || {}, io.saw.jQuery || jQuery ));
</script>