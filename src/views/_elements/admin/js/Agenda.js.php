<script type="text/javascript">
(function( Agenda, $, undefined ) {
	function save (){
		$('#input-description').val($('#description').html());
		io.saw.FormPost.activate({postUrl:'/agenda/saveTimeSlot'
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
			$('#id').val($(this).attr('data-id'));
			$('.dateTime').val($(this).attr('data-date'));

			// activate the modal
			$('#timeslot-modal').modal({keyboard: false});	
		})
		// show the time slot modal and prepare for editing a time slot
		$('.edit-time-slot').click(function(e){
			e.preventDefault();
			//set the agenda id in the modal
			$('#id').val($(this).attr('data-id'));
			// fill in the fields 
			$('.date').val($('#'+$('#id').val()+'-time').html());
			$('.dateTime').val($(this).attr('data-date'));
			$('.title').val($('#'+$('#id').val()+'-title').html());
			$('.color').val($('#'+$('#id').val()+'-color').html());
			$('#description').html($('#'+$('#id').val()+'-description').html());
			// activate the modal
			$('#timeslot-modal').modal({keyboard: false});	
		})
		// show the time slot modal and prepare for editing a time slot
		$('.delete-time-slot').click(function(e){
			e.preventDefault();
			//set the agenda id in the modal
			$('#id').val($(this).attr('data-id'));
			// fill in the fields 
			$('.date').val($('#'+$('#id').val()+'-time').html());
			$('.dateTime').val($(this).attr('data-date'));
			$('.title').val($('#'+$('#id').val()+'-title').html());
			// activate the modal
			$('#timeslot-delete-modal').modal({keyboard: false});	
		})


		// time slot modal form input handlers
		$('#saw-form input').keypress(function (e) {
		   if (e.which == 13) {
		      save();
		   }
		});
		$('#timeslot-modal .btn.green').click(function(e){
			e.preventDefault();
			save();
		});
		$('#timeslot-modal .cancel').click(function(e){
			$('#timeslot-modal').modal('hide');	
		});
		// delete modal handlers
		$('#timeslot-delete-modal .btn.green').click(function(e){
			e.preventDefault();
			remove();
		});
		$('#timeslot-delete-modal .cancel').click(function(e){
			$('#timeslot-modal').modal('hide');	
		});
		
	};
	
}( io.saw.Agenda = io.saw.Agenda || {}, io.saw.jQuery || jQuery ));
</script>