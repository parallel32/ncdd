<script type="text/javascript">
(function( FormDatePicker, $, undefined ) {
	
	FormDatePicker.init = function(mode){
		
		if(mode == 'range'){
			$( ".startDate" ).datepicker({
		      defaultDate: "+1w",
		      changeMonth: true,
		      numberOfMonths: 2,
		      onClose: function( selectedDate ) {
		        $( ".endDate" ).datepicker( "option", "minDate", selectedDate );
		      }
		    });
		    $( ".endDate" ).datepicker({
		      defaultDate: "+1w",
		      changeMonth: true,
		      numberOfMonths: 2,
		      onClose: function( selectedDate ) {
		        $( ".startDate" ).datepicker( "option", "maxDate", selectedDate );
		      }
		    });	
		}		
		

		/* // other options 
		$("#ui_date_picker").datepicker();

        $("#ui_date_picker_with_button_bar").datepicker({
          showButtonPanel: true
        });

        $("#ui_date_picker_inline").datepicker();

        $("#ui_date_picker_change_year_month" ).datepicker({
	      changeMonth: true,
	      changeYear: true
	    });

	    $("#ui_date_picker_multiple").datepicker({
	    	numberOfMonths: 2,
      		showButtonPanel: true
	    });

	    $("#ui_date_picker_week_year" ).datepicker({
	      showWeek: true,
	      firstDay: 1
	    });

	    $("#ui_date_picker_trigger input").datepicker();
	    $("#ui_date_picker_trigger .add-on").click(function(){
	    	$("#ui_date_picker_trigger input").datepicker("show");
	    });
		//*/
	};
	
	
}( io.saw.FormDatePicker = io.saw.FormDatePicker || {}, io.saw.jQuery || jQuery ));
</script>