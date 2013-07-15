<script type="text/javascript">
(function( FileUpload, $, undefined ) {

	var params = {};
	
	FileUpload.init = function(p){
		params = p; 
        params.maxNumberOfFiles = params.maxNumberOfFiles || 1;
	    params.formId = params.formId || '';
	    params.uploadURL = params.uploadURL || '';
	    params.onLoad = params.onLoad || function(){};
	    params.onSend = params.onSend || function(){};
		params.onDone = params.onDone || function(){};
		params.onFail = params.onFail || function(){};
		params.onAlways = params.onAlways || function(){};

		// Initialize the jQuery File Upload widget:
        $(params.formId).fileupload({
            url: params.uploadURL
            ,acceptFileTypes:'/(\.|\/)(gif|jpe?g|png)$/i'
            ,maxNumberOfFiles:params.maxNumberOfFiles
        }).bind('fileuploadsend',function (e,data){
        	params.onSend(e,data);
        }).bind('fileuploaddone',function (e,data){
        	params.onDone(e,data);
        }).bind('fileuploadfail',function (e,data){
        	params.onFail(e,data);
        }).bind('fileuploadalways',function (e,data){
        	params.onAlways(e,data);
        })
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: params.uploadURL
                ,type: 'HEAD'
            }).fail(function () {
                $('<span class="alert alert-error"/>')
                    .text('Upload server currently unavailable - ' +
                    new Date())
                    .appendTo(params.formId);
            });
        }

        // initialize uniform checkboxes  
        App.initUniform('.fileupload-toggle-checkbox');
        params.onLoad();
	}


}( io.saw.FileUpload = io.saw.FileUpload || {}, io.saw.jQuery || jQuery ));
</script>