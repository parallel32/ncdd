<? $user = $this->app['session']->get('user'); ?>
<script type="text/javascript">
(function( Scholarship, $, undefined ) {
	function apply (){
		io.saw.FormPost.activate({postUrl:'/scholarship/apply'
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
	function save (){
		io.saw.FormPost.activate({postUrl:'/scholarship/edit'
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
	Scholarship.applyInit = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      apply();
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			apply();
		});
		$('#saw-form .cancel-go-back').click(function(e){
			e.preventDefault();
			<? if(!empty($user)){ ?>
			document.location.href="https://<?=SAW_ADMIN_WEBSITE?>/seminar";
			<? } else { ?>
			document.location.href="https://<?=SAW_CONSUMER_WEBSITE?>/sessions-and-seminars";
			<? } ?>
		});
		$('#save-success .btn.continue').click(function(e){
			e.preventDefault();
			<? if(!empty($user)){ ?>
			document.location.href="https://<?=SAW_ADMIN_WEBSITE?>/seminar";
			<? } else { ?>
			document.location.href="https://<?=SAW_CONSUMER_WEBSITE?>/sessions-and-seminars";
			<? } ?>
		});

		$.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $("#fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options

	};
	Scholarship.editInit = function(){
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		   	  e.preventDefault();
		      save();
		   }
		});
		$('#saw-form .btn.green').click(function(e){
			e.preventDefault();
			save();
		});
		$('#saw-form .cancel-go-back').click(function(e){
			e.preventDefault();
			document.location.href='/scholarship/'+$(this).attr('data-id')+'/view';
		});
		$('#save-success .btn.continue-editing').click(function(e){
			$('#save-success').modal('hide');
		});
		$('#save-success .btn.all-scholarships').click(function(e){
			document.location.href='/scholarship/'+$(this).attr('data-id')+'/view';
		});
		
		$.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#phone").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options
        $("#fax").inputmask("mask", {"mask": "(999) 999-9999"}); //specifying fn & options

	};
	Scholarship.init = function(){
		$('.btn.blue.mini.view').click(function(e){
			document.location.href='/scholarship/'+$(this).attr('data-id')+'/view';
		});		
		$('.btn.blue.mini.view.member').click(function(e){
			document.location.href='/member/'+$(this).attr('data-id')+'/edit';
		});		
	};
	Scholarship.approveInitSpecial = function(){
		$('#saw-form .btn.green.approve').click(function(e){
			approve($(this).attr('data-id'));
		});
	};
	Scholarship.approveInit = function(){
		$('#saw-form .btn.green.approve').click(function(e){
			approve($(this).attr('data-id'));
		});

		$('#trial-modal .btn.green.continue').click(function(e){
			approveTrial($(this).attr('data-id'));
		});
		$('#trial-modal .btn.cancel').click(function(e){
			e.preventDefault();
			$('#trial-modal').modal('hide');
		});		
		
		
		$('#saw-form .btn.cancel').click(function(e){
			e.preventDefault();
			document.location.href="/scholarships";
		});
		$('#saw-form .btn.red').click(function(e){
			// pop delete are you sure modal
			$('#delete-modal').modal({keyboard: false});
		});		
		$('#delete-modal .btn.red.continue').click(function(e){
			$('#delete-modal').modal('hide');
			remove($(this).attr('data-id'));
		});		
		$('#delete-modal .btn.cancel').click(function(e){
			e.preventDefault();
			$('#delete-modal').modal('hide');
		});		
		$('#saw-form .btn.edit').click(function(e){
			e.preventDefault();
			document.location.href='/scholarship/'+$(this).attr('data-id')+'/edit';
		});
		$('#saw-form .btn.pay').click(function(e){
			e.preventDefault();
			document.location.href='/scholarship/'+$(this).attr('data-id')+'/pay-other';
		});
		
	};
	function remove (id){
		io.saw.FormGet.activate({postUrl:'/scholarship/'+id+'/delete'
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href="/scholarships";
			}
		});
	};
	function approve (id,type){
		if($('input[name="suppress_emails"]:checked').length > 0){
			var suppress_emails = '?suppress_emails=yes';
		}else{
			var suppress_emails = '';
		}
		io.saw.FormGet.activate({postUrl:'/scholarship/'+id+'/approve'+suppress_emails
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				document.location.href="/seminar/";
			}
		});
	};
	
}( io.saw.Scholarship = io.saw.Scholarship || {}, io.saw.jQuery || jQuery ));
</script>