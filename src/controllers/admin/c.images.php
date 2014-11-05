<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Saw\Model;
///////////////////////////////
// RECEIVE THE UPLOADED FILE //
///////////////////////////////
$imgUnavailable = './../../../www/admin.ncdd.com/public_html/assets/img/404-250.jpg';
$profileImgUnavailable = './../../../www/admin.ncdd.com/public_html/assets/img/404-profile-159.png';
$placeholder = './../../../www/admin.ncdd.com/public_html/assets/img/placeholder.jpg';
$app->match('/image/upload', function (Request $request) use ($app) {
	$doc = $app['request']->get('doc');
	if(empty($doc['belongsTo'])){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a record id (belongsTo).  Please try again.");
	}
	try {
		if(array_key_exists('parentAttr', $doc)){
			$image = $app['imageFactory']($doc['context'],$doc['belongsTo'],$doc['parentAttr']);
		}else{
			$image = $app['imageFactory']($doc['context'],$doc['belongsTo']);
		}

		//error_log('image/upload image from factory:'.print_r($image,true));
		$image->setRequest($request);
		$image->prepareFile();
        
        if(array_key_exists('filetype', $doc) && $doc['filetype'] == 'file'){
        	$app['upload-mongo']->saveFile($image);
		}else{
			// image sanity check
	        if(!empty($uri)) {
	            $image_type = exif_imagetype($image->getFilePath());
	            if($image_type != IMAGETYPE_GIF && $image_type != IMAGETYPE_JPEG && $image_type != IMAGETYPE_PNG){
	        		throw new Saw\Model\Exceptions\DomainException('Please choose an image with one of the following formats: JPG, GIF, or PNG.');
				}		
	        }
	        $app['upload-mongo']->saveImage($image);
		}
		if(property_exists($image, 'parentAttr')){
			$delete_url = "/image/delete/".$image->context."/".$image->belongsTo.'/'.$image->parentAttr;
			$parent_attr = $image->parentAttr;
		}else{
			$delete_url = "/image/delete/".$image->context."/".$image->belongsTo;	
			$parent_attr = '';
		}		
		$response_arr = array('files'=>array(0=>array('name'=>$image->getUploadedFileName()
														,'size'=>$image->getUploadedFileSize()
														,'thumbnail_url'=>$app['getImageURL']($image,'small')
														,'delete_type'=>"GET"
														,'delete_url'=>$delete_url)));
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));	
	} catch (Saw\Model\Exceptions\DomainException $e) {
		$fileName = $_FILES['file']['name'];
		$response_arr = array('files'=>array(0=>array('name'=>$fileName
													,'size'=>0
													,'type'=>''
													,'error'=>$e->getMessage()
													)));	
		// 200 response is needed for the javascript fileupload library so that it can display the error message.
		//Otherwise if it's 500 it will display the message Internal Server Error by default
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));	
	} catch (Exception $e) {
		$fileName = $_FILES['file']['name'];
		$response_arr = array('files'=>array(0=>array('name'=>$fileName
													,'size'=>0
													,'type'=>''
													,'error'=>$e->getMessage()
													)));	
		// 200 response is needed for the javascript fileupload library so that it can display the error message.
		//Otherwise if it's 500 it will display Internal Server Error by default
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));	
	}
})->method('POST')->before($mustbeMEMBER);
$app->match('/image/upload', function (Request $request) use ($app) {
		$response_arr = array('files'=>array(0=>array('name'=>'','size'=>0,'type'=>'')));
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));	
})->method('HEAD|GET')->before($mustbeMEMBER);
// HEAD is for the initial CORS request and POST is to receive the file
//...then HEAD stopped working but GET works as a response for the HEAD request
//...don't know why but I debugged it and silex was interpreting a HEAD request as GET in Symfony\Component\Routing\Matcher\UrlMather::match() function.
///////////////////////////////////////////////////////////////////////////
// NO JAVASCRIPT ENABLED NOTICE -- used by fileupload javascript library //
///////////////////////////////////////////////////////////////////////////
// will redirect the user to this page explaining javascript must be turned on
$app->get('/image/upload/nojavascript', function (Request $request) use ($app) {
	return $app['view']->render('errors/nojavascript', 'default', $view_vars);
});

