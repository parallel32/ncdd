<script type="text/javascript">
(function( BlockUI, $, undefined ) {
    
    var params = {}
	
	function init (p){
		params = p; 
	    params.loadingImg = params.loadingImg || '/assets/img/loading.gif';
	    params.opacity = params.opacity || 0.15;
		params.elementToBlock = params.elementToBlock || '.portlet';
		params.onBlock = params.onBlock || function(){};
		params.onUnBlock = params.onUnBlock || function(){};
	}

	BlockUI.block = function(p){
		init(p);
		params.onBlock();
        if(typeof params.elementToBlock == 'string'){
            var element = $(params.elementToBlock);
        }else if(typeof params.elementToBlock =='object'){
            var element = params.elementToBlock;
        }
		element.block({
            message: '<img src="'+params.loadingImg+'" align="absmiddle">',
            css: {
                border: 'none',
                padding: '2px',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: '#000',
                opacity: params.opacity,
                cursor: 'wait'
            }
        });
        return this;
	};
    BlockUI.unblock = function(){
    	params.onUnBlock();
		$(params.elementToBlock).unblock({
            onUnblock: function () {
                if(typeof params.elementToBlock == 'string'){
                    var element = $(params.elementToBlock);
                }else if(typeof params.elementToBlock =='object'){
                    var element = params.elementToBlock;
                }
                
                element.removeAttr("style");
            }
        });
	};
    
}( io.saw.BlockUI = io.saw.BlockUI || {}, io.saw.jQuery || jQuery ));
</script>  