<script type="text/javascript">
(function( FormElements, $, undefined ) {
	
	FormElements.render = function(key,value){
		if(typeof value === 'object' && key == '_id'){
			value = value.$id
		}
		key = this.fixStr(key)
		var element = '<div class="control-group">'+
				  '<label class="control-label">'+key+'</label>'+
				  '<div class="controls">'+
				  '   <input type="text" name="doc['+key+']" class="span6 m-wrap '+key+'" value="'+value+'">'+
				  '</div>'+
				  '</div>';
		return element;
	};
	
	FormElements.renderReadOnly = function(key,value,fixString){
		if(typeof value === 'object' && key == '_id'){
			value = value.$id
		}
		if(fixString === true){
			key = this.fixStr(key)
		}
		var element = '<div class="control-group">'+
				  '<label class="control-label">'+key+'</label>'+
				  '<div class="controls">'+
				  '   '+value+'  '+
				  '</div>'+
				  '</div>';
		return element;
	};
	
	FormElements.fixStr = function (str) {
	    var out = str.replace(/^\s*/, "");  // strip leading spaces
	    out = out.replace(/^[a-z]|[^\s][A-Z]/g, function(str, offset) {
	        if (offset == 0) {
	            return(str.toUpperCase());
	        } else {
	            return(str.substr(0,1) + " " + str.substr(1).toUpperCase());
	        }
	    });
	    return(out);
	}

	
}( io.saw.FormElements = io.saw.FormElements || {}, io.saw.jQuery || jQuery ));
</script>