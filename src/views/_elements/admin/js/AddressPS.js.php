<script type="text/javascript">
(function( AddressPS, $, undefined ) {
	function bindAddressPSFieldsBlur(){
		$('#ps-state').keyup(function(e){
			onBlur();
		});
		$('#ps-country').keyup(function(e){
			onBlur();
		});
		
	};
	function onBlur(){

		formatted_addr= ''+$('#ps-state').val();
		formatted_addr+= ', '+$('#ps-country').val();

		$('#ps-geocodeaddress').val(formatted_addr);
	}
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
	function geocode(address){
		var rows = '';
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if(results.length == 1){
					rows = processAddressPS(results[0].address_components
									,results[0].geometry.location.lat()
									,results[0].geometry.location.lng()
									,results[0].formatted_address);
				}else{
					$.each(results, function(key, value) { 
						rows += processAddressPS(value.address_components
									,value.geometry.location.lat()
									,value.geometry.location.lng()
									,value.formatted_address);	
					});
				}
			} else {
				rows = processAddressPS([],0,0,$('#ps-geocodeaddress').val());
				//TODO: show the fields anyway .. just won't have lat and lon.  I'll have to add a reminder in the dashboard for them to 
				// redo their address.
			}

			// apend the table row
			$('#ps-address_modal tbody').append(rows);
			
			// the click handler for the record on the modal to be chosen as the address
			$('#ps-address_modal tbody td a').click(function(e){
				e.preventDefault();
				$('#ps-state').val($(this).attr('data-state'));
				$('#ps-country').val($(this).attr('data-country'));
				$('#ps-zip').val($(this).attr('data-zip'));
				$('#ps-lat').val($(this).attr('data-lat'));
				$('#ps-lon').val($(this).attr('data-lon'));
				$('#ps-geocodeaddress').val($(this).attr('data-formattedaddress'));
				
				// set some visuals that it's done
				$('.validateAddressPS .control-group').addClass('success');
				$('.validateAddressPS .geocodeaddress').addClass('green').removeClass('blue');
				$('.validateAddressPS .geocodeaddress').html('Done. <i class="icon-check"></i> (click to try again)');

				// close modal
				$('#ps-address_modal').modal('hide');
				
			});
		});
	
	}
	function processAddressPS(addr, lat, lon, formatted_address){
		// clear the modal table from unnecessary rows
		$('#ps-address_modal tbody').html('');

		var tr_row; // the address record for display on the modal
		var state='';
		var country='';
		//address components
		$.each(addr, function(key, value) { 
			if(value.types[0] == 'administrative_area_level_1'){
				state = value.short_name;
			}
			if(value.types[0] == 'country'){
				country = value.short_name;
			}

		})
		if(lat == 0 && lon == 0){
			// preapre the table row
			tr_row = '<tr>'+
			'<td class="highlight">'+
			'We could not validate this address.  Please click "CANCEL" below, enter the address manually and try again.'+
			'</td>'+
			'<td><a class="btn mini purple" '+
			'data-state="'+state+'"'+
			'data-country="'+country+'"'+
			'data-lat="'+lat+'"'+
			'data-lon="'+lon+'"'+
			'data-formattedaddress="'+formatted_address+'"'+
			'>SELECT</a></td>'+
			'</tr>';	
		}else{
			// preapre the table row
			tr_row = '<tr>'+
			'<td class="highlight">'+
			formatted_address+
			'</td>'+
			'<td><a class="btn mini purple" '+
			'data-state="'+state+'"'+
			'data-country="'+country+'"'+
			'data-lat="'+lat+'"'+
			'data-lon="'+lon+'"'+
			'data-formattedaddress="'+formatted_address+'"'+
			'>SELECT</a></td>'+
			'</tr>';	
		}
	    return tr_row;

	}
	AddressPS.init = function(formId){
		$('#ps-geocodeaddress').keypress(function (e) {
		   if (e.which == 13) {
		   	// show modal
			$('#ps-address_modal').modal({keyboard: false});
			window.setTimeout(function(){geocode($('#ps-geocodeaddress').val());},1000)
		   	  
		   }
		});
		$(formId+' .btn.geocodeaddress').click(function(e){
			e.preventDefault();
			// show modal
			$('#ps-address_modal').modal({keyboard: false});
			window.setTimeout(function(){geocode($('#ps-geocodeaddress').val());},1000)
		});
		// modal cancel button
		$('#ps-address_modal .address-cancel').click(function(e){
			e.preventDefault();
			$('#ps-address_modal').modal('hide');
		});

		bindAddressPSFieldsBlur();
	};
	
}( io.saw.AddressPS = io.saw.AddressPS || {}, io.saw.jQuery || jQuery ));
</script>