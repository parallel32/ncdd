<script type="text/javascript">
(function( ClearField, $, undefined ) {
	// init variables
	var params = {};
	var arrayOfClasses = [];
	var fieldName = '';	
	window.keydownVal = '';
	window.keyupVal = '';

	ClearField.init = function(p){
		params = p; 
		params.formArr = params.formArr || [];
		$.each(params.formArr, function(idx,formSelector){

			// bind the event to check the length of the fields
			$(formSelector+' input[type="text"]').keydown(function(){
				var arrayOfClasses = $(this).attr('class').split(' ');
			    var fieldName = arrayOfClasses[arrayOfClasses.length-1];
			    window.keydownVal = $(formSelector+' .'+fieldName).val();
			    
			});
			$(formSelector+' input[type="text"]').keyup(function(){
				var arrayOfClasses = $(this).attr('class').split(' ');
			    var fieldName = arrayOfClasses[arrayOfClasses.length-1];
			    window.keyupVal = $(this).val();
			    if(window.keydownVal.length > 0 && window.keyupVal.length == 0){
			    	var hiddenField = '<input id="clearField-'+fieldName+'" type="hidden" name="doc[clearFields]['+fieldName+']" value="">';
			    	$(this).closest('form').append(hiddenField);
			    	
			    }
			    if(window.keydownVal.length > 0 && window.keyupVal.length > 0){
			    	$('#clearField-'+fieldName).remove();
			    }
			})
		});

		$('textarea').keydown(function(){
			var arrayOfClasses = $(this).attr('class').split(' ');
		    var fieldName = arrayOfClasses[arrayOfClasses.length-1];
		    window.keydownVal = $('.'+fieldName).val();
		    
		});
		$('textarea').keyup(function(){
			var arrayOfClasses = $(this).attr('class').split(' ');
		    var fieldName = arrayOfClasses[arrayOfClasses.length-1];
		    window.keyupVal = $(this).val();
		    if(window.keydownVal.length > 0 && window.keyupVal.length == 0){
		    	var hiddenField = '<input id="clearField-'+fieldName+'" type="hidden" name="doc[clearFields]['+fieldName+']" value="">';
		    	$(this).closest('form').append(hiddenField);
		    	
		    }
		    if(window.keydownVal.length > 0 && window.keyupVal.length > 0){
		    	$('#clearField-'+fieldName).remove();
		    }
		})
			
	};
	
}( io.saw.ClearField = io.saw.ClearField || {}, io.saw.jQuery || jQuery ));
</script>