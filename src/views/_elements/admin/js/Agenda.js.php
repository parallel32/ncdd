<script type="text/javascript">
(function( Agenda, $, undefined ) {
	Agenda.save = function (){
		$('#input-description').val($('#description').html());
		io.saw.FormPost.activate({postUrl:'/agenda/saveTimeSlot'
		   ,formName:'#edit-form'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      // clear the time slot modal form
		      document.location.href='/agenda/<?=$this->vars['seminar']->_id?>/manage';
		   }
		});      
	};
	function remove (){
		$('#input-description').val($('#description').html());
		io.saw.FormPost.activate({postUrl:'/agenda/removeTimeSlot'
		   ,formName:'#delete-form'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){}
		   ,postOnSuccess:function(responseObj){
		      // clear the time slot modal form
		      document.location.href='/agenda/<?=$this->vars['seminar']->_id?>/manage';
		   }
		});      
	};
	Agenda.init = function(){
		// show the time slot modal and prepare for adding a time slot
		$('.add-time-slot').click(function(e){
			e.preventDefault();
			//set the agenda id in the modal
			$('#edit-id').val($(this).attr('data-id'));
			$('.dateTime').val($(this).attr('data-date'));

			// activate the modal
			$('#timeslot-modal').modal({keyboard: false});	
			
		})
		// show the time slot modal and prepare for editing a time slot
		$('.edit-time-slot').click(function(e){
			e.preventDefault();
			//set the agenda id in the modal
			$('#edit-id').val($(this).attr('data-id'));
			// fill in the fields 
			$('#edit-form .date').val($('#'+$('#edit-id').val()+'-time').html());
			$('#edit-form .dateTime').val($(this).attr('data-date'));
			$('#edit-form .title').val($('#'+$('#edit-id').val()+'-title').html());
			$('#edit-form .color').val($('#'+$('#edit-id').val()+'-color').html());
			$('#description').html($('#'+$('#edit-id').val()+'-description').html());
			// activate the modal
			$('#timeslot-modal').modal({keyboard: false});	
			
		})
		// show the time slot modal and prepare for editing a time slot
		$('.delete-time-slot').click(function(e){
			e.preventDefault();
			//set the agenda id in the modal
			$('#delete-id').val($(this).attr('data-id'));
			// fill in the fields 
			$('#delete-form .date').val($('#'+$('#delete-id').val()+'-time').html());
			$('#delete-form .dateTime').val($(this).attr('data-date'));
			$('#delete-form .title').val($('#'+$('#delete-id').val()+'-title').html());
			// activate the modal
			$('#timeslot-delete-modal').modal({keyboard: false});	
		})


		// time slot modal form input handlers
		$('#edit-form input').keypress(function (e) {
		   if (e.which == 13) {
		      Agenda.save();
		   }
		});
		$('#timeslot-modal .btn.green').click(function(e){
			e.preventDefault();
			Agenda.save();
		});
		$('#timeslot-modal .cancel').click(function(e){
			$('#timeslot-modal').modal('hide');	
			// clear all validation colors
			$('.control-group').find('.help-block.error').remove();
			$('.error').removeClass('error');			
			$('.alert-error').addClass('hide').html('');
		});
		// delete modal handlers
		$('#timeslot-delete-modal .btn.green').click(function(e){
			e.preventDefault();
			remove();
		});
		$('#timeslot-delete-modal .cancel').click(function(e){
			$('#timeslot-delete-modal').modal('hide');	
			
			// clear all validation colors
			$('.control-group').find('.help-block.error').remove();
			$('.error').removeClass('error');			
			$('.alert-error').addClass('hide').html('');
		});
		// show the editor
		$('.show-editor').click(function(e){
			window.editor.api.activate();
		})
		
	};
	
}( io.saw.Agenda = io.saw.Agenda || {}, io.saw.jQuery || jQuery ));
</script>