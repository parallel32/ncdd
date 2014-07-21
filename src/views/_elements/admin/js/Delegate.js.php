<? 
$user = $this->app['session']->get('user');
$accessLevel = $user['accessLevel'];
?>
<script type="text/javascript">
(function( Delegate, $, undefined ) {

	Delegate.init = function(){
		
		// SAVE buttons and publish workflow buttons
		$('#saw-form .btn.save').click(function(e){
			Delegate.save();
		});
		<? 	 
		if($accessLevel == ADMIN): ?>
			$('#saw-form .btn.publish').click(function(e){
				Delegate.savePublish();
			});
			$('#saw-form .btn.unpublish').click(function(e){
				Delegate.saveUnPublish();
			});			
		<? endif; ?>

		// Modal Button handlers:
		$('#saw-form .btn.cancel-edit').click(function(e){
			<? if($accessLevel == MEMBER): ?>
				document.location.href='/';
			<? elseif($accessLevel == ADMIN): ?>
				document.location.href='/delegate';
			<? endif; ?>
		});
		$('#save-modal .btn.continue.edit').click(function(e){
			$('#save-modal').modal('hide');
		});		
		$('#save-modal .btn.dashboard').click(function(e){
			<? if($accessLevel == MEMBER): ?>
				document.location.href='/';
			<? elseif($accessLevel == ADMIN): ?>
				document.location.href='/delegate';
			<? endif; ?>
		});	
		$('#saw-form .btn.manage-picture').click(function(e){
			io.saw.Delegate.parentAttr = $(this).attr('id');
			Delegate.save(function(responseObj){
				document.location.href='/delegate/edit/'+responseObj.delegateId+'/edit-photo/'+io.saw.Delegate.parentAttr;	
			});
			
		});

		<? if($accessLevel == ADMIN): ?>
		////////////
		// MEMBER //
		////////////
		// member grid buttons
		$('#member-grid .add').click(function(e){
			$('#add-member-modal :input').val('');//clear the modal
			$('#add-member-modal').modal({keyboard: false});
			setTimeout(function(){$('#modal-doc-member').focus()}, 1500);
		});
		$('#member-grid .delete').click(function(e){
			var the_this = $(this);
			io.saw.FormGet.activate({postUrl:'/delegate/'+$(this).attr('data-id')+'/member/delete/'+$(this).attr('data-member-id')
				,postOnComplete:function(responseObj,responseStatus){}
				,postOnSuccess:function(responseObj){
					// remove the record from the grid
					$(the_this).parents('tr').remove();
				}
			});
			
		});		
		

		// add member modal buttons		
		$('#add-member-modal .select-member').click(function(e){

			io.saw.FormGet.activate({postUrl:'/delegate/'+$(this).attr('data-id')+'/member/add/'+$(this).attr('data-member-id')
			   ,postOnComplete:function(responseObj,responseStatus){}
			   ,postOnSuccess:function(responseObj){
			   		$('#add-member-modal').modal('hide');   		
			   		$('#member-norecords').remove();
			   		// add the record to the grid.
			   		html = '<tr class="gradeX odd">'+
                    '  <td class=" ">'+responseObj.displayName+'</td>'+
                    '  <td class=" ">'+responseObj.email+'</td>'+
                    '  <td class=" "><a data-id="'+responseObj.id+'" class="btn red mini delete"></i> Remove</a></td>'+
                   	'</tr>';
                   	$('#member-grid tbody').append(html);

                   	// rebind click event to the records....
                   	$('#member-grid .delete').click(function(e){
						var the_this = $(this);
						io.saw.FormGet.activate({postUrl:'/delegate/'+$(this).attr('data-id')+'/member/delete/'+$(this).attr('data-member-id')
							,postOnComplete:function(responseObj,responseStatus){}
							,postOnSuccess:function(responseObj){
								// remove the record from the grid
								$(the_this).parents('tr').remove();
							}
						});
						
					});	
			   }
			});
		});		
		$('#add-member-modal .cancel').click(function(e){
			$('#add-member-modal').modal('hide');
		});	
		<? endif; ?>
		///////////
		// EVENT //
		///////////
		// event grid buttons
		$('#event-grid .add').click(function(e){
			$('#add-event-modal .name').val('');//clear the modal
			$('#add-event-modal .sponsor').val('');//clear the modal
			$('#add-event-modal .cosponsor').val('');//clear the modal
			$('#add-event-modal .date').val('');//clear the modal
			$('#add-event-modal').modal({keyboard: false});
		});
		$('#event-grid .delete').click(function(e){
			var the_this = $(this);
			io.saw.FormGet.activate({postUrl:'/delegate/'+$(this).attr('data-id')+'/event/delete/'+$(this).attr('data-event-id')
				,postOnComplete:function(responseObj,responseStatus){}
				,postOnSuccess:function(responseObj){
					// remove the record from the grid
					$(the_this).parents('tr').remove();
				}
			});
			
		});		
		

		// add event modal buttons		
		$('#add-event-modal .save-event').click(function(e){
			io.saw.FormPost.activate({postUrl:'/delegate/'+$(this).attr('data-id')+'/event/add'
			   ,serializeSelector:':input'
			   ,formName:'#event-form'
			   ,postOnComplete:function(responseObj,responseStatus){}
			   ,postOnSuccess:function(responseObj){
			   		$('#add-event-modal').modal('hide');   		
			   		$('#event-norecords').remove();
			   		// add the record to the grid.
			   		html = '<tr class="gradeX odd">'+
                    '  <td class=" ">'+responseObj.name+'</td>'+
                    '  <td class=" ">'+responseObj.date+'</td>'+
                    '  <td class=" "><a data-id="'+responseObj.delegateid+'" data-event-id="'+responseObj.id+'" class="btn red mini delete"></i> Delete</a></td>'+
                   	'</tr>';
                   	$('#event-grid tbody').append(html);

                   	// rebind click event to the records....
                   	$('#event-grid .delete').click(function(e){
						var the_this = $(this);
						io.saw.FormGet.activate({postUrl:'/delegate/'+$(this).attr('data-id')+'/event/delete/'+$(this).attr('data-event-id')
							,postOnComplete:function(responseObj,responseStatus){}
							,postOnSuccess:function(responseObj){
								// remove the record from the grid
								$(the_this).parents('tr').remove();
							}
						});
						
					});	
			   }
			});
		});		
		$('#add-event-modal .cancel').click(function(e){
			$('#add-event-modal').modal('hide');
		});	






	};
	<?
		if($accessLevel == ADMIN): ?>
			Delegate.savePublish = function (){
				$('#currentStatus').val(<?=\Saw\Model\Delegate::$status['PUBLISH'];?>);
				Delegate.save();
			};
			Delegate.saveUnPublish = function (){
				$('#currentStatus').val(<?=\Saw\Model\Delegate::$status['DRAFT'];?>);
				Delegate.save();
			};
	<? endif; ?>
	Delegate.save = function (postSuccess,posturl,blockuiformpost){
		<?/**
        TODO
     */?>
		tinymce.activeEditor.save();
		$('#input-body').val($('#body').html());
		var posturl = posturl || '/delegate/edit'
		var blockuiformpost = blockuiformpost || 'yes'
		var postSuccess = postSuccess || function(responseObj){
			 <?/**
	            TODO
	         */?>
		   		$('#editor-drive-file-iframe').attr('src','/drive/file/'+responseObj.delegateId);
		   		$('#editor-drive-image-iframe').attr('src','/drive/image/'+responseObj.delegateId);
		   		$('#_id').val(responseObj.delegateId);
		   		if(blockuiformpost == 'yes'){
			   		$('#save-modal .modal-body p').html(responseObj.message);
			      	//$('#save-modal-label').html(responseObj.label);
			    	$('#save-modal').modal({keyboard: false});   		
			    }
		   };

		io.saw.FormPost.activate({postUrl:posturl
		   ,serializeSelector:':input'
		   ,blockUI:blockuiformpost
		   ,postOnComplete:function(responseObj,responseStatus){
			   	if(responseStatus == 'success'){
			   	}else{
			   		var responseObj = $.parseJSON(responseObj.responseText);
			   	}
		   }
		   ,postOnSuccess:postSuccess
		});      
	};
	<?/**
		todo
	*/?>
	
}( io.saw.Delegate = io.saw.Delegate || {}, io.saw.jQuery || jQuery ));
</script>