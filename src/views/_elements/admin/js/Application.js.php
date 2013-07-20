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
		$('.btn.blue.mini.view').click(function(e){
			document.location.href='/application/'+$(this).attr('data-id')+'/view';
		});		
	};
	Application.approveInit = function(){
		$('#saw-form .btn.green.approve').click(function(e){
			approve($(this).attr('data-id'),$(this).attr('data-type'));
		});
		$('#saw-form .btn.cancel').click(function(e){
			document.location.href='/application';			
		});
		$('#saw-form .btn.red').click(function(e){
			// pop delete are you sure modal
			$('#delete-modal').modal({keyboard: false});
		});		
		$('#delete-modal .btn.green.continue').click(function(e){
			$('#delete-modal').modal('hide');
			remove($(this).attr('data-id'));
		});		
		$('#delete-modal .btn.cancel').click(function(e){
			$('#delete-modal').modal('hide');
		});		

	};
	
	function remove (id){
		io.saw.FormGet.activate({postUrl:'/application/'+id+'/delete'
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href='/applications';
			}
		});
	};
	function approve (id,type){
		io.saw.FormGet.activate({postUrl:'/application/'+id+'/approve/'+type
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href='/applications';
			}
		});
	};
}( io.saw.Application = io.saw.Application || {}, io.saw.jQuery || jQuery ));
</script>