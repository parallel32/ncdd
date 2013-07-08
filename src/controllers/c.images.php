<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Grapeword\Model;

$app['pushToCDN'] = $app->protect(function ($app,$imageId,$belongsTo,$belongsToType=null,$groups=array()) {
    $mongoId = (is_object($imageId)) ? $imageId : new \MongoId($imageId);
    $imageId = $mongoId->__toString();
    ///////////////////////////////////
    // get original image from mongo //
    ///////////////////////////////////
    sleep(1);
    // TO DO:  Get from primary //
    $imageObj 	= $app['upload-mongo']->getImageObject($imageId);
    $context 	= $imageObj->file['image']['context'];
    $sizes 		= $app['getImageSizes']($context);
    $imageId 	= $imageObj->file['_id']->__toString();
    $bytes 		= $imageObj->getBytes();

    $unique = time().rand(0,999999);
    $uri = '/tmp/'.$unique.'.png';
    file_put_contents($uri,$bytes);
    $bytes = null;
    
    // prepare S3
    $s3 = new \AmazonS3();
    $s3->path_style = true;
    $gw_cdn = str_replace('http://','',GW_CDN);
    $gw_cdn = str_replace('https://','',$gw_cdn);
    $bucket = $gw_cdn;
    
    $urls = array();
    $imageId = $belongsTo;
    $filename='images/'.$context.'/large/'.$imageId;
    $response = $s3->create_object($bucket, $filename, array(
        'fileUpload' 	=> $uri,
        'contentType' 	=> 'image/jpeg',
        'acl' 			=> \AmazonS3::ACL_PUBLIC,
        'storage'		=> \AmazonS3::STORAGE_REDUCED,
        'headers'		=> array( // raw headers
                             'Content-MD5' => md5($uri)
                           )
    ));
    if($response->isOK()):
        // create urls for the response
        $urls['large'] = GW_CDN.'/'.$filename;
    else:
        // throw exception... to be caught by c.images.php to be sent down as a failure response to upload_overlay_s3.php
        error_log('UploadWrapperS3::update::response::'.print_r($response,true));
    endif;
    
    if ($belongsToType == 'reward') {
        $reward = $app['mongo']->findOne('reward', array('_id'=>new \MongoId($belongsTo)), $fields=array('redemption'),$slaveOkay=true);
        $redemption = (isset($reward['redemption']) && !empty($reward['redemption'])) ? new Model\OfferRedemption($reward['redemption'],$app) : new Model\OfferRedemption(array(),$app);
    } else if ($belongsToType == 'offer') {
        $offer = $app['mongo']->findOne('offer', array('_id'=>new \MongoId($belongsTo)), $fields=array('redemption'),$slaveOkay=true);
        $redemption = (isset($offer['redemption']) && !empty($offer['redemption'])) ? new Model\OfferRedemption($offer['redemption'],$app) : new Model\OfferRedemption(array(),$app);
    }
    
    $imageObj = $app['imageFactory']($context,$imageId,$belongsTo,$belongsToType);
    $modelObj = $imageObj->instantiateParent($app,$context);
    //echo '<pre>'; print_r($imageObj); echo '</pre>'; exit;
    $modelObj->redemption = $redemption->__toArray();
    $modelObj->redemption['image'] = $imageObj->__toArray();
    $modelObj->saveSafe();
    return $urls;
});

