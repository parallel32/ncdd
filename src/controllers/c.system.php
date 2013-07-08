<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Saw\Model;
use dflydev\markdown\MarkdownParser;

// Logic for validating model fields
$app['validateModel'] = $app->protect(function ($app,$model,$groups=array()) {
	if(!empty($groups))
		$violations = $app['validator']->validate($model,$groups);
	else
		$violations = $app['validator']->validate($model);
	if(is_object($violations) && count($violations)>0):
		foreach ($violations as $violation):
			$fields[] = array('name'=>$violation->getPropertyPath(),
							  'message'=>$violation->getMessage(),
							  'invalid_value'=>$violation->getInvalidValue());
		endforeach;
		throw new Saw\Model\Exceptions\DomainException($model::$invalidFieldsMessage, $fields);
	endif;	
});


/////////////////////
// IMAGE FUNCTIONS //
/////////////////////
/* Gets image URLs in PHP. This also exists as a js function client side. 
 * TODO: broke_offer.png?
 */
$app['getImageURL'] = $app->protect(function ($image,$size,$brokenImage='/assets/img/broke_offer.png',$ssl=false) { 
    $url = $brokenImage;    
    if(is_object($image)) $image = $image->__toArray();
    if(!empty($image) && !empty($image['base'])) {
        $base = ($ssl) ? $image['baseSSL'] : $image['base'];
        $url = $base.'/'.$image['context'].'/'.$size.'/'.$image['imageId'];
        if(!empty($image['modified'])) {
            $url.='?v='.$image['modified'];
        }
    }
    return $url;
});

$app['imageFactory'] = $app->protect(function ($context,$imageId,$belongsTo,$belongsToType=null) {
	switch ($context) {
		case 'consumer':
			return new Model\ImageConsumer($imageId,$belongsTo);
			break;
		case 'offer':
            return new Model\ImageOffer($imageId,$belongsTo,$context);
			break;
        case 'barcode':
			return new Model\ImageBarcode($imageId,$belongsTo,$context,$belongsToType);
			break;
        case 'contest':
			return new Model\ImageContest($imageId,$belongsTo,$context);
			break;        
		case 'profile':
			return new Model\ImageProfile($imageId,$belongsTo);
			break;
	}
});

$app['getImageSizes'] = $app->protect(function ($context) {
    switch ($context) {
        case 'barcode':
            return array('small'=>50, 'large'=>200);
            break;
        case 'offer':
        case 'consumer':
        case 'contest':
        case 'profile':
            return array('small'=>50, 'medium'=>150, 'large'=>250, 'full'=>500);
            break;
        case 'qr-grape':
        case 'qr-merchant':
        case 'qr-merchant':
        case 'qr-setup':
        case 'qr-offer':
        case 'qr-profile':
            return array('small'=>150, 'large'=>300);
            break;
    }
}); 
return $app;