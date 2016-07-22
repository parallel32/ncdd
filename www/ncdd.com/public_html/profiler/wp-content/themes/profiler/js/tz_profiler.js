/**
 * Created with JetBrains PhpStorm.
 * User: Administrator
 * Date: 7/2/13
 * Time: 1:34 PM
 * To change this template use File | Settings | File Templates.
 */

function TzTemplateResizeImage(obj){


    var widthStage;
    var heightStage ;
    var widthImage;
    var heightImage;
    obj.each(function (i,el){

        var featureboolean = jQuery(el).find('.TzPortfolioMedia').hasClass('TZPorfolioMedium');
       if(featureboolean == true){
           heightStage = jQuery(el).find('.TZPorfolioMedium').height();
       }
        if(featureboolean == false){

            heightStage = jQuery(this).parent('.TzInner').height();

        }
       jQuery(this).find('.Center-Container-feature').css('height',heightStage+'px');


        widthStage = jQuery (this).width();
//        heightStage = jQuery (this).height();
//        widthImage = jQuery(this).find('img').width();


//        heightImage = jQuery(this).find('img').height();
        var img_url = jQuery(this).find('img').attr('src');

        var image = new Image();
        image.src = img_url;
        image.onload = function() {
//            console.log(image.naturalWidth);
//            console.log(image.naturalHeight);
        }

        widthImage = image.naturalWidth;
        heightImage = image.naturalHeight;

//        console.log(widthImage +'.........'+ heightImage );
        //alert(widthStage);

        //alert(widthImage + ' ' + heightImage + ' ' + widthStage + ' ' + mediaHeight);
//        alert(mediaHeight);

        var tzimg	=	new resizeImage(widthImage, heightImage, widthStage, heightStage);
        //alert(tzimg.top,tzimg.left);
        jQuery(this).find('img').css ({ top: tzimg.top, left: tzimg.left, width: tzimg.width, height: tzimg.height });
    });

}
function TzItemBlogHeight(obj){
    obj.each(function (i,el){
        var blogitem_height = jQuery(el).find('.TzItem ').height();
        jQuery(this).find('.Center-Container-feature').height(blogitem_height);
    });
}



