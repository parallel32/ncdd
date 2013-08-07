<script type="text/javascript">
(function( Member, $, undefined ) {

	Member.init = function(){
		$('.edit-photo').click(function(e){
			document.location.href='/member/'+$(this).attr('data-id')+'/edit-photo';
		});
		$('#saw-form input').keypress(function(e) {
			if (e.which == 13) {
				save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			save();
		});
		$('#saw-form .btn.cancel').click(function(e){
			document.location.href='/';			
		});
		$('#save-modal .btn.continue.edit').click(function(e){
			$('#save-modal').modal('hide');
		});		
		$('#save-modal .btn.continue.dashboard').click(function(e){
			document.location.href='/';
		});	

		//////////////
		// LOCATION //
		//////////////
		// location grid buttons
		$('#location-grid .add').click(function(e){
			$('#add-location-modal :input').val('');//clear the modal
			$('#add-location-modal').modal({keyboard: false});
		});
		$('#location-grid .delete').click(function(e){
			var the_this = $(this);
			io.saw.FormGet.activate({postUrl:'/member/location/'+$(this).attr('data-id')+'/delete'
				,postOnComplete:function(responseObj,responseStatus){}
				,postOnSuccess:function(responseObj){
					// remove the record from the grid
					$(the_this).parents('tr').remove();
				}
			});
			
		});		
		

		// add location modal buttons		
		$('#add-location-modal .save').click(function(e){
			io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-member-id')+'/location/add'
			   ,serializeSelector:':input'
			   ,formName:'#location-form'
			   ,postOnComplete:function(responseObj,responseStatus){}
			   ,postOnSuccess:function(responseObj){
			   		$('#add-location-modal').modal('hide');   		
			   		$('#location-norecords').remove();
			   		// add the record to the grid.
			   		html = '<tr class="gradeX odd">'+
                    '  <td class=" ">'+$('#geocodeaddress').val()+'</td>'+
                    '  <td class=" "><a data-id="'+responseObj.id.$id+'" class="btn red mini delete"></i> Delete</a></td>'+
                   	'</tr>';
                   	$('#location-grid tbody').append(html);

                   	// rebind click event to the records....
                   	$('#location-grid .delete').click(function(e){
                   		var the_this = $(this);
						io.saw.FormGet.activate({postUrl:'/member/location/'+$(this).attr('data-id')+'/delete'
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
		$('#add-location-modal .cancel').click(function(e){
			$('#add-location-modal').modal('hide');
		});		
		

		/////////////
		// WEBSITE //
		/////////////
		// website grid buttons
		$('#website-grid .add').click(function(e){
			$('#add-website-modal :input').val('');//clear the modal
			$('#add-website-modal').modal({keyboard: false});
		});
		$('#website-grid .delete').click(function(e){
			var the_this = $(this);
			io.saw.FormGet.activate({postUrl:'/member/'+$(this).attr('data-id')+'/website/'+$(this).attr('data-name')+'/delete'
				,postOnComplete:function(responseObj,responseStatus){}
				,postOnSuccess:function(responseObj){
					// remove the record from the grid
					$(the_this).parents('tr').remove();
				}
			});
			
		});		
		

		// add website modal buttons		
		$('#add-website-modal .save').click(function(e){
			io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-member-id')+'/website/add'
			   ,serializeSelector:':input'
			   ,formName:'#website-form'
			   ,postOnComplete:function(responseObj,responseStatus){}
			   ,postOnSuccess:function(responseObj){
			   		$('#add-website-modal').modal('hide');   		
			   		$('#website-norecords').remove();
			   		// add the record to the grid.
			   		html = '<tr class="gradeX odd">'+
                    '  <td class=" ">'+$('#add-website-modal .website').val()+'</td>'+
                    '  <td class=" ">'+$('#add-website-modal .websiteDesc').val()+'</td>'+
                    '  <td class=" "><a data-name="'+responseObj.name+'" data-id="'+responseObj.id+'" class="btn red mini delete"></i> Delete</a></td>'+
                   	'</tr>';
                   	$('#website-grid tbody').append(html);

                   	// rebind click event to the records....
                   	$('#website-grid .delete').click(function(e){
						var the_this = $(this);
						io.saw.FormGet.activate({postUrl:'/member/'+$(this).attr('data-id')+'/website/'+$(this).attr('data-name')+'/delete'
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
		$('#add-website-modal .cancel').click(function(e){
			$('#add-website-modal').modal('hide');
		});	

		//////////////
		// LANGUAGE //
		//////////////
		// language grid buttons
		$('#language-grid .add').click(function(e){
			$('#add-language-modal :input').val('');//clear the modal
			$('#add-language-modal').modal({keyboard: false});
		});
		$('#language-grid .delete').click(function(e){
			var the_this = $(this);
			io.saw.FormGet.activate({postUrl:'/member/'+$(this).attr('data-id')+'/language/'+$(this).attr('data-name')+'/delete'
				,postOnComplete:function(responseObj,responseStatus){}
				,postOnSuccess:function(responseObj){
					// remove the record from the grid
					$(the_this).parents('tr').remove();
				}
			});
			
		});		
		

		// add language modal buttons		
		$('#add-language-modal .save').click(function(e){
			io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-member-id')+'/language/add'
			   ,serializeSelector:':input'
			   ,formName:'#language-form'
			   ,postOnComplete:function(responseObj,responseStatus){}
			   ,postOnSuccess:function(responseObj){
			   		$('#add-language-modal').modal('hide');   		
			   		$('#language-norecords').remove();
			   		// add the record to the grid.
			   		html = '<tr class="gradeX odd">'+
                    '  <td class=" ">'+$('#add-language-modal .language').val()+'</td>'+
                    '  <td class=" "><a data-name="'+responseObj.name+'" data-id="'+responseObj.id+'" class="btn red mini delete"></i> Delete</a></td>'+
                   	'</tr>';
                   	$('#language-grid tbody').append(html);

                   	// rebind click event to the records....
                   	$('#language-grid .delete').click(function(e){
						var the_this = $(this);
						io.saw.FormGet.activate({postUrl:'/member/'+$(this).attr('data-id')+'/language/'+$(this).attr('data-name')+'/delete'
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
		$('#add-language-modal .cancel').click(function(e){
			$('#add-language-modal').modal('hide');
		});	

		///////////////////
		// PRACTICE AREA //
		///////////////////
		// pa grid buttons
		$('#pa-grid .add').click(function(e){
			$('#add-pa-modal :input').val('');//clear the modal
			$('#add-pa-modal').modal({keyboard: false});
		});
		$('#pa-grid .delete').click(function(e){
			var the_this = $(this);
			io.saw.FormGet.activate({postUrl:'/member/'+$(this).attr('data-id')+'/pa/'+$(this).attr('data-name')+'/delete'
				,postOnComplete:function(responseObj,responseStatus){}
				,postOnSuccess:function(responseObj){
					// remove the record from the grid
					$(the_this).parents('tr').remove();
				}
			});
			
		});		
		

		// add pa modal buttons		
		$('#add-pa-modal .save').click(function(e){
			io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-member-id')+'/pa/add'
			   ,serializeSelector:':input'
			   ,formName:'#pa-form'
			   ,postOnComplete:function(responseObj,responseStatus){}
			   ,postOnSuccess:function(responseObj){
			   		$('#add-pa-modal').modal('hide');   		
			   		$('#pa-norecords').remove();
			   		// add the record to the grid.
			   		html = '<tr class="gradeX odd">'+
                    '  <td class=" ">'+$('#add-pa-modal .pa').val()+'</td>'+
                    '  <td class=" ">'+$('#add-pa-modal .percent').val()+'</td>'+
                    '  <td class=" "><a data-name="'+responseObj.name+'" data-id="'+responseObj.id+'" class="btn red mini delete"></i> Delete</a></td>'+
                   	'</tr>';
                   	$('#pa-grid tbody').append(html);

                   	// rebind click event to the records....
                   	$('#pa-grid .delete').click(function(e){
						var the_this = $(this);
						io.saw.FormGet.activate({postUrl:'/member/'+$(this).attr('data-id')+'/pa/'+$(this).attr('data-name')+'/delete'
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
		$('#add-pa-modal .cancel').click(function(e){
			$('#add-pa-modal').modal('hide');
		});
		
		<? if($accessLevel == ADMIN): ?>
		////////////
		// DELETE //
		////////////

		// activate delete modal
		$('#verify-delete').click(function(e){
			$('#delete-modal').modal({keyboard: false});
		});

		// initiate delete
		$('#delete-modal .continue.delete').click(function(e){
			removeMember();
		});
		// cancel delete
		$('#delete-modal .cancel').click(function(e){
			$('#delete-modal').modal('hide');
		});
		<? endif; ?>

	};
	<? if($accessLevel == ADMIN): ?>
	function removeMember(){
		io.saw.FormPost.activate({postUrl:'/utilities/member/delete'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){
		   }
		   ,postOnSuccess:function(responseObj){
		   		$('#delete-modal').modal('hide');
		   		$('#save-modal .modal-body p').html(responseObj.message);
		   		$('#save-modal .continue.edit').hide();
		      	//$('#save-modal-label').html(responseObj.label);
		      	$('#save-modal').modal({keyboard: false});   		
		   }
		});      
	}
	<? endif; ?>
	function save (){
		io.saw.FormPost.activate({postUrl:'/member/edit'
		   ,serializeSelector:':input'
		   ,postOnComplete:function(responseObj,responseStatus){
			   	if(responseStatus == 'success'){
			   	}else{
			   		var responseObj = $.parseJSON(responseObj.responseText);
			   	}
		   }
		   ,postOnSuccess:function(responseObj){
		   		$('#save-modal .modal-body p').html(responseObj.message);
		      	//$('#save-modal-label').html(responseObj.label);
		      	$('#save-modal').modal({keyboard: false});   		
		   }
		});      
	};
	
}( io.saw.Member = io.saw.Member || {}, io.saw.jQuery || jQuery ));
</script>