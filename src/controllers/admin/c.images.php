<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
		$image = $app['imageFactory']($doc['context'],$doc['belongsTo']);
		$image->setRequest($request);
		$image->prepareFile();
        // image sanity check
        if(!empty($uri)) {
            $image_type = exif_imagetype($image->getFilePath());
            if($image_type != IMAGETYPE_GIF && $image_type != IMAGETYPE_JPEG && $image_type != IMAGETYPE_PNG){
        		throw new Saw\Model\Exceptions\DomainException('Please choose an image with one of the following formats: JPG, GIF, or PNG.');
			}		
        }
        $app['upload-mongo']->saveImage($image);
		

		$response_arr = array('files'=>array(0=>array('name'=>$image->getUploadedFileName()
														,'size'=>$image->getUploadedFileSize()
														,'thumbnail_url'=>$app['getImageURL']($image,'small')
														,'delete_type'=>"GET"
														,'delete_url'=>"/image/delete/".$image->context."/".$image->belongsTo)));
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
	$image = $app['imageFactory']($doc['context'],$doc['belongsTo']);
  
    $app['upload-mongo']->cropImage($doc['x'],$doc['y'],$doc['w'],$doc['h'],$doc['imageId'],$image,$doc['size']);
	$image = $image->__toArray();
	return new Response(json_encode(array('imageUrl'=>$image['urls'][$doc['size']]['CDN'].'?v='.time(), 'message'=>'success')), 200,array('Content-Type' => 'application/json'));	
})->method('POST')->before($mustbeMEMBER);

/////////////////////
// DELETE AN IMAGE //
/////////////////////
$app->get('/image/delete/{context}/{belongsTo}', function ($context, $belongsTo, Request $request) use ($app) {
	try {
		$belongsTo = new \MongoId($belongsTo);
		$deleteQuery = array('belongsTo'=>$belongsTo);
		$app['upload-mongo']->deleteByCriteria($deleteQuery);
		$parentObj = $app['imageParentFactory']($context,$belongsTo);
		$parentObj->image = array();
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
$app->get('/image/{context}/{belongsTo}/{size}', function ($context, $belongsTo, $size, Request $request) use ($app,$imgUnavailable) {
	$belongsTo = new \MongoId($belongsTo);
	$file_contents = $app['upload-mongo']->getImageByCriteria(array('belongsTo'=>$belongsTo, 'size'=>$size));
    if(!empty($file_contents)){
    	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
	}else{

		$file_contents = file_get_contents($imgUnavailable);
		return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));
	}
});


// prepares an image url 
$app['getImageURL'] = $app->protect(function ($image,$size,$ssl=false) { 
	$url = '';
    if(is_object($image)) $image = $image->__toArray();
    if(!empty($image) && !empty($image['base'])) {
        $base = ($ssl) ? $image['baseSSL'] : $image['base'];
        $url = $base.'/image/'.$image['context'].'/'.$image['belongsTo'].'/'.$size;
        if(!empty($image['modified'])) {
            $url.='?v='.$image['modified'];
        }
    }
    return $url;
});

$app['imageFactory'] = $app->protect(function ($context,$belongsTo) {
	switch ($context) {
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

	}
});
$app['imageParentFactory'] = $app->protect(function ($context,$belongsTo) use ($app) {
	switch ($context) {
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



	}
});
return $app;