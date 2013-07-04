<script type="text/javascript">
(function( Template, $, undefined ) {
	Template.conf = {};
	Template.init = function(conf){
		this.conf.uploadUrl = conf.uploadUrl || '';
		this.conf.extractUrl = conf.extractUrl || '';
		this.conf.insertDBUrl = conf.insertDBUrl || '';
		this.conf.processHTMLUrl = conf.processHTMLUrl || '';
	};
	Template.getExtract = function(index,formElementId){
		var dfd = new $.Deferred();
		io.saw.FormGet.activate({postUrl:this.conf.extractUrl
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				var output = '';
				$.each(responseObj.elements, function(key, value){
					output=io.saw.FormElements.render(key, value);
					$(formElementId).find('#tab'+(index+1)).find('form').append(output);
				})
				dfd.resolve();
			}
		});
		return dfd.promise();
	};
	Template.doExtract = function(){
		return io.saw.FormPost.activate({formName:'#form_wizard'
			,postUrl:this.conf.extractUrl
		   	,serializeSelector:':input'
		   	,postOnComplete:function(responseObj,responseStatus){}
		   	,postOnSuccess:function(responseObj){
		      
		   	}
		});
	};
	Template.getInsertDB = function(index,formElementId){
		return io.saw.FormGet.activate({postUrl:this.conf.insertDBUrl
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				var output = '';
				$.each(responseObj.elements, function(key, value){
					output=io.saw.FormElements.renderReadOnly(key, value,false);
					$(formElementId).find('#tab'+(index+1)).find('form').append(output);
				})
					
			}
		});		
	};
	Template.doInsertDB = function(){
		
		return io.saw.FormPost.activate({formName:'#form_wizard'
			,postUrl:this.conf.insertDBUrl
		   	,serializeSelector:':input'
		   	,postOnComplete:function(responseObj,responseStatus){}
		   	,postOnSuccess:function(responseObj){
		      
		   	}
		});
		
	};
	Template.getProcessHTML = function(index,formElementId){
		return io.saw.FormGet.activate({postUrl:this.conf.processHTMLUrl
			,postOnComplete:function(responseObj,responseStatus){}
			,postOnSuccess:function(responseObj){
				var output = '';
				$.each(responseObj.elements, function(key, value){
					output=io.saw.FormElements.renderReadOnly(key, value,false);
					$(formElementId).find('#tab'+(index+1)).find('form').append(output);
				})
			}
		});		
	};
	Template.doProcessHTML = function(){
		return io.saw.FormPost.activate({formName:'#form_wizard'
			,postUrl:this.conf.processHTMLUrl
		   	,serializeSelector:':input'
		   	,postOnComplete:function(responseObj,responseStatus){}
		   	,postOnSuccess:function(responseObj){
		      
			}
		});
	};
}( io.saw.Template = io.saw.Template || {}, io.saw.jQuery || jQuery ));
</script>