$app->post('/images/upload', function (Request $request) use ($app, $checkPermissions) {
	try{
        $context = $app['request']->get('context');
		$belongsTo = $app['request']->get('belongsTo');
        $belongsToType = $app['request']->get('belongsToType');
        if(empty($belongsToType)) $belongsToType = 'offer';
		$image = $app['imageFactory']($context, $imageId='',$belongsTo,$belongsToType);
		$uri  = $app['request']->files->get('myPhoto')->getFileInfo()->getPathname();
        $image_type = -1;
        if(!empty($uri)) {
            $image_type = exif_imagetype($uri);
        }
        
		// add new
		switch ($image_type) {
			case IMAGETYPE_GIF:
			case IMAGETYPE_JPEG:
			case IMAGETYPE_PNG:
                $imageParams=array('max_width'=>800,'max_height'=>600);
                if ($context === 'barcode') {
                    $imageParams['max_width'] = 400;
                    $imageParams['max_height'] = 800;
                }
				$save_image_result = $app['upload-mongo']->saveImage($uri, $image_type, $image, $imageParams);
				if(array_key_exists('error',$save_image_result)){
					$app->abort(400,$save_image_result['error']);
				}
				break;
			default:
				$app->abort(400,'Please choose an image with one of the following formats: JPG, GIF, or PNG.');
				break;
		}
		
        $urls = array();
        if ($context == 'barcode') {
            if ($belongsToType == 'reward') {
                $reward = $app['mongo']->findOne('reward', array('_id'=>new \MongoId($belongsTo)), $fields=array('redemption'),$slaveOkay=true);
                $redemption = (isset($reward['redemption']) && !empty($reward['redemption'])) ? new Model\OfferRedemption($reward['redemption'],$app) : new Model\OfferRedemption(array(),$app);
                //echo '<pre>'; echo '<h3>Reward</h3>'; print_r($reward); echo '</pre>';
            } else if ($belongsToType == 'offer') {
                $offer = $app['mongo']->findOne('offer', array('_id'=>new \MongoId($belongsTo)), $fields=array('redemption'),$slaveOkay=true);
                $redemption = (isset($offer['redemption']) && !empty($offer['redemption'])) ? new Model\OfferRedemption($offer['redemption'],$app) : new Model\OfferRedemption(array(),$app);
               // echo '<pre>'; echo '<h3>Offer</h3>'; print_r($offer); echo '</pre>';
            }
            $modelObj = $image->instantiateParent($app,$context);
            $modelObj->redemption = $redemption->__toArray();
            $modelObj->redemption['image'] = $image->__toArray();
            $modelObj->saveSafe();

            $urls = $app['pushToCDN']($app,$image->imageId,$belongsTo,$belongsToType);
        } else {
            $modelObj = $image->instantiateParent($app,$context);
            //print_r($modelObj); exit;
            $modelObj->saveSafe();
        }
		$data = array('imageId'=>$image->imageId,'tmpUrl'=>'/tmp/image/'.$image->imageId, 'urls'=>$urls, 'belongsTo'=>$belongsTo);
		
		return new Response(json_encode(array('message'=>"Picture successfully uploaded",'data'=>$data)), 200,array('Content-Type' => 'application/json'));
		
	} catch (Grapeword\Exceptions\GrapewordException $e) {
		$http_status_code = $e->getHttpStatusCode();
		$abort_response = $e->getAbortResponse();  
		$app->abort($http_status_code, $abort_response);
	}
});

$app->get('/tmp/image/{id}', function ($id, Request $request) use ($app, $checkPermissions) {
	return new Response($app['upload-mongo']->getImage($id), 200, array('Content-Type' => 'image/jpeg'));
});