///////////////////
// CROP AN IMAGE //
///////////////////
$app->match('/image/crop', function (Request $request) use ($app) {
	$doc = $app['request']->get('doc');
	if(empty($doc['belongsTo'])){
		throw new \Saw\Model\Exceptions\DomainException("You must pass up a record id (belongsTo).  Please try again.");
	}

	if(array_key_exists('parentAttr', $doc)){
		$image = $app['imageFactory']($doc['context'],$doc['belongsTo'],$doc['parentAttr']);
	}else{
		$image = $app['imageFactory']($doc['context'],$doc['belongsTo']);
	}
	
    $app['upload-mongo']->cropImage($doc['x'],$doc['y'],$doc['w'],$doc['h'],$doc['imageId'],$image,$doc['size']);
	$image = $image->__toArray();
	return new Response(json_encode(array('imageUrl'=>$image['urls'][$doc['size']]['CDN'].'?v='.time(), 'message'=>'success')), 200,array('Content-Type' => 'application/json'));	
})->method('POST')->before($mustbeMEMBER);

/////////////////////
// DELETE AN IMAGE //
/////////////////////
$app->get('/image/delete/{context}/{belongsTo}/{parentAttr}', function ($context, $belongsTo, $parentAttr, Request $request) use ($app) {
	try {
		$belongsTo = new \MongoId($belongsTo);
		if(!empty($parentAttr)){
			$deleteQuery = array('belongsTo'=>$belongsTo,'parentAttr'=>$parentAttr);
		}else{
			$deleteQuery = array('belongsTo'=>$belongsTo);
		}

		$app['upload-mongo']->deleteByCriteria($deleteQuery);
		$parentObj = $app['imageParentFactory']($context,$belongsTo);
		if(!empty($parentAttr)){
			$parentObj->{$parentAttr} = new \stdClass();
		}else{
			$parentObj->image = new \stdClass();
		}		
		$parentObj->saveEdit();
		return new Response('success', 200, array('Content-Type' => 'text/html'));	
	} catch (Exception $e) {
		$response_arr = array('files'=>array(0=>array('name'=>''
													,'size'=>0
													,'type'=>''
													,'error'=>$e->getMessage()
													)));	
		// 200 response is needed for the javascript fileupload library so that it can display the error message.
		//Otherwise if it's 500 it will display Internal Server Error by default
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));
	}
})
->value('parentAttr','')
->before($mustbeMEMBER);
///////////////////
// DELETE A FILE //
///////////////////
$app->get('/file/delete/{context}/{belongsTo}', function ($context, $belongsTo, Request $request) use ($app) {
	try {
		$belongsTo = new \MongoId($belongsTo);
		$deleteQuery = array('belongsTo'=>$belongsTo);
		$app['upload-mongo']->deleteByCriteria($deleteQuery);
		$parentObj = $app['imageParentFactory']($context,$belongsTo);
		$parentObj->file = new \stdClass();
		$parentObj->saveEdit();
		return new Response('success', 200, array('Content-Type' => 'text/html'));	
	} catch (Exception $e) {
		$response_arr = array('files'=>array(0=>array('name'=>''
													,'size'=>0
													,'type'=>''
													,'error'=>$e->getMessage()
													)));	
		// 200 response is needed for the javascript fileupload library so that it can display the error message.
		//Otherwise if it's 500 it will display Internal Server Error by default
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));
	}
})->before($mustbeMEMBER);
/////////////////////
// STREAM AN IMAGE //
/////////////////////
$app->get('/placeholder', function (Request $request) use ($app,$placeholder) {
    $file_contents = file_get_contents($placeholder);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
});
$app->get('/noimage', function (Request $request) use ($app,$imgUnavailable) {
    $file_contents = file_get_contents($imgUnavailable);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
});
$app->get('/noprofileimage', function (Request $request) use ($app,$profileImgUnavailable) {
    $file_contents = file_get_contents($profileImgUnavailable);
	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
});
$app->get('/images/{imageId}', function ($imageId, Request $request) use ($app,$imgUnavailable) {
    $file_contents = $app['upload-mongo']->getImage($imageId);
    if(!empty($file_contents))
		return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
	else{
		$file_contents = file_get_contents($imgUnavailable);
		return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
	}
});

