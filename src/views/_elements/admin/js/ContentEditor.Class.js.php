<script type="text/javascript">
(function( ContentEditor, $, undefined ) {
    
    var params = {}
	
	ContentEditor.init = function(p){
        if(typeof p != 'undefined')
            params = p; 
        params.saveUrl = params.saveUrl || '/sawcms/sedit';
        params.currentElement = params.currentElement || undefined;
        params.currentSection = params.currentSection || '';
        params.currentPageid = params.currentPageid || '';
        params.postOnComplete = params.postOnComplete || function(){};
        params.postOnSuccess = params.postOnSuccess || function(){};
        params.postOnErrors = params.postOnErrors || function(){};
        params.contentEditableSelector = params.contentEditableSelector || 'body'; // the parent tag for all the contenteditable sections
        params.linkSelector = params.linkSelector || 'a'; // the selector to use to find all the clickable links. most likely will always be 'a' (anchor tag)
        
        
        // prepare the blur handler, which blocks the element and saves the content
		$(params.contentEditableSelector).on('blur', '[contenteditable]', function(event){
            io.saw.ContentEditor.save($(this));
        });
        // prepare the focus handler which saves the original content for an undo later
        $(params.contentEditableSelector).on('focus', '[contenteditable]', function(event){
            params.currentElement = $(this);
            params.currentContent = $(this).html();
            params.currentPageId = $(this).attr('data-pageid');
            params.currentSection = $(this).attr('data-section');
        });

        // prepare the anchor tag click event capture
        $(params.linkSelector).click(function(e) {
            e.stopPropagation();
            e.preventDefault();
            var link = $(this).attr('href');
            var value = $(this).html();
            var templateLink = true;
            $(this).parents().map(function () {
                if($(this).attr('contenteditable') !== undefined){
                    templateLink = false;
                }
            });
            console.log('templateLink:'+templateLink);
            console.log('link:'+link);
            console.log('value:'+value);
            $('#modal-edit-link .modal-body p').html(value);
            $('#modal-edit-link').modal({keyboard: false});
        });


        
	};

	ContentEditor.save = function(jQElement){
		
        var currElemHTML = params.currentElement.html();
        io.saw.BlockUI.block({elementToBlock:jQElement});
        var data = {
            "doc[section]":params.currentSection
            ,"doc[pageid]":params.currentPageId
            ,"doc[content]":currElemHTML
        }
        return $.post(
            params.saveUrl
            ,data
            ,"json"
        )
        .done(function(response){
            params.postOnSuccess(response);
        })
        .fail(function(response){
            var responseObj = jQuery.parseJSON(response.responseText);
            params.postOnErrors(jQuery.parseJSON(response.responseText),response.status);
        })
        .always(function(response){
            params.postOnComplete(jQuery.parseJSON(response.responseText),response.status);
            io.saw.BlockUI.unblock();
        });
	};
    ContentEditor.undo = function(){
    	params.currentElement.html(params.currentContent);
	};
    
}( io.saw.ContentEditor = io.saw.ContentEditor || {}, io.saw.jQuery || jQuery ));
io.saw.ContentEditor.init();
</script>  