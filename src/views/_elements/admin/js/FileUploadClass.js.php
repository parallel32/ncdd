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
        params.onFileAddToQueue = params.onFileAddToQueue || function(){};
		params.acceptFileTypes = params.acceptFileTypes || '/(\.|\/)(gif|jpe?g|png)$/i';

		// Initialize the jQuery File Upload widget:
        $(params.formId).fileupload({
            url: params.uploadURL
            ,acceptFileTypes:params.acceptFileTypes
            ,maxNumberOfFiles:params.maxNumberOfFiles
            ,previewMaxWidth:600
            ,previewMaxHeight:400
        }).bind('fileuploadsend',function (e,data){
        	params.onSend(e,data);
        }).bind('fileuploaddone',function (e,data){
        	params.onDone(e,data);
        }).bind('fileuploadfail',function (e,data){
        	params.onFail(e,data);
        }).bind('fileuploadalways',function (e,data){
            params.onAlways(e,data);
        }).bind('fileuploadadd',function (e,data){
            params.onFileAddToQueue(e,data);        	
        }).bind('fileuploaddestroy', function (e, data) {/* ... */})
        .bind('fileuploaddestroyed', function (e, data) {/* ... */})
        .bind('fileuploadadded', function (e, data) {/* ... */})
        .bind('fileuploadsent', function (e, data) {/* ... */})
        .bind('fileuploadcompleted', function (e, data) {/* ... */})
        .bind('fileuploadfailed', function (e, data) {/* ... */})
        .bind('fileuploadfinished', function (e, data) {/* ... */})
        .bind('fileuploadstarted', function (e) {/* ... */})
        .bind('fileuploadstopped', function (e) {/* ... */});
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