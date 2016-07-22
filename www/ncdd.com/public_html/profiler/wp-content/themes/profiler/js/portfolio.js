function tz_init(defaultwidth){
    var contentWidth    = jQuery('#TzContent').width();
    var columnWidth     = defaultwidth;
    var curColCount     = 0;
    var maxColCount     = 0;
    var newColCount     = 0;
    var newColWidth     = 0;
    var featureColWidth = 0;
    curColCount = Math.floor(contentWidth / columnWidth);
    maxColCount = curColCount + 1;
    if((maxColCount - (contentWidth / columnWidth)) > ((contentWidth / columnWidth) - curColCount)){
        newColCount     = curColCount;
    }
    else{
        newColCount = maxColCount;
    }

    newColWidth = contentWidth;
    featureColWidth = contentWidth;


    if(newColCount > 1){
        newColWidth = Math.floor(contentWidth / newColCount);
        featureColWidth = newColWidth * 2;
    }

    jQuery('.element').width(newColWidth);
    jQuery('.tz_item .TzPortfolioMedia').each(function(){
        jQuery(this).find('img').first().attr('width','100%');
    });

    jQuery('.tz_feature_item').width(featureColWidth);
    var $container = jQuery('#portfolio');
    $container.imagesLoaded(function(){
        $container.isotope({
            masonry:{
                columnWidth: newColWidth
            }
        });

    });

    TzTemplateResizeImage(jQuery('.tz-media-content'));

}

var p_width = parseInt( tzvar.width );
var resizeTimer = null;
jQuery(window).bind('load resize', function() {
    if (resizeTimer) clearTimeout(resizeTimer);
    resizeTimer = setTimeout("tz_init(p_width)", 100);
});

jQuery(document).ready(function(){


    var win_height = jQuery(window).height();

    jQuery('body').css('min-height',win_height+1);
    // create tag
    var cat_status = []; //var cat_status = [];
    jQuery('#portfolio .element').each(function(){
        var item_class = jQuery(this).attr('class');
        item_class = item_class.split(' ');

        for(var i = 0; i < item_class.length; i++){

            if(parseInt(item_class[i].indexOf(themeprefix), 10) === 0) {
                if(jQuery.inArray(item_class[i], cat_status)){
                    cat_status.push(item_class[i]);
                }
            }
        }
    });
    for(var index=0; index < cat_status.length; index++){
        jQuery('#filter a#' + cat_status[index]).removeClass('tzhide');
    }
    var $container = jQuery('#portfolio');
    $container.find('.element').css({opacity: 0});
    $container.imagesLoaded( function(){
        $container.find('.element').css({opacity: 1});
        tz_init(p_width);

    });
    function loadPortfolio(){
        var $optionSets = jQuery('#tz_options .option-set'),
            $optionLinks = $optionSets.find('a');
        $optionLinks.click(function(event){
            event.preventDefault();
            var $this = jQuery(this);
            // don't proceed if already selected
            if ( $this.hasClass('selected') ) {
                return false;
            }
            var $optionSet = $this.parents('.option-set');
            $optionSet.find('.selected').removeClass('selected');
            $this.addClass('selected');

            // make option object dynamically, i.e. { filter: '.my-filter-class' }
            var options = {},
                key = $optionSet.attr('data-option-key'),
                value = $this.attr('data-option-value');

            // parse 'false' as false boolean
            value = value === 'false' ? false : value;
            options[ key ] = value;

            if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
                // changes in layout modes need extra logic
                changeLayoutMode( $this, options );
            } else {
                // otherwise, apply new options
                $container.isotope( options );
            }
            return false;
        });
    }
    loadPortfolio();
}) ;

jQuery(function(){

    var $container = jQuery('#portfolio'),
        $scroll = true;

    jQuery('#tz_append').css({'border':0,'background':'none'});

    $container.infinitescroll({
            navSelector  : '#loadaj a',    // selector for the paged navigation
            nextSelector : '#loadaj a:first',  // selector for the NEXT link (to page 2)
            itemSelector : '.element',     // selector for all items you'll retrieve
            errorCallback: function(){
                jQuery('#tz_append').removeAttr('style').html('<a class="btn btn-primary btn-embossed btn-cyan">'+tzvar.text+'</a>');
                jQuery('#tz_append a').addClass('tzNomore');
            },
            loading: {
                msgText:'',
                finishedMsg: '',
                img:tzvar.image,
                selector: '#tz_append'
            }
        },
        // call Isotope as a callback
        function( newElements ) {

            var $newElems =   jQuery( newElements ).css({ opacity: 0 }),
                $bool = true;


            // ensure that images load before adding to masonry layout
            $newElems.imagesLoaded(function(){

                // show elems now they're ready
                $newElems.animate({ opacity: 1 });

                tz_init(p_width);

                // trigger scroll again
                $container.isotope( 'appended', $newElems);


                //if there still more item
                if($newElems.length){

                    //move item-more to the end
                    jQuery('div#tz_append').find('a:first').show();
                }
            });
            // create tag
            var cat_status = []; //var cat_status = [];
            jQuery('#portfolio .element').each(function(){
                var item_class = jQuery(this).attr('class');
                item_class = item_class.split(' ');

                for(var i = 0; i < item_class.length; i++){

                    if(parseInt(item_class[i].indexOf(themeprefix), 10) === 0) {
                        if(jQuery.inArray(item_class[i], cat_status)){
                            cat_status.push(item_class[i]);
                        }
                    }
                }
            });
            for(var index=0; index < cat_status.length; index++){
                jQuery('#filter a#' + cat_status[index]).removeClass('tzhide');
            }
            $scroll = true;
        }
    );

    jQuery(window).scroll(function(){
        jQuery(window).unbind('.infscr');
        if($scroll){
            if((jQuery(window).scrollTop() + jQuery(window).height()) >= (jQuery(document).height() - 50)){
                $scroll	= false;
                $container.infinitescroll('retrieve');
            }
        }
    });

});