<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Saw\Model;
///////////////////////////////
// RECEIVE THE UPLOADED FILE //
///////////////////////////////
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
														,'type'=>'zip'
														,'delete_type'=>"GET"
														,'delete_url'=>SAW_SERVER_PUBLIC_URL."/images/delete-uploaded-file/".$doc['belongsTo'])));
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
})->method('POST');
$app->match('/image/upload', function (Request $request) use ($app) {
		$response_arr = array('files'=>array(0=>array('name'=>'','size'=>0,'type'=>'')));
		return new Response(json_encode($response_arr), 200,array('Content-Type' => 'application/json'));	
})->method('HEAD|GET');
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






$app->get('/tmp/image/{id}', function ($id, Request $request) use ($app) {
	return new Response($app['upload-mongo']->getImage($id), 200, array('Content-Type' => 'image/jpeg'));
});


/* Gets image URLs in PHP. This also exists as a js function client side. 
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

$app['imageFactory'] = $app->protect(function ($context,$belongsTo) {
	switch ($context) {
		case 'seminar':
			return new Model\ImageSeminar($belongsTo);
			break;
	}
});





$app->get('/{file_path}', function ($file_path, Request $request) use ($app) {
	
	$regex = new \MongoRegex('/'.addcslashes($file_path,'/').'/i');
    $query = array('siteKey'=>SAW_SITE_KEY,'filename'=>$regex);
    $fields=array('filename','_id');
    $gridFSFile = $app['mongo']->gridfsfindOne('userland-images-and-files', $query, $fields, $slaveOkay=false);

    $file_contents = $app['mongo']->getFile($gridFSFile->file['_id'], 'domain');

	return new Response($file_contents, 200, array('Content-Type' => 'image/jpeg'));

})->assert('file_path','.+');

return $app;