$app->get('/image/{context}/{belongsTo}/{size}/{parentAttr}', function ($context, $belongsTo, $size, $parentAttr,Request $request) use ($app,$imgUnavailable) {
	$belongsTo = new \MongoId($belongsTo);
	if($context == 'drive'){
		$drive = new Model\Drive(array('_id'=>$belongsTo),$app);
		$drive = $drive->findById();

		$file_contents = $app['upload-mongo']->getImageByCriteria(array('belongsTo'=>$belongsTo, 'size'=>$size));
	    if(!empty($file_contents) && !empty($drive['file'])){
	    	$response = new Response($file_contents, 200, array('Content-Type' => 'application/octet-stream'));
	    	$filename = (!mb_detect_encoding($drive['file']['originalFileName'], 'ASCII', true)) ? preg_replace('/[[:^print:]]/', '', $drive['file']['originalFileName']): $drive['file']['originalFileName'];
	    	$filename = str_replace('/', '', $filename);
	    	$filename = str_replace('\\', '', $filename);
	    	$d = $response->headers->makeDisposition(
			    ResponseHeaderBag::DISPOSITION_ATTACHMENT,
			    $filename
			);
			$response->headers->set('Content-Disposition', $d);
	    	return $response;
		}if(!empty($file_contents) && !empty($drive['image'])){
			return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		}else{
			$file_contents = file_get_contents($imgUnavailable);
			return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		}
	}else{
		if(!empty($parentAttr)){
			$query = array('belongsTo'=>$belongsTo, 'size'=>$size,'parentAttr'=>$parentAttr);
			
		}else{
			$query = array('belongsTo'=>$belongsTo, 'size'=>$size);
		}
		$file_contents = $app['upload-mongo']->getImageByCriteria($query);
	    if(!empty($file_contents)){
	    	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		}else{

			$file_contents = file_get_contents($imgUnavailable);
			return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
		}	
	}
	
})->value('parentAttr','');

// prepares an image url 
$app['getImageURL'] = $app->protect(function ($image,$size,$ssl=false) { 
	$url = '';
    if(is_object($image)) $image = $image->__toArray();
    if(!empty($image) && !empty($image['base'])) {
        $base = ($ssl) ? $image['baseSSL'] : $image['base'];
        if(array_key_exists('parentAttr', $image) && !empty($image['parentAttr'])){
        	$url = $base.'/image/'.$image['context'].'/'.$image['belongsTo'].'/'.$size.'/'.$image['parentAttr'];
        }else{
        	$url = $base.'/image/'.$image['context'].'/'.$image['belongsTo'].'/'.$size;	
        }
        
        if(!empty($image['modified'])) {
            $url.='?v='.$image['modified'];
        }
    }
    return $url;
});

$app['imageFactory'] = $app->protect(function ($context,$belongsTo,$parentAttr='') {
	switch ($context) {
		case 'drive':
			return new Model\ImageDrive($belongsTo);
			break;
		case 'drivefile':
			return new Model\ImageDriveFile($belongsTo);
			break;
		case 'seminar':
			return new Model\ImageSeminar($belongsTo);
			break;
		case 'member':
			return new Model\ImageMember($belongsTo);
			break;
		case 'blog':
			return new Model\ImageBlog($belongsTo);
			break;
		case 'forum':
			return new Model\ImageForum($belongsTo);
			break;
		case 'topic':
			return new Model\ImageTopic($belongsTo);
			break;
		case 'product':
			return new Model\ImageProduct($belongsTo);
			break;
		case 'category':
			return new Model\ImageCategory($belongsTo);
			break;
		case 'stateseminar':
			return new Model\ImageStateSeminar($belongsTo);
			break;
		case 'delegate':
			return new Model\ImageDelegate($belongsTo,$parentAttr);
			break;

	}
});
$app['imageParentFactory'] = $app->protect(function ($context,$belongsTo) use ($app) {
	switch ($context) {
		case 'drive':
		case 'drivefile':
			return new Model\Drive(array('_id'=>$belongsTo),$app);
			break;
		case 'seminar':
			return new Model\Seminar(array('_id'=>$belongsTo),$app);
			break;
		case 'member':
			return new Model\Member(array('_id'=>$belongsTo),$app);
			break;
		case 'blog':
			return new Model\Blog(array('_id'=>$belongsTo),$app);
			break;
		case 'forum':
			return new Model\Forum(array('_id'=>$belongsTo),$app);
			break;
		case 'topic':
			return new Model\Topic(array('_id'=>$belongsTo),$app);
			break;
		case 'product':
			return new Model\Product(array('_id'=>$belongsTo),$app);
			break;
		case 'category':
			return new Model\Category(array('_id'=>$belongsTo),$app);
			break;
		case 'stateseminar':
			return new Model\StateSeminar(array('_id'=>$belongsTo),$app);
			break;
		case 'delegate':
			return new Model\Delegate(array('_id'=>$belongsTo),$app);
			break;

	}
});
return $app;