// receives crop params, crops, then resizes all the thumbnails in RAM and uploads to S3
// this has to be done all at once to ensure response to the upload control.
$app->post('/images/crop', function (Request $request) use ($app, $checkPermissions) {
	try{
		$context = $app['request']->get('context');
		$belongsTo = $app['request']->get('belongsTo');
		$imageId = $app['request']->get('imageId');
		$crop_options = $app['request']->get('doc');
		if(empty($imageId)){
			$app->abort(404,'We cannot find this image because the imageId is empty.');
		}
		
		///////////////////////////////////
		// get original image from mongo //
		///////////////////////////////////
		$imageObj 	= $app['upload-mongo']->getImageObject($imageId);
		$context 	= $imageObj->file['image']['context'];
		$sizes 		= $app['getImageSizes']($context);
		$imageId 	= $imageObj->file['_id']->__toString();
		$bytes 		= $imageObj->getBytes();
		
		$unique = time().rand(0,999999);
		$uri = '/tmp/'.$unique.'.png';
		file_put_contents($uri,$bytes);
		//sleep(1);
		$image_type = exif_imagetype($uri);
		
        // modify the old one -- begin
		switch ($image_type) {
            case IMAGETYPE_JPEG:
				$image = @imagecreatefromjpeg($uri);
                break;
            case IMAGETYPE_GIF:
				$image = @imagecreatefromgif($uri);
                break;
            case IMAGETYPE_PNG:
				$image = @imagecreatefrompng($uri);
                break;
        }
        
        $original_width = imagesx($image);
        $original_height = imagesy($image);            
        $original_aspect = (double)($original_width / $original_height);        
        
        if(empty($crop_options['crop'])) {
            // If crop options aren't set, go ahead and set up best crop for square.
            $crop_options['crop'] = array();
            if($original_aspect > 1) { //landscape
                $crop_options['crop']['y'] = 0;
                $crop_options['crop']['w'] = $crop_options['crop']['h'] = $original_height;
                $crop_options['crop']['x'] = intval(($original_width-$original_height)/2);
            } 
            else { //portrait
                $crop_options['crop']['x'] = 0;
                $crop_options['crop']['w'] = $crop_options['crop']['h'] = $original_width;
                $crop_options['crop']['y'] = 0; // 0 is a better guess for profile pictures        
            }
        }

        if(!empty($crop_options['crop'])) {        
            
            $imgScale = 1;
            
            if(!empty($crop_options['crop']['wmax'])) {
                $wmax = $crop_options['crop']['wmax'];
                $imgScale = $original_width/$wmax;                
            }
            elseif(!empty($crop_options['crop']['hmax'])) {
                $hmax = $crop_options['crop']['hmax'];
                $imgScale = $original_height/$hmax;                
            }
                        
            $x = intval($crop_options['crop']['x']*$imgScale);
            $y = intval($crop_options['crop']['y']*$imgScale);
            $w = intval($crop_options['crop']['w']*$imgScale);
            $h = intval($crop_options['crop']['h']*$imgScale);                     
//error_log('x:'.$x.' y:'.$y.' w:'.$w.' h:'.$h);
			//*
			$newWidth = $newHeight = 500; // arbitrary number .. not sure why it's hard coded TODO: find out!
            $new = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($new, $image, 0, 0, $x, $y, $newWidth, $newHeight, $w, $h);
			
			// prepare S3
			$s3 = new \AmazonS3();
			$s3->path_style = true;
			$gw_cdn = str_replace('http://','',GW_CDN);
			$gw_cdn = str_replace('https://','',$gw_cdn);
			$bucket = $gw_cdn;
			
			$imageId = $belongsTo;
			foreach($sizes as $key=>$size):
				
				$unique = time().rand(0,999999);
				$cropped_image_uri = '/tmp/'.$unique.'.png';
				switch ($image_type) {
		            case IMAGETYPE_JPEG:
						imagejpeg($new, $cropped_image_uri);
		                break;
		            case IMAGETYPE_GIF:
						imagegif($new, $cropped_image_uri);
		                break;
		            case IMAGETYPE_PNG:
						imagepng($new, $cropped_image_uri);
		                break;
		        }
				//sleep(1);
				$options = array('max_width'=>$size,'max_height'=>$size,'type'=>$image_type);
				$img_create = $app['upload-mongo']->create_scaled_image($cropped_image_uri,$options);
//error_log('cropped_image_uri:'.$cropped_image_uri);
				
				if ($img_create['status']) {
			    	// store the new one
					// s3 start //
					$filename='images/'.$context.'/'.$key.'/'.$imageId;
					$response = $s3->create_object($bucket, $filename, array(
						'fileUpload' 	=> $cropped_image_uri,
						'contentType' 	=> 'image/jpeg',
					    'acl' 			=> \AmazonS3::ACL_PUBLIC,
						'storage'		=> \AmazonS3::STORAGE_REDUCED,
						'headers'		=> array( // raw headers
						                          'Content-MD5' => md5($cropped_image_uri)
						          				)
					));
					if($response->isOK()):
						// create urls for the response
						$urls[$key] = GW_CDN.'/'.$filename.'?v='.time().rand();
					else:
						// throw exception... to be caught by c.images.php to be sent down as a failure response to upload_overlay_s3.php
						error_log('UploadWrapperS3::update::response::'.print_r($response,true));
					endif;
					// s3 end //
				} else {
		            $app->abort(500,$img_create['error']);
		        }
			endforeach; 
			
		}else{
			$app->abort(400,'Please send up the cropping variables.');
		}
		
		// prepare to re-save the new model object
		$imageObj = $app['imageFactory']($context,$imageId,$belongsTo);
		$modelObj = $imageObj->instantiateParent($app);
		$modelObj->saveSafe();
		
		return new Response(json_encode(array('message'=>"Picture successfully cropped and sent to CDN. Urls present in the response indicates which images made it to the CDN successfully.",
											'data'=>$urls)), 200,array('Content-Type' => 'application/json'));
		
	} catch (Grapeword\Exceptions\GrapewordException $e) {
		$http_status_code = $e->getHttpStatusCode();
		$abort_response = $e->getAbortResponse();  
		$app->abort($http_status_code, $abort_response);
	}
});
return $app;