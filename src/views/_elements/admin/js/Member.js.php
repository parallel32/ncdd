<script type="text/javascript">
(function( Member, $, undefined ) {

	Member.init = function(){
		$('.edit-photo').click(function(e){
			document.location.href='/member/'+$(this).attr('data-id')+'/edit-photo';
		});
		$('#saw-form input').keypress(function(e) {
			if (e.which == 13) {
				Member.save();
			}
		});
		$('#saw-form .btn.save').click(function(e){
			Member.save();
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

















		////////////////////
		// PRACTICE STATE //
		////////////////////
		// practicestate grid buttons
		$('#practicestate-grid .add').click(function(e){
			$('#add-practicestate-modal :input').val('');//clear the modal
			$('#add-practicestate-modal').modal({keyboard: false});
		});
		$('#practicestate-grid .delete').click(function(e){
			var the_this = $(this);
			io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-id')+'/practicestate/delete'
				,serialized:'state='+$(this).attr('data-name')
				,postOnComplete:function(responseObj,responseStatus){}
				,postOnSuccess:function(responseObj){
					// remove the record from the grid
					$(the_this).parents('tr').remove();
				}
			});
			
		});		
		$('#practicestate-grid .edit').click(function(e){
			var the_this = $(this);
			$('#add-practicestate-modal-label').html('Save Location');
			// clear the modal first
			$('#add-practicestate-modal :input').val('');
			// set fields
			$('#ps-_id').val($(this).attr('data-id'));
			$('#ps-state').val($(this).attr('data-state'));
			$('#ps-country').val($(this).attr('data-country'));
			$('#ps-raw').val($(this).attr('data-raw'));
			$('#ps-geocodeaddress').val($(this).attr('data-raw'));
			$('#ps-mode').val($(this).attr('data-mode'));

			$('#add-practicestate-modal').modal({keyboard: false});
		});		
		

		// add practicestate modal buttons		
		$('#add-practicestate-modal .save').click(function(e){
			var full_address = $('#ps-state').val()+', '+$('#ps-country').val();
			$('#ps-raw').val(full_address);
			
			if($('#ps-mode').val() == 'save'){
				io.saw.FormPost.activate({postUrl:'/practicestate/'+$('#ps-_id').val()+'/edit'
				   ,serializeSelector:':input'
				   ,formName:'#practicestate-form'
				   ,postOnComplete:function(responseObj,responseStatus){}
				   ,postOnSuccess:function(responseObj){
				   		$('#'+$('#ps-_id').val()).html($('#ps-raw').val());
				   		$('#add-practicestate-modal').modal('hide');   		
				   		$('#practicestate-norecords').remove();

				   		// reset the data attributes with the current values from the form
				   		$('#edit-'+$('#ps-_id').val()).attr('data-state',$('#ps-state').val());
				   		$('#edit-'+$('#ps-_id').val()).attr('data-country',$('#ps-country').val());
				   		$('#edit-'+$('#ps-_id').val()).attr('data-raw',$('#ps-raw').val());
				   		$('#edit-'+$('#ps-_id').val()).attr('data-mode',$('#ps-mode').val());
				   }
				});
			}else{ //add
				io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-member-id')+'/practicestate/add'
				   ,serializeSelector:':input'
				   ,formName:'#practicestate-form'
				   ,postOnComplete:function(responseObj,responseStatus){}
				   ,postOnSuccess:function(responseObj){
				   		$('#add-practicestate-modal').modal('hide');   		
				   		$('#practicestate-norecords').remove();
				   		// add the record to the grid.
				   		html = '<tr class="gradeX odd">'+
	                    '  <td id="'+responseObj.id.$id+'" class=" ">'+full_address+ '</td>'+
	                    '  <td class=" ">'+
	                    ' <a data-id="'+responseObj.id.$id+'" class="btn red mini delete"></i> Delete</a></td>'+
	                   	'</tr>';
	                   	$('#practicestate-grid tbody').append(html);

	                   	// rebind click event to the records....
	                   	$('#practicestate-grid .delete').click(function(e){
	                   		var the_this = $(this);
							io.saw.FormGet.activate({postUrl:'/member/'+$(this).attr('data-id')+'/practicestate/delete'
								,postOnComplete:function(responseObj,responseStatus){}
								,postOnSuccess:function(responseObj){
									// remove the record from the grid
									$(the_this).parents('tr').remove();
								}
							});
							
						});	
						$('#practicestate-grid .edit').click(function(e){
							var the_this = $(this);
							$('#add-practicestate-modal-label').html('Save Location');
							// clear the modal first
							$('#add-practicestate-modal :input').val('');
							// set fields
							$('#ps-_id').val($(this).attr('data-id'));
							$('#ps-state').val($(this).attr('data-state'));
							$('#ps-country').val($(this).attr('data-country'));
							$('#ps-raw').val($(this).attr('data-raw'));
							$('#ps-geocodeaddress').val($(this).attr('data-raw'));
							$('#ps-mode').val($(this).attr('data-mode'));

							$('#add-practicestate-modal').modal({keyboard: false});
						});		
				   }
				});
			}
			
		});		
		$('#add-practicestate-modal .cancel').click(function(e){
			$('#add-practicestate-modal').modal('hide');
		});		
		
		// auto fill the geocde address field
		$('#ps-geocodeaddress').focus(function(e){
			$('#ps-geocodeaddress').val($('#ps-state').val()+', '+$('#ps-country').val());
		});
		$('#ps-state').blur(function(e){
			$('#ps-geocodeaddress').val($('#ps-state').val()+', '+$('#ps-country').val());
		});
		$('#ps-country').blur(function(e){
			$('#ps-geocodeaddress').val($('#ps-state').val()+', '+$('#ps-country').val());
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
		$('#location-grid .setprimary').click(function(e){
			var the_this = $(this);
			io.saw.FormGet.activate({postUrl:'/member/location/'+$(this).attr('data-id')+'/primary'
				,postOnComplete:function(responseObj,responseStatus){}
				,postOnSuccess:function(responseObj){
					// remove the record from the grid
					$(the_this).parents('tbody').find('.primarycell').html('');	
					$(the_this).parents('tr').find('.primarycell').html('<i class="icon-check"></i>');
				}
			});
			
		});		
		$('#location-grid .edit').click(function(e){
			var the_this = $(this);
			$('#add-location-modal-label').html('Save Location');
			// clear the modal first
			$('#add-location-modal :input').val('');
			// set fields
			$('#_id').val($(this).attr('data-id'));
			$('#location-name').val($(this).attr('data-name'));
			$('#location-hours').val($(this).attr('data-hours'));
			$('#location-phone').val($(this).attr('data-phone'));
			$('#location-fax').val($(this).attr('data-fax'));
			$('#location-tollFree').val($(this).attr('data-tollFree'));
			$('#address1').val($(this).attr('data-addressLineOne'));
			$('#address2').val($(this).attr('data-addressLineTwo'));
			$('#city').val($(this).attr('data-city'));
			$('#state').val($(this).attr('data-state'));
			$('#zip').val($(this).attr('data-zip'));
			$('#country').val($(this).attr('data-country'));
			$('#raw').val($(this).attr('data-raw'));
			$('#geocodeaddress').val($(this).attr('data-raw'));
			$('#mode').val($(this).attr('data-mode'));

			$('#add-location-modal').modal({keyboard: false});
		});		
		

		// add location modal buttons		
		$('#add-location-modal .save').click(function(e){
			var full_address = $('#location-name').val()+' '+$('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val();
			$('#raw').val(full_address);
			
			if($('#mode').val() == 'save'){
				io.saw.FormPost.activate({postUrl:'/location/'+$('#_id').val()+'/edit'
				   ,serializeSelector:':input'
				   ,formName:'#location-form'
				   ,postOnComplete:function(responseObj,responseStatus){}
				   ,postOnSuccess:function(responseObj){
				   		$('#'+$('#_id').val()).html($('#raw').val());
				   		$('#add-location-modal').modal('hide');   		
				   		$('#location-norecords').remove();

				   		// reset the data attributes with the current values from the form
				   		$('#edit-'+$('#_id').val()).attr('data-name',$('#location-name').val());
				   		$('#edit-'+$('#_id').val()).attr('data-hours',$('#location-hours').val());
				   		$('#edit-'+$('#_id').val()).attr('data-phone',$('#location-phone').val());
				   		$('#edit-'+$('#_id').val()).attr('data-fax',$('#location-fax').val());
				   		$('#edit-'+$('#_id').val()).attr('data-tollFree',$('#location-tollFree').val());
				   		$('#edit-'+$('#_id').val()).attr('data-addressLineOne',$('#address1').val());
				   		$('#edit-'+$('#_id').val()).attr('data-addressLineTwo',$('#address2').val());
				   		$('#edit-'+$('#_id').val()).attr('data-city',$('#city').val());
				   		$('#edit-'+$('#_id').val()).attr('data-state',$('#state').val());
				   		$('#edit-'+$('#_id').val()).attr('data-zip',$('#zip').val());
				   		$('#edit-'+$('#_id').val()).attr('data-country',$('#country').val());
				   		$('#edit-'+$('#_id').val()).attr('data-raw',$('#raw').val());
				   		$('#edit-'+$('#_id').val()).attr('data-mode',$('#mode').val());
				   }
				});
			}else{ //add
				io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-member-id')+'/location/add'
				   ,serializeSelector:':input'
				   ,formName:'#location-form'
				   ,postOnComplete:function(responseObj,responseStatus){}
				   ,postOnSuccess:function(responseObj){
				   		$('#add-location-modal').modal('hide');   		
				   		$('#location-norecords').remove();
				   		// add the record to the grid.
				   		html = '<tr class="gradeX odd">'+
	                    '  <td id="'+responseObj.id.$id+'" class=" ">'+full_address+ '</td>'+
	                    '  <td id="'+responseObj.id.$id+'" class=" primarycell"></td>'+
	                    '  <td class=" ">'+
	                    '<a data-id="'+responseObj.id.$id+'" class="btn yellow mini setprimary"></i> Set as Primary</a>'+
	                    '<a id="edit-'+responseObj.id.$id+'" '+
	                    ' data-id="'+responseObj.id.$id+'" '+
	                    ' data-name="'+$('#location-name').val()+'" '+
	                    ' data-hours="'+$('#location-hours').val()+'" '+
	                    ' data-phone="'+$('#location-phone').val()+'" '+
	                    ' data-fax="'+$('#location-fax').val()+'" '+
	                    ' data-tollFree="'+$('#location-tollFree').val()+'" '+
	                    ' data-addressLineOne="'+$('#address1').val()+'" '+
	                    ' data-addressLineTwo="'+$('#address2').val()+'" '+
	                    ' data-city="'+$('#city').val()+'" '+
	                    ' data-state="'+$('#state').val()+'" '+
	                    ' data-zip="'+$('#zip').val()+'" '+
	                    ' data-country="'+$('#country').val()+'" '+
	                    ' data-raw="'+$('#raw').val()+'" '+
	                    ' data-mode="save" '+

	                    'class="btn blue mini edit"></i> Edit</a> '+
	                    ' <a data-id="'+responseObj.id.$id+'" class="btn red mini delete"></i> Delete</a></td>'+
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
						$('#location-grid .setprimary').click(function(e){
							var the_this = $(this);
							io.saw.FormGet.activate({postUrl:'/member/location/'+$(this).attr('data-id')+'/primary'
								,postOnComplete:function(responseObj,responseStatus){}
								,postOnSuccess:function(responseObj){
									// remove the record from the grid
									$(the_this).parents('tbody').find('.primarycell').html('');	
									$(the_this).parents('tr').find('.primarycell').html('<i class="icon-check"></i>');
								}
							});
							
						});
						$('#location-grid .edit').click(function(e){
							var the_this = $(this);
							$('#add-location-modal-label').html('Save Location');
							// clear the modal first
							$('#add-location-modal :input').val('');
							// set fields
							$('#_id').val($(this).attr('data-id'));
							$('#location-name').val($(this).attr('data-name'));
							$('#location-hours').val($(this).attr('data-hours'));
							$('#location-phone').val($(this).attr('data-phone'));
							$('#location-fax').val($(this).attr('data-fax'));
							$('#location-tollFree').val($(this).attr('data-tollFree'));
							$('#address1').val($(this).attr('data-addressLineOne'));
							$('#address2').val($(this).attr('data-addressLineTwo'));
							$('#city').val($(this).attr('data-city'));
							$('#state').val($(this).attr('data-state'));
							$('#zip').val($(this).attr('data-zip'));
							$('#country').val($(this).attr('data-country'));
							$('#raw').val($(this).attr('data-raw'));
							$('#geocodeaddress').val($(this).attr('data-raw'));
							$('#mode').val($(this).attr('data-mode'));

							$('#add-location-modal').modal({keyboard: false});
						});		
				   }
				});
			}
			
		});		
		$('#add-location-modal .cancel').click(function(e){
			$('#add-location-modal').modal('hide');
		});		
		
		// auto fill the geocde address field
		$('#geocodeaddress').focus(function(e){
			$('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
		});
		$('#address1').blur(function(e){
			$('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
		});
		$('#address2').blur(function(e){
			$('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
		});
		$('#city').blur(function(e){
			$('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
		});
		$('#state').blur(function(e){
			$('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
		});
		$('#zip').blur(function(e){
			$('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
		});
		$('#country').blur(function(e){
			$('#geocodeaddress').val($('#address1').val()+' '+$('#address2').val()+' '+$('#city').val()+', '+$('#state').val()+' '+$('#zip').val()+', '+$('#country').val());
		});
		

		/////////////
		// WEBSITE //
		/////////////
		// website grid buttons
		$('#website-grid .add').click(function(e){
			$('#add-website-modal :input').val('');//clear the modal
			$('#add-website-modal').modal({keyboard: false});
			setTimeout(function(){$('#modal-doc-website').focus()}, 1500);
		});
		$('#website-grid .delete').click(function(e){
			var the_this = $(this);
			io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-id')+'/website/delete'
				,serialized:'website='+$(this).attr('data-name')
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
						io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-id')+'/website/delete'
							,serialized:'website='+$(this).attr('data-name')
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
			io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-id')+'/pa/delete'
				,serialized:'pa='+$(this).attr('data-name')
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
                    '  <td class=" ">'+responseObj.pa['pa']+'</td>'+
                    '  <td class=" ">'+responseObj.pa['percent']+'</td>'+
                    '  <td class=" "><a data-name="'+responseObj.pa['pa']+'" data-id="'+responseObj.id+'" class="btn red mini delete"></i> Delete</a></td>'+
                   	'</tr>';
                   	$('#pa-grid tbody').append(html);

                   	// rebind click event to the records....
                   	$('#pa-grid .delete').click(function(e){
						var the_this = $(this);
						io.saw.FormPost.activate({postUrl:'/member/'+$(this).attr('data-id')+'/pa/delete'
							,serialized:'pa='+$(this).attr('data-name')
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
	Member.save = function (){
		tinymce.activeEditor.save();
		$('#input-body').val(tinymce.activeEditor.getContent());
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