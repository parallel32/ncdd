<script type="text/javascript">
(function( undefined ) {
	var namespace = function(name, separator, container){
	  var ns = name.split(separator || '.'),
	    o = container || window,
	    i,
	    len;
	  for(i = 0, len = ns.length; i < len; i++){
	    o = o[ns[i]] = o[ns[i]] || {};
	  }
	  return o;
	};
	namespace('io.saw');
	io.saw.jQuery = undefined;
}());
</script>