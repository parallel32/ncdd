<script type="text/javascript">
(function( Application, $, undefined ) {
	function newMemberAdd (){
		io.saw.FormPost.activate({postUrl:'/application/new-member'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){
			   	if(responseStatus == 'success'){
					$('#save-success .modal-body p').html(responseObj.message);
			      	$('#save-success-label').html(responseObj.label);
			      	$('#save-success').modal({keyboard: false});   		
			   	}else{
			   		var responseObj = $.parseJSON(responseObj.responseText);
			   	}
		   }
		   ,postOnSuccess:function(responseObj){}
		});      
	};
	Application.newMemberInit = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
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
		$('#save-success .cancel').click(function(e){
			document.location.href="http://<?=SAW_CONSUMER_WEBSITE?>";
		});

		$.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $("#fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
		
	};
	Application.init = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		   	  
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			
		});		
	};
	Application.approveInit = function(){
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			approve($(this).attr('data-id'));
		});
		$('#saw-form .btn.cancel').click(function(e){
			document.location.href='/application';			
		});
		$('#saw-form .btn.red').click(function(e){
			e.preventDefault();
			delete($(this).attr('data-id')); // add are you sure modal.....
		});		
	};
	
	function delete (id){
		io.saw.FormGet.activate({postUrl:'/application/'+id+'/delete'
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href='/application/';
			}
		});
	};
	function approve (id){
		io.saw.FormGet.activate({postUrl:'/application/'+id+'/approve'
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href='/application/';
			}
		});
	};
}( io.saw.Application = io.saw.Application || {}, io.saw.jQuery || jQuery ));
</script>