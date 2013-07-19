<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDb_erg__9LjU-MMn5wmu-kqlmZbKxCBA&sensor=true"/></script>
<script type="text/javascript">
(function( Address, $, undefined ) {
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
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if(results.length == 1){
					processAddress(results[0].address_components
									,results[0].geometry.location.lat()
									,results[0].geometry.location.lng()
									,results[0].formatted_address);
				}else{
					$.each(results, function(key, value) { 
						processAddress(value.address_components
									,value.geometry.location.lat()
									,value.geometry.location.lng()
									,value.formatted_address);	
					});
				}
			} else {
				processAddress([],0,0,$('#geocodeaddress').val());
				//show the fields anyway .. just won't have lat and lon.  I'll have to add a reminder in the dashboard for them to 
				// redo their address.
			}
		});
		// show modal
		$('#address_modal').modal({keyboard: false});

	}
	function processAddress(addr, lat, lon, formatted_address){
		// clear the modal table from unnecessary rows
		$('#address_modal tbody').html('');

		var tr_row; // the address record for display on the modal
		var address1='';
		var address2='';
		var city='';
		var state='';
		var zip='';
		var country='';
		//address components
		$.each(addr, function(key, value) { 
			if(value.types[0] == 'subpremise'){
				address2 = value.long_name;
			}
			if(value.types[0] == 'street_number'){
				address1 = value.long_name;
			}
			if(value.types[0] == 'route'){
				address1 = address1+' '+value.short_name;
			}
			if(value.types[0] == 'locality'){
				city = value.long_name;
			}
			if(value.types[0] == 'administrative_area_level_1'){
				state = value.long_name;
			}
			if(value.types[0] == 'postal_code'){
				zip = value.short_name;
			}
			if(value.types[0] == 'country'){
				country = value.short_name;
			}

		})
		if(lat == 0 && lon == 0){
			// preapre the table row
			tr_row = '<tr>'+
			'<td class="highlight">'+
			'We could not validate this address.  Please click "SELECT" to the right and enter the address manually.'+
			'</td>'+
			'<td><a class="btn mini purple" '+
			'data-address="'+address1+'"'+
			'data-address2="'+address2+'"'+
			'data-city="'+city+'"'+
			'data-state="'+state+'"'+
			'data-zip="'+zip+'"'+
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
			'data-address="'+address1+'"'+
			'data-address2="'+address2+'"'+
			'data-city="'+city+'"'+
			'data-state="'+state+'"'+
			'data-zip="'+zip+'"'+
			'data-country="'+country+'"'+
			'data-lat="'+lat+'"'+
			'data-lon="'+lon+'"'+
			'data-formattedaddress="'+formatted_address+'"'+
			'>SELECT</a></td>'+
			'</tr>';	
		}
	    
		// apend the table row
		$('#address_modal tbody').append(tr_row);
		
		// the click handler for the record on the modal to be chosen as the address
		$('#address_modal tbody td a').click(function(e){
			e.preventDefault();
			$('#address1').val($(this).attr('data-address'));
			$('#address2').val($(this).attr('data-address2'));
			$('#city').val($(this).attr('data-city'));
			$('#state').val($(this).attr('data-state'));
			$('#zip').val($(this).attr('data-zip'));
			$('#country').val($(this).attr('data-country'));
			$('#lat').val($(this).attr('data-lat'));
			$('#lon').val($(this).attr('data-lon'));
			$('#lon').val($(this).attr('data-lon'));
			$('#geocodeaddress').val($(this).attr('data-formattedaddress'));
			// close modal
			$('#address_modal').modal('hide');
			// show fields
			$('.addr').show();
		});

	}
	Address.init = function(){
		$('#geocodeaddress').keypress(function (e) {
		   if (e.which == 13) {
		   	  geocode($('#geocodeaddress').val());
		   }
		});
		$('#saw-form .btn.geocodeaddress').click(function(e){
			e.preventDefault();
			geocode($('#geocodeaddress').val());
		});
		// modal cancel button
		$('#address_modal .btn.cancel').click(function(e){
			$('#address_modal').modal('hide');
		});
		
	};
	
}( io.saw.Address = io.saw.Address || {}, io.saw.jQuery || jQuery ));
